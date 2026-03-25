<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Check if tasker is logged in
if (!isset($_SESSION['tasker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$tasker_id = $_SESSION['tasker_id'];

// Get last checked timestamp from session or use default
$last_check = isset($_SESSION['last_booking_check']) ? $_SESSION['last_booking_check'] : date('Y-m-d H:i:s', strtotime('-5 minutes'));

// Count new bookings since last check
$sql = "SELECT COUNT(*) as new_count, 
               (SELECT COUNT(*) FROM bookings WHERE tasker_id = ? AND status = 'Pending') as total_pending
        FROM bookings 
        WHERE tasker_id = ? AND status = 'Pending' AND created_at > ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $tasker_id, $tasker_id, $last_check);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Update last check time
$_SESSION['last_booking_check'] = date('Y-m-d H:i:s');

// Get new bookings details
$new_bookings = [];
if ($data['new_count'] > 0) {
    $details_sql = "SELECT b.id, b.service_type, u.fullname as customer_name, b.created_at
                    FROM bookings b
                    JOIN users u ON b.user_id = u.id
                    WHERE b.tasker_id = ? AND b.status = 'Pending' AND b.created_at > ?
                    ORDER BY b.created_at DESC";
    $details_stmt = $conn->prepare($details_sql);
    $details_stmt->bind_param("is", $tasker_id, $last_check);
    $details_stmt->execute();
    $details_result = $details_stmt->get_result();
    while ($row = $details_result->fetch_assoc()) {
        $new_bookings[] = $row;
    }
    $details_stmt->close();
}

echo json_encode([
    'success' => true,
    'new_bookings' => $data['new_count'],
    'total_pending' => $data['total_pending'],
    'bookings' => $new_bookings
]);

$stmt->close();
$conn->close();
?>