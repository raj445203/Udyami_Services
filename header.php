<?php 
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>HandyHelp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Your custom stylesheet -->
    <link rel="stylesheet" href="style.css" />
    <?php if (isset($page_css)) : ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($page_css); ?>" />
    <?php endif; ?>
</head>
<body>

<nav class="navbar navbar-light bg-white border-bottom p-2 px-4">
    <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
        <img src="images/logo2.png" alt="HandyHelp" height="50">Udyami Services
    </a>
    <div class="d-flex gap-3 align-items-center">
        <a href="index.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Home</a>
        <a href="Services2.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Services</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Dashboard</a>
            <a href="become-a-tasker.php"><button class="btn btn-outline-success">Become a Tasker</button></a>
        <?php else: ?>
            <a href="login.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Sign up / Log in</a>
            <a href="become-a-tasker.php"><button class="btn btn-outline-success">Become a Tasker</button></a>
        <?php endif; ?>

        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="collapse navbar-collapse bg-white d-md-none" id="navbarNav">
    <ul class="navbar-nav w-100 text-center">
        <li class="nav-item">
            <a class="nav-link text-dark fw-semibold" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark fw-semibold" href="Services2.php">Services</a>
        </li>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
                <a class="nav-link text-dark fw-semibold" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark fw-semibold" href="history.php">History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark fw-semibold" href="logout.php">Logout</a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link text-dark fw-semibold" href="login.php">Sign up / Log in</a>
            </li>
        <?php endif; ?>
    </ul>
</div>

<main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
