<?php
session_start();
require 'db.php';

$errors = [];
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM taskers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tasker = $result->fetch_assoc();
            // Verify the hashed password
            if (password_verify($password, $tasker['password'])) {
                $_SESSION['tasker_id'] = $tasker['id'];
                $_SESSION['tasker_email'] = $email;
                $_SESSION['tasker_logged_in'] = true; // Set the logged-in session variable
                $_SESSION['success'] = "Login successful! Welcome to your dashboard.";
                $stmt->close();
                $conn->close();
                header("Location: tasker_dashboard.php");
                exit();
            } else {
                $errors[] = "Invalid email or password.";
            }
        } else {
            $errors[] = "Invalid email or password.";
        }
        $stmt->close();
    }
    $conn->close();
    $_SESSION['errors'] = $errors;
    header("Location: login_tasker.php");
    exit();
}

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

include('header.php');
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-info text-white text-center rounded-top-4">
                    <h2 class="mb-0">Tasker Login</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="post" action="login_tasker.php" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required value="<?= htmlspecialchars($email) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    <?php if (!empty($errors)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed!',
            html: '<ul><?php foreach ($errors as $error) echo "<li>" . addslashes($error) . "</li>"; ?></ul>',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Try Again'
        });
    <?php endif; ?>
</script>

<?php include('footer.php'); ?>