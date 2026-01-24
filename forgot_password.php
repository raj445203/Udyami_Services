<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = "Email is required.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM taskers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $_SESSION['reset_email'] = $email;
            header("Location: reset_password.php");
            exit();
        } else {
            $error = "Account not found with this email.";
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
                    <h2 class="mb-0 fw-bold">Forgot Password</h2>
                    <small>Demo mode – no email verification</small>
                </div>

                <div class="card-body p-4 p-md-5">

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Registered Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control"
                                       placeholder="you@example.com" required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button class="btn btn-success btn-lg">
                                Continue
                            </button>
                        </div>
                    </form>

                    <p class="text-center mt-4 mb-0">
                        <a href="login_tasker.php" class="fw-semibold text-decoration-none">
                            Back to Login
                        </a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
