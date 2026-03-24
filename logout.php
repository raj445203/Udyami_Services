<?php
// logout.php
session_start();

// Store user info for message before clearing
$user_name = $_SESSION['user_name'] ?? 'User';

// Unset user-specific session variables
unset($_SESSION['user_id']);
unset($_SESSION['user_logged_in']);
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);
unset($_SESSION['fullname']);

// Keep tasker session if exists
// Do NOT use session_destroy()

// Set success message
$_SESSION['user_logout_message'] = "Goodbye, $user_name! You have been logged out successfully.";

// Redirect to login page
header("Location: login.html");
exit();
?>