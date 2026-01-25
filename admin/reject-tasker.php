<?php
session_start();
require 'db.php';

/* ================= ADMIN AUTH CHECK ================= */
// adjust this according to your admin login system
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

/* ================= CSRF CHECK ================= */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin-dashboard.php");
    exit();
}

if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
    die("Invalid CSRF token");
}

/* ================= VALIDATE INPUT ================= */
$tasker_id = isset($_POST['tasker_id']) ? (int)$_POST['tasker_id'] : 0;
$reject_reason = trim($_POST['reject_reason'] ?? '');

if ($tasker_id <= 0) {
    die("Invalid tasker ID");
}

/* ================= UPDATE TASKER STATUS ================= */
$stmt = $conn->prepare("
    UPDATE taskers 
    SET registration_status = 'rejected',
        verification_status = 'rejected',
        verified_badge = 0,
        rejection_reason = ?
    WHERE id = ?
");

$stmt->bind_param("si", $reject_reason, $tasker_id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: admin-dashboard.php?msg=tasker_rejected");
    exit();
} else {
    $stmt->close();
    die("Database error while rejecting tasker");
}
