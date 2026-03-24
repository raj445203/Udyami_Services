<?php
// Enable error reporting (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Udyami Services</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- FONT (IMPORTANT) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- PAGE CSS -->
    <?php if (isset($page_css)) : ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($page_css); ?>">
    <?php endif; ?>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* ===== PREMIUM NAVBAR ===== */
        .navbar {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .navbar.scrolled {
            background: rgba(255,255,255,0.95) !important;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.3rem;
        }

        .navbar-brand img {
            margin-right: 8px;
        }

        .nav-link {
            position: relative;
            font-weight: 500;
        }

        /* underline hover effect */
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: -3px;
            left: 0;
            background: #2cb0ca;
            transition: 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* BUTTON STYLE */
        .btn-outline-success {
            border-radius: 50px;
            padding: 6px 15px;
            transition: 0.3s;
        }

        .btn-outline-success:hover {
            background: #2cb0ca;
            border-color: #2cb0ca;
            color: white;
        }

        /* OFFCANVAS IMPROVE */
        .offcanvas {
            border-radius: 15px 0 0 15px;
        }

        .offcanvas-title {
            font-weight: 600;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white border-bottom px-4 py-2 fixed-top">
    <div class="container-fluid">

        <!-- LOGO -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="images/logo2.png" alt="Logo" height="45">
            Udyami Services
        </a>

        <!-- MOBILE BUTTON -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- DESKTOP MENU -->
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav align-items-center gap-3">

                <li class="nav-item">
                    <a class="nav-link text-dark" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href="Services2.php">Services</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark" href="contact/contact.php">Contact</a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="dashboard.php">Dashboard</a>
                    </li>

                    <?php if (isset($_SESSION['tasker_logged_in']) && $_SESSION['tasker_logged_in'] === true): ?>
                        <li class="nav-item">
                            <a href="tasker_dashboard.php" class="btn btn-outline-success">Tasker Dashboard</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="become-a-tasker.php" class="btn btn-outline-success">Become a Tasker</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="logout.php">Logout</a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link text-dark" href="login.html">Login</a>
                    </li>

                    <li class="nav-item">
                        <a href="become-a-tasker.php" class="btn btn-outline-success">Become a Tasker</a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<!-- MOBILE MENU -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Udyami Services</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="navbar-nav">

            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="Services2.php">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="contact/contact.php">Contact</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>

                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>

                <?php if (isset($_SESSION['tasker_logged_in']) && $_SESSION['tasker_logged_in'] === true): ?>
                    <li class="nav-item"><a class="nav-link" href="tasker_dashboard.php">Tasker Dashboard</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="become-a-tasker.php">Become a Tasker</a></li>
                <?php endif; ?>

                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>

            <?php else: ?>

                <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="become-a-tasker.php">Become a Tasker</a></li>

            <?php endif; ?>

        </ul>
    </div>
</div>

<!-- ALERT -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="container mt-5 pt-5">
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<!-- SCROLL EFFECT -->
<script>
window.addEventListener("scroll", function () {
    document.querySelector(".navbar").classList.toggle("scrolled", window.scrollY > 50);
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>