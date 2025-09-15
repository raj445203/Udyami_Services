<?php
session_start();
require 'db.php'; // Database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page with a message
    header("Location: login.php?message=login_required");
    exit();
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $user_id = $_SESSION['user_id'];
    $tasker_id = $_POST['tasker_id'] ?? null;
    $booking_date = $_POST['booking_date'] ?? null;
    $booking_time = $_POST['booking_time'] ?? null;
    $booking_message = $_POST['booking_message'] ?? null;
    $status = 'Pending'; // Default status for a new booking

    // Validate input data
    if (!$tasker_id || !$booking_date || !$booking_time || !$booking_message) {
        // Redirect back with an error if data is missing
        header("Location: book.php?tasker_id=" . urlencode($tasker_id) . "&status=error&message=missing_data");
        exit();
    }

    // Combine date and time for database storage (optional, but good practice)
    $scheduled_datetime = $booking_date . ' ' . $booking_time;

    // Prepare and execute the SQL query to insert the booking request
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, tasker_id, scheduled_datetime, message, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $tasker_id, $scheduled_datetime, $booking_message, $status);

    if ($stmt->execute()) {
        // Successful booking: Redirect to the user's dashboard with a success message
        header("Location: dashboard.php?status=success&message=booking_sent");
        exit();
    } else {
        // Failed booking: Redirect back to the booking page with an error
        // In a real application, you'd log this error
        header("Location: booking.php?tasker_id=" . urlencode($tasker_id) . "&status=error&message=booking_failed");
        exit();
    }

    $stmt->close();
} else {
    // If the request method is not POST, redirect to a safe page or show an error
    header("Location: index.php");
    exit();
}
$conn->close();
