<?php
session_start();
require 'db.php';

$errors = [];
$success = '';
$email = $_COOKIE['remember_tasker'] ?? '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Server-side validation
    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM taskers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $tasker = $result->fetch_assoc();

            if (password_verify($password, $tasker['password'])) {

                // ===== REMEMBER ME LOGIC START =====
                if (!empty($_POST['remember'])) {
                    setcookie(
                        "remember_tasker",
                        $email,
                        time() + (30 * 24 * 60 * 60), // 30 days
                        "/",
                        "",
                        false,
                        true
                    );
                } else {
                    setcookie("remember_tasker", "", time() - 3600, "/");
                }
                // ===== REMEMBER ME LOGIC END =====

                $_SESSION['tasker_id'] = $tasker['id'];
                $_SESSION['tasker_email'] = $email;
                $_SESSION['tasker_logged_in'] = true;
                $_SESSION['success'] = "Welcome back! Login successful.";

                header("Location: tasker_dashboard.php");
                exit();
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            $errors[] = "Account not found with this email.";
        }
        $stmt->close();
    }

    $_SESSION['errors'] = $errors;
    header("Location: login_tasker.php");
    exit();
}

$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);

include('header.php');
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient bg-info text-white text-center py-4 rounded-top-4">
                    <h2 class="mb-0 fw-bold">Tasker Login</h2>
                    <small>Access your dashboard</small>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="post" id="loginForm" novalidate>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" name="email"
                                    placeholder="you@example.com"
                                    value="<?= htmlspecialchars($email) ?>" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input type="password"
                                    class="form-control"
                                    name="password"
                                    id="password"
                                    placeholder="Enter your password"
                                    required>

                                <span class="input-group-text" style="cursor:pointer" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </span>
                            </div>
                        </div>


                        <!-- Remember me -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    <?= isset($_COOKIE['remember_tasker']) ? 'checked' : '' ?>>

                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="forgot_password.php" class="text-decoration-none">Forgot password?</a>
                        </div>

                        <!-- Button -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg" id="loginBtn">
                                <span id="btnText">Login</span>
                            </button>
                        </div>

                        <p class="text-center mt-4 mb-0">
                            Don’t have an account?
                            <a href="register-tasker.php" class="fw-semibold text-decoration-none">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script>
    <?php if (!empty($errors)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            html: '<ul style="text-align:left"><?php foreach ($errors as $e) echo "<li>" . addslashes($e) . "</li>"; ?></ul>',
            confirmButtonColor: '#dc3545'
        });
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?= addslashes($success) ?>',
            timer: 2000,
            showConfirmButton: false
        });
    <?php endif; ?>

    // Password toggle
    function togglePassword() {
        const password = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        if (password.type === "password") {
            password.type = "text";
            eyeIcon.classList.remove("bi-eye");
            eyeIcon.classList.add("bi-eye-slash");
        } else {
            password.type = "password";
            eyeIcon.classList.remove("bi-eye-slash");
            eyeIcon.classList.add("bi-eye");
        }
    }

    // Client-side validation
    document.getElementById("loginForm").addEventListener("submit", function() {
        document.getElementById("btnText").innerText = "Logging in...";
    });
</script>

<?php include('footer.php'); ?>