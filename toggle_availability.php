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

$tasker_id = $_SESSION['tasker_id'];

// Get current status
$stmt = $conn->prepare("SELECT is_available FROM taskers WHERE id = ?");
$stmt->bind_param("i", $tasker_id);
$stmt->execute();
$result = $stmt->get_result();
$tasker = $result->fetch_assoc();

$new_status = $tasker['is_available'] ? 0 : 1;

// Check what columns exist
$columns_check = $conn->query("SHOW COLUMNS FROM taskers");
$existing_columns = [];
while ($col = $columns_check->fetch_assoc()) {
    $existing_columns[] = $col['Field'];
}

// Build update query
$update_fields = "is_available = ?";
$params = [$new_status];
$types = "i";

if (in_array('last_online_at', $existing_columns)) {
    $update_fields .= ", last_online_at = NOW()";
}

if (in_array('is_available_for_urgent', $existing_columns)) {
    $update_fields .= ", is_available_for_urgent = ?";
    $params[] = $new_status;
    $types .= "i";
}

$update_fields .= " WHERE id = ?";
$params[] = $tasker_id;
$types .= "i";

$update_sql = "UPDATE taskers SET $update_fields";
$update_stmt = $conn->prepare($update_sql);

if ($update_stmt) {
    // Dynamically bind parameters
    $update_stmt->bind_param($types, ...$params);
    
    if ($update_stmt->execute()) {
        $_SESSION['success_message'] = $new_status ? "✅ You are now ONLINE! Available for urgent services." : "❌ You are now OFFLINE";
        
        // If going online, request location tracking
        if ($new_status) {
            $_SESSION['location_tracking_needed'] = true;
            
            // Optional: Try to get and update location immediately
            // This will be handled by JavaScript in the dashboard
        }
    } else {
        $_SESSION['error_message'] = "Failed to update status: " . $update_stmt->error;
    }
    $update_stmt->close();
} else {
    $_SESSION['error_message'] = "Failed to prepare update statement";
}

header("Location: tasker_dashboard.php");
exit();
?>