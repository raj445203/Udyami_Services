<?php
// login.php
session_start();
require 'db.php';

// Check if the request is a POST from the email/password form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // Find the user in the database
    $sql = "SELECT id, fullname FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Log in the user by setting session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        header("Location: dashboard.php");
        exit();
    } else {
        // This should not happen with a correct signup flow
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'User not found in database.']);
        exit();
    }
} 
// Check if the request is a POST from the Google login
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['email']) && isset($data['google_id'])) {
        $email = $data['email'];
        $google_id = $data['google_id'];
        $fullname = $data['fullname'] ?? null;

        // Find user by Google ID or email
        $sql_check = "SELECT id, fullname FROM users WHERE google_id = ? OR email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $google_id, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($user = $result_check->fetch_assoc()) {
            // User exists, log them in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
        exit();
    }
}
$conn->close();