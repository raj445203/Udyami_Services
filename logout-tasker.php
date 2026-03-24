<?php
// logout-tasker.php
session_start();

// Store tasker info for message before clearing
$tasker_name = $_SESSION['tasker_name'] ?? 'Tasker';

// Unset tasker-specific session variables
unset($_SESSION['tasker_id']);
unset($_SESSION['tasker_logged_in']);
unset($_SESSION['tasker_name']);
unset($_SESSION['tasker_email']);

// Keep user session if exists
// Do NOT use session_destroy()

// Set success message for tasker
$_SESSION['tasker_logout_message'] = "Goodbye, $tasker_name! You have been logged out from tasker account.";

// Redirect to tasker login page
header("Location: login_tasker.php");
exit();
?>