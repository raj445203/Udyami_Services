<?php
// signup.php
session_start();
require 'db.php';

// JSON response header
header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if ($data && !empty($data['email'])) {
    $fullname     = trim($data['fullname'] ?? '');
    $email        = trim($data['email']);
    $firebase_uid = $data['firebase_uid'] ?? null;
    $google_id    = $data['google_id'] ?? null;

    // Check if user already exists
    $checkSql = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered.']);
        $checkStmt->close();
        $conn->close();
        exit();
    }
    $checkStmt->close();

    // Insert new user
    $sql = "INSERT INTO users (fullname, email, firebase_uid, google_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Check for a prepared statement error
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'SQL prepare error: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("ssss", $fullname, $email, $firebase_uid, $google_id);

    if ($stmt->execute()) {
        // Log the user in by setting session variables
        $_SESSION['user_id']  = $stmt->insert_id;
        $_SESSION['fullname'] = $fullname;
        echo json_encode(['success' => true, 'message' => 'Signup successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
}

$conn->close();