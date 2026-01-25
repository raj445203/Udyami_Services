<?php
require '../db.php';
require 'admin-auth.php';

$id = (int)($_GET['id'] ?? 0);
$action = $_GET['action'] ?? '';

if ($id <= 0 || !in_array($action, ['approve', 'reject'])) {
    die("Invalid request");
}

if ($action === 'approve') {
    $stmt = $conn->prepare("
        UPDATE taskers 
        SET registration_status = 'approved',
            verification_status = 'verified',
            verified_badge = 1
        WHERE id = ?
    ");
} else {
    $stmt = $conn->prepare("
        UPDATE taskers 
        SET registration_status = 'rejected',
            verification_status = 'rejected',
            verified_badge = 0
        WHERE id = ?
    ");
}

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: pending-taskers.php");
exit;
