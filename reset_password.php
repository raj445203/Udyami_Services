<?php
session_start();
require 'db.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

$email = $_SESSION['reset_email'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE taskers SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $success = "Password reset successfully. You can login now.";
            unset($_SESSION['reset_email']);
        } else {
            $error = "Failed to reset password.";
        }
        $stmt->close();
    }
}

include('header.php');
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient bg-info text-white text-center py-4 rounded-top-4">
                    <h2 class="mb-0 fw-bold">Reset Password</h2>
                    <small><?= htmlspecialchars($email) ?></small>
                </div>

                <div class="card-body p-4 p-md-5">

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($success) ?><br>
                            <a href="login_tasker.php" class="fw-semibold">Go to Login</a>
                        </div>
                    <?php else: ?>
                        <form method="POST" novalidate>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-success btn-lg">
                                    Reset Password
                                </button>
                            </div>

                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
