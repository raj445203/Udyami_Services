<?php
session_start();
require 'db.php'; // Your database connection file

header('Content-Type: application/json');

// Get the raw POST data
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($data && isset($data['email']) && isset($data['google_id'])) {
    $email = $data['email'];
    $google_id = $data['google_id'];
    $fullname = $data['fullname'] ?? null;

    // First, check if a user with this Google ID already exists
    $sql_check_google = "SELECT * FROM users WHERE google_id = ?";
    $stmt_google = $conn->prepare($sql_check_google);
    $stmt_google->bind_param("s", $google_id);
    $stmt_google->execute();
    $result_google = $stmt_google->get_result();

    if ($user = $result_google->fetch_assoc()) {
        // User exists, log them in
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        echo json_encode(['success' => true]);
        exit();
    } else {
        // No user with this Google ID. Check if an account with the same email exists.
        $sql_check_email = "SELECT * FROM users WHERE email = ?";
        $stmt_email = $conn->prepare($sql_check_email);
        $stmt_email->bind_param("s", $email);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();

        if ($user_email_match = $result_email->fetch_assoc()) {
            // An account with this email exists. Link the Google ID to it.
            $sql_update = "UPDATE users SET google_id = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $google_id, $user_email_match['id']);
            $stmt_update->execute();
            
            // Log the user in
            $_SESSION['user_id'] = $user_email_match['id'];
            $_SESSION['fullname'] = $user_email_match['fullname'];
            echo json_encode(['success' => true]);
            exit();

        } else {
            // No account exists, create a new one.
            $sql_insert = "INSERT INTO users (fullname, email, google_id) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $fullname, $email, $google_id);
            $stmt_insert->execute();

            if ($stmt_insert->affected_rows > 0) {
                $_SESSION['user_id'] = $stmt_insert->insert_id;
                $_SESSION['fullname'] = $fullname;
                echo json_encode(['success' => true]);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create new user.']);
                exit();
            }
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data.']);
}

$conn->close();
?>