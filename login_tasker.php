<?php
// login_tasker.php
session_start();
require 'db.php';

// If already logged in as tasker, redirect to dashboard
if (isset($_SESSION['tasker_id']) && isset($_SESSION['tasker_logged_in'])) {
    header("Location: tasker_dashboard.php");
    exit();
}

// Check if the request is a POST from the email/password form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Find the tasker in the database
    $sql = "SELECT id, fullname, email, password, registration_status FROM taskers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($tasker = $result->fetch_assoc()) {
        // Verify password
        if (password_verify($password, $tasker['password'])) {
            // Check if tasker is approved
            if ($tasker['registration_status'] == 'approved') {
                // IMPORTANT: Only set tasker session variables
                $_SESSION['tasker_id'] = $tasker['id'];
                $_SESSION['tasker_logged_in'] = true;
                $_SESSION['tasker_name'] = $tasker['fullname'];
                $_SESSION['tasker_email'] = $tasker['email'];
                
                $_SESSION['success_message'] = "Welcome back, " . $tasker['fullname'] . "!";
                header("Location: tasker_dashboard.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Your account is pending approval. Please wait for admin approval.";
                header("Location: login_tasker.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Invalid email or password.";
            header("Location: login_tasker.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Tasker not found. Please register first.";
        header("Location: register-tasker.php");
        exit();
    }
}

// If it's a GET request, show the login form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasker Login - Udyami Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: #084650ff;
            font-weight: bold;
        }
        .btn-login {
            background-color: #084650ff;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            width: 100%;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #0b636f;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-hard-hat fa-3x" style="color: #084650ff;"></i>
            <h2 class="mt-3">Tasker Login</h2>
            <p class="text-muted">Access your tasker dashboard</p>
        </div>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="login_tasker.php">
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" required placeholder="Enter your password">
                </div>
            </div>
            
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Login as Tasker
            </button>
        </form>
        
        <div class="text-center mt-4">
            <p class="text-muted">Don't have a tasker account?</p>
            <a href="register-tasker.php" class="btn btn-outline-success">
                <i class="fas fa-user-plus me-2"></i> Register as Tasker
            </a>
        </div>
        
        <div class="text-center mt-3">
            <a href="login.html" class="text-decoration-none">
                <i class="fas fa-user me-1"></i> Login as User
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>