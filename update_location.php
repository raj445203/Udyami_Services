<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['user_id']) && !isset($_SESSION['tasker_id'])) {
    $response['message'] = 'Not authenticated';
    echo json_encode($response);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$latitude = isset($input['latitude']) ? floatval($input['latitude']) : null;
$longitude = isset($input['longitude']) ? floatval($input['longitude']) : null;

if (!$latitude || !$longitude) {
    $response['message'] = 'Invalid coordinates';
    echo json_encode($response);
    exit();
}

try {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE users SET current_latitude = ?, current_longitude = ?, last_location_update = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddi", $latitude, $longitude, $user_id);
        
    } elseif (isset($_SESSION['tasker_id'])) {
        $tasker_id = $_SESSION['tasker_id'];
        $sql = "UPDATE taskers SET current_latitude = ?, current_longitude = ?, last_location_update = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddi", $latitude, $longitude, $tasker_id);
    }
    
    if ($stmt && $stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Location updated';
        
        // For taskers, also update the booking tracking
        if (isset($_SESSION['tasker_id'])) {
            $update_booking = $conn->prepare("UPDATE bookings SET last_tasker_location_update = NOW() WHERE tasker_id = ? AND status IN ('Accepted', 'in_progress')");
            $update_booking->bind_param("i", $tasker_id);
            $update_booking->execute();
        }
        
    } else {
        $response['message'] = 'Database error';
    }
    
    if ($stmt) $stmt->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
$conn->close();
?>