<?php
require_once 'db.php';

$tasker_id = $_SESSION['tasker_id'];

$stmt = $conn->prepare("
    SELECT registration_status, verified_badge 
    FROM taskers 
    WHERE id = ?
");
$stmt->bind_param("i", $tasker_id);
$stmt->execute();
$tasker = $stmt->get_result()->fetch_assoc();
$stmt->close();

$registration_status = $tasker['registration_status'];
$verified_badge = $tasker['verified_badge'];
