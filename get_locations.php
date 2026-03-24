<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id']) && !isset($_SESSION['tasker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated', 'session' => $_SESSION]);
    exit();
}

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

if (!$booking_id) {
    echo json_encode(['success' => false, 'message' => 'Booking ID required']);
    exit();
}

try {
    if (isset($_SESSION['tasker_id'])) {
        $tasker_id = $_SESSION['tasker_id'];
        
        // First, check if booking exists and belongs to this tasker
        $check_sql = "SELECT id, status, tracking_enabled, user_id FROM bookings WHERE id = ? AND tasker_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $booking_id, $tasker_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $booking_check = $check_result->fetch_assoc();
        
        if (!$booking_check) {
            echo json_encode(['success' => false, 'message' => 'Booking not found or unauthorized']);
            exit();
        }
        
        // Get user location
        $sql = "SELECT u.id, u.fullname, u.phone, 
                       u.current_latitude, u.current_longitude, u.last_location_update,
                       b.status, b.tracking_enabled
                FROM users u
                JOIN bookings b ON b.user_id = u.id
                WHERE b.id = ? AND b.tasker_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $booking_id, $tasker_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        
        if ($data) {
            // Get tasker's location to calculate distance
            $tasker_sql = "SELECT current_latitude, current_longitude FROM taskers WHERE id = ?";
            $tasker_stmt = $conn->prepare($tasker_sql);
            $tasker_stmt->bind_param("i", $tasker_id);
            $tasker_stmt->execute();
            $tasker_result = $tasker_stmt->get_result();
            $tasker = $tasker_result->fetch_assoc();
            
            $distance = null;
            if ($data['current_latitude'] && $tasker['current_latitude']) {
                $distance = calculateDistance(
                    $tasker['current_latitude'], $tasker['current_longitude'],
                    $data['current_latitude'], $data['current_longitude']
                );
            }
            
            $response = [
                'success' => true,
                'booking' => [
                    'id' => $booking_id,
                    'user_id' => $data['id'],
                    'user_name' => $data['fullname'],
                    'user_phone' => $data['phone'],
                    'current_latitude' => $data['current_latitude'],
                    'current_longitude' => $data['current_longitude'],
                    'last_location_update' => $data['last_location_update'],
                    'status' => $data['status'],
                    'tracking_enabled' => $data['tracking_enabled']
                ],
                'distance' => $distance,
                'can_track' => in_array($data['status'], ['Accepted', 'in_progress', 'assigned']) && $data['tracking_enabled'],
                'debug' => [
                    'tasker_location' => $tasker,
                    'user_location' => ['lat' => $data['current_latitude'], 'lng' => $data['current_longitude']]
                ]
            ];
            
            echo json_encode($response);
        } else {
            echo json_encode(['success' => false, 'message' => 'No data found']);
        }
        
        $stmt->close();
        
    } else {
        echo json_encode(['success' => false, 'message' => 'Not a tasker']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $R * $c;
}

$conn->close();
?>