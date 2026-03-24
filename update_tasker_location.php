<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['tasker_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$tasker_id = $_SESSION['tasker_id'];
$input = json_decode(file_get_contents('php://input'), true);
$latitude = isset($input['latitude']) ? floatval($input['latitude']) : null;
$longitude = isset($input['longitude']) ? floatval($input['longitude']) : null;

if (!$latitude || !$longitude) {
    echo json_encode(['success' => false, 'message' => 'Invalid coordinates']);
    exit();
}

// Check what columns exist
$columns_check = $conn->query("SHOW COLUMNS FROM taskers");
$existing_columns = [];
while ($col = $columns_check->fetch_assoc()) {
    $existing_columns[] = $col['Field'];
}

// Build update query based on existing columns
$update_fields = [];
$params = [];
$types = "";

if (in_array('current_location_lat', $existing_columns)) {
    $update_fields[] = "current_location_lat = ?";
    $params[] = $latitude;
    $types .= "d";
}

if (in_array('current_location_lng', $existing_columns)) {
    $update_fields[] = "current_location_lng = ?";
    $params[] = $longitude;
    $types .= "d";
}

if (in_array('location_updated_at', $existing_columns)) {
    $update_fields[] = "location_updated_at = NOW()";
}

if (empty($update_fields)) {
    echo json_encode(['success' => false, 'message' => 'Location columns not available']);
    exit();
}

$sql = "UPDATE taskers SET " . implode(", ", $update_fields) . " WHERE id = ?";
$params[] = $tasker_id;
$types .= "i";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Location updated']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement']);
}

$conn->close();
?>