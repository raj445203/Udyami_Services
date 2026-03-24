<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['tasker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$tasker_id = $_SESSION['tasker_id'];

// Get tasker's category/skills
$tasker_sql = "SELECT category, skills FROM taskers WHERE id = ?";
$tasker_stmt = $conn->prepare($tasker_sql);
$tasker_stmt->bind_param("i", $tasker_id);
$tasker_stmt->execute();
$tasker = $tasker_stmt->get_result()->fetch_assoc();

// Get urgent requests matching tasker's skills
$sql = "SELECT ubr.*, b.message, b.address, u.fullname as user_name, u.phone as user_phone
        FROM urgent_booking_requests ubr
        JOIN bookings b ON ubr.booking_id = b.id
        JOIN users u ON ubr.user_id = u.id
        WHERE ubr.status = 'searching' 
        AND ubr.expires_at > NOW()
        AND (ubr.service_type LIKE ? OR ? = '')
        ORDER BY ubr.created_at ASC
        LIMIT 10";

$search_term = "%{$tasker['category']}%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();

$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

echo json_encode([
    'success' => true,
    'requests' => $requests,
    'tasker_online' => true
]);
?>