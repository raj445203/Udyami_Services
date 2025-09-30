<?php
session_start();
header('Content-Type: application/json');

// Check for user login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to book a tasker.']);
    exit();
}

require 'db.php';

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $tasker_id = $_POST['tasker_id'] ?? null;
    $booking_date = $_POST['booking_date'] ?? null;
    $booking_time = $_POST['booking_time'] ?? null;
    $booking_message = $_POST['booking_message'] ?? '';

    // Validate the input
    if ($tasker_id && $booking_date && $booking_time && $booking_message) {
        $scheduled_datetime = $booking_date . ' ' . $booking_time;

        $stmt = $conn->prepare("INSERT INTO bookings (user_id, tasker_id, scheduled_datetime, message) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iiss", $user_id, $tasker_id, $scheduled_datetime, $booking_message);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Booking request sent successfully!'];
            } else {
                $response = ['success' => false, 'message' => 'Database error: ' . $stmt->error];
            }
            $stmt->close();
        } else {
            $response = ['success' => false, 'message' => 'Database prepare error: ' . $conn->error];
        }
    } else {
        $response = ['success' => false, 'message' => 'All fields are required.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

$conn->close();
echo json_encode($response);
?>