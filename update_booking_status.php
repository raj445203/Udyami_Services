<?php
session_start();
require_once 'db.php';

// Check if tasker is logged in
if (!isset($_SESSION['tasker_id'])) {
    header("Location: login_tasker.php");
    exit();
}

// CSRF Protection
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error_message'] = "Invalid request";
    header("Location: tasker_dashboard.php");
    exit();
}

$booking_id = intval($_POST['booking_id']);
$new_status = $_POST['status'];
$tasker_id = $_SESSION['tasker_id'];

// Verify booking belongs to this tasker
$check_sql = "SELECT id, status FROM bookings WHERE id = ? AND tasker_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $booking_id, $tasker_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows == 0) {
    $_SESSION['error_message'] = "Booking not found or unauthorized";
    header("Location: tasker_dashboard.php");
    exit();
}

$booking = $check_result->fetch_assoc();
$old_status = $booking['status'];

// Update booking status
$update_sql = "UPDATE bookings SET status = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("si", $new_status, $booking_id);

if ($update_stmt->execute()) {
    // If status is changed to Accepted, enable tracking
    if ($new_status == 'Accepted' && $old_status != 'Accepted') {
        $tracking_sql = "UPDATE bookings SET tracking_enabled = TRUE, tracking_started_at = NOW() WHERE id = ?";
        $tracking_stmt = $conn->prepare($tracking_sql);
        $tracking_stmt->bind_param("i", $booking_id);
        $tracking_stmt->execute();
        $tracking_stmt->close();
        
        $_SESSION['success_message'] = "Booking accepted! Tracking enabled. The user can now see your location.";
    } else {
        $_SESSION['success_message'] = "Booking status updated to: " . $new_status;
    }
} else {
    $_SESSION['error_message'] = "Failed to update booking status";
}

$update_stmt->close();
$check_stmt->close();

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>