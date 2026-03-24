<?php
// login.php
session_start();
require 'db.php';

// Check if the request is a POST from the email/password form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // Find the user in the database
    $sql = "SELECT id, fullname, email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // IMPORTANT: Only set user session variables
        // Do NOT destroy or modify tasker session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_name'] = $user['fullname'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['user_email'] = $user['email'];
        
        // Set success message
        $_SESSION['success_message'] = "Welcome back, " . $user['fullname'] . "!";
        
        header("Location: dashboard.php");
        exit();
    } else {
        // User not found
        $_SESSION['error_message'] = "User not found. Please sign up first.";
        header("Location: login.html");
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
        $sql_check = "SELECT id, fullname, email FROM users WHERE google_id = ? OR email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $google_id, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($user = $result_check->fetch_assoc()) {
            // User exists, log them in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['user_email'] = $user['email'];
            
            echo json_encode(['success' => true, 'message' => 'Login successful']);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found. Please sign up first.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
        exit();
    }
}

// If no valid request method
$_SESSION['error_message'] = "Invalid request method";
header("Location: login.html");
exit();

$conn->close();
?>