<?php
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
                // Set tasker session variables
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
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Udyami Services - Tasker Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <style>
        /* Override login.css for tasker-specific styles */
        .tasker-header-icon {
            color: #ff6b6b;
        }
        
        .btn-tasker {
            background: linear-gradient(135deg, #0f5a5e 0%, #0b636f 100%);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-tasker:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(15, 90, 94, 0.4);
        }
        
        .link-tasker {
            color: #0f5a5e;
        }
        
        .link-tasker:hover {
            color: #0b636f;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-light bg-white border-bottom p-3 px-4 navbar-fixed-top">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
            <img src="images/logo2.png" alt="Udyami Services" height="50"> Udyami Services
        </a>
        <div class="d-flex gap-3 align-items-center">
            <a href="index.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Home</a>
            <a href="Services2.php" class="text-dark fw-semibold text-decoration-none">Services</a>
            <a href="contact/contact.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Contact Us</a>
            <a href="login.html" class="text-dark fw-semibold text-decoration-none">User Login</a>
            <a href="become-a-tasker.php" class="btn btn-outline-success">Become a Tasker</a>
        </div>
    </nav>

    <div class="login-container text-center mt-5">
        <h2>Tasker Login</h2>
        <p>Or <a href="register-tasker.php" class="link-text">register as a tasker</a></p>

        <div id="message-container">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
        
        <form id="tasker-login-form" method="POST" action="login_tasker.php" class="mt-3">
            <input type="email" name="email" id="email" class="form-control mb-2" placeholder="Email address" required>
            <input type="password" name="password" id="password" class="form-control mb-3" placeholder="Password" required>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <a href="forgot_password_tasker.php" class="link-text">Forgot password?</a>
            </div>
            <button type="submit" class="btn btn-tasker w-100">
                <i class="fas fa-sign-in-alt me-2"></i> Login as Tasker
            </button>
        </form>
        
        <div class="divider mt-4">or</div>
        
        <div class="mt-3">
            <p class="mb-2">Login as a regular user?</p>
            <a href="login.html" class="btn btn-outline-secondary w-100">
                <i class="fas fa-user me-2"></i> User Login
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Remember me functionality
        const rememberCheckbox = document.getElementById('rememberMe');
        const emailInput = document.getElementById('email');
        
        // Load saved email if exists
        const savedEmail = localStorage.getItem('tasker_email');
        if (savedEmail) {
            emailInput.value = savedEmail;
            rememberCheckbox.checked = true;
        }
        
        // Save email when checkbox is checked
        rememberCheckbox.addEventListener('change', () => {
            if (rememberCheckbox.checked) {
                localStorage.setItem('tasker_email', emailInput.value);
            } else {
                localStorage.removeItem('tasker_email');
            }
        });
        
        // Update saved email when email changes
        emailInput.addEventListener('change', () => {
            if (rememberCheckbox.checked) {
                localStorage.setItem('tasker_email', emailInput.value);
            }
        });
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    <script id="omnidimension-web-widget" async src="https://backend.omnidim.io/web_widget.js?secret_key=68f0ba12eab69e9266647d3102b367a6"></script>
</body>
</html>