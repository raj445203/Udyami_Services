<?php
session_start();
require 'db.php';

// Check if a tasker is logged in
if (!isset($_SESSION['tasker_id'])) {
    header("Location: login-tasker.php");
    exit();
}

// Ensure the request is a POST request and all necessary data is present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'], $_POST['status'])) {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['status'];
    $tasker_id = $_SESSION['tasker_id'];

    // Validate the new status to prevent invalid data
    $allowed_statuses = ['Accepted', 'Rejected', 'Completed'];
    if (!in_array($new_status, $allowed_statuses)) {
        header("Location: tasker_dashboard.php?status=error&message=Invalid status.");
        exit();
    }

    // Prepare and execute the query to update the booking status
    // The WHERE clause is critical to prevent a malicious user from updating another tasker's bookings
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ? AND tasker_id = ?");
    $stmt->bind_param("sii", $new_status, $booking_id, $tasker_id);

    if ($stmt->execute()) {
        // Success: Redirect back to the tasker dashboard with a success message
        header("Location: tasker_dashboard.php?status=success&message=Booking status updated!");
        exit();
    } else {
        // Error: Redirect with an error message
        header("Location: tasker_dashboard.php?status=error&message=Update failed.");
        exit();
    }

    $stmt->close();
} else {
    // If accessed directly without POST data
    header("Location: tasker_dashboard.php");
    exit();
}
$conn->close();
