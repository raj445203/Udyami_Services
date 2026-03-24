<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['tasker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$tasker_id = $_SESSION['tasker_id'];
$input = json_decode(file_get_contents('php://input'), true);
$urgent_request_id = $input['request_id'] ?? 0;
$booking_id = $input['booking_id'] ?? 0;

if (!$urgent_request_id || !$booking_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

// Check if tasker is online
$tasker_check = $conn->prepare("SELECT is_available FROM taskers WHERE id = ?");
$tasker_check->bind_param("i", $tasker_id);
$tasker_check->execute();
$tasker = $tasker_check->get_result()->fetch_assoc();

if (!$tasker['is_available']) {
    echo json_encode(['success' => false, 'message' => 'You need to be online to accept urgent requests']);
    exit();
}

// Update booking with tasker
$conn->begin_transaction();

try {
    // Update booking
    $update_booking = $conn->prepare("UPDATE bookings SET tasker_id = ?, status = 'accepted', accepted_at = NOW() WHERE id = ?");
    $update_booking->bind_param("ii", $tasker_id, $booking_id);
    $update_booking->execute();
    
    // Update urgent request
    $update_urgent = $conn->prepare("UPDATE urgent_booking_requests SET tasker_id = ?, status = 'accepted' WHERE id = ?");
    $update_urgent->bind_param("ii", $tasker_id, $urgent_request_id);
    $update_urgent->execute();
    
    // Enable tracking for this booking
    $enable_tracking = $conn->prepare("UPDATE bookings SET tracking_enabled = TRUE, tracking_started_at = NOW() WHERE id = ?");
    $enable_tracking->bind_param("i", $booking_id);
    $enable_tracking->execute();
    
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Booking accepted successfully!',
        'tracking_url' => "track-booking.php?id=$booking_id"
    ]);
    
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Failed to accept booking']);
}
?>