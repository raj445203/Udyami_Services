<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$radius = isset($_GET['radius']) ? floatval($_GET['radius']) : 10; // Default 10 km

try {
    // Get user's current location
    $sql = "SELECT latitude, longitude FROM user_locations WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_location = $result->fetch_assoc();
    
    if (!$user_location) {
        echo json_encode(['success' => false, 'message' => 'User location not found. Please enable location services.']);
        exit();
    }
    
    $lat = $user_location['latitude'];
    $lng = $user_location['longitude'];
    
    // Get nearby active taskers with their locations
    $sql = "SELECT 
                t.id, 
                t.full_name, 
                t.skills, 
                t.rating, 
                t.profile_image,
                t.hourly_rate,
                t.total_bookings,
                tl.latitude, 
                tl.longitude, 
                tl.last_update,
                tl.is_active,
                (
                    6371 * acos(
                        cos(radians(?)) * 
                        cos(radians(tl.latitude)) * 
                        cos(radians(tl.longitude) - radians(?)) + 
                        sin(radians(?)) * 
                        sin(radians(tl.latitude))
                    )
                ) AS distance
            FROM taskers t
            INNER JOIN tasker_locations tl ON t.id = tl.tasker_id
            WHERE t.approval_status = 'approved' 
            AND t.availability_status = 'available'
            AND tl.is_active = 1
            AND tl.last_update >= DATE_SUB(NOW(), INTERVAL 10 MINUTE)
            HAVING distance < ?
            ORDER BY distance ASC
            LIMIT 50";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dddd", $lat, $lng, $lat, $radius);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $taskers = [];
    while ($row = $result->fetch_assoc()) {
        $row['distance'] = round($row['distance'], 2);
        $row['time_ago'] = time_elapsed_string($row['last_update']);
        $row['profile_image'] = $row['profile_image'] ?: 'images/default-avatar.png';
        $taskers[] = $row;
    }
    
    echo json_encode([
        'success' => true, 
        'taskers' => $taskers, 
        'user_location' => $user_location,
        'total' => count($taskers)
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

// Helper function to show time elapsed
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

$conn->close();
?>