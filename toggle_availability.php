<?php
session_start();
require 'db.php';

if (!isset($_SESSION['tasker_id'])) {
    header("Location: login_tasker.php");
    exit();
}

// CSRF check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token");
}

$tasker_id = $_SESSION['tasker_id'];

// Toggle availability
$stmt = $conn->prepare("
    UPDATE taskers 
    SET is_available = NOT is_available,
        last_available_at = NOW()
    WHERE id = ?
");
$stmt->bind_param("i", $tasker_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: tasker_dashboard.php?tab=dashboard");
exit();
