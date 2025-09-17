<?php
// Enable error reporting (remove or comment out in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Udyami Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css" />
    <?php if (isset($page_css)) : ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($page_css); ?>" />
    <?php endif; ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom p-2 px-4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="index.php">
                <img src="images/logo2.png" alt="HandyHelp" height="50">Udyami Services
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDesktop">
                <ul class="navbar-nav d-flex align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="Services2.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="contact.php">Contact Us</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="dashboard.php">Dashboard</a>
                        </li>
                        <?php if (isset($_SESSION['tasker_logged_in']) && $_SESSION['tasker_logged_in'] === true): ?>
                            <li class="nav-item">
                                <a href="tasker_dashboard.php"><button class="btn btn-outline-success">Tasker Dashboard</button></a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="become-a-tasker.php"><button class="btn btn-outline-success">Become a Tasker</button></a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="login.html">Sign up / Log in</a>
                        </li>
                        <li class="nav-item">
                            <a href="become-a-tasker.php"><button class="btn btn-outline-success">Become a Tasker</button></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Udyami Services</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
                <a class="nav-link active text-dark fw-semibold" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark fw-semibold" href="Services2.php">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark fw-semibold" href="contact.php">Contact Us</a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="dashboard.php">Dashboard</a>
                </li>
                <?php if (isset($_SESSION['tasker_logged_in']) && $_SESSION['tasker_logged_in'] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="tasker_dashboard.php">Tasker Dashboard</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="become-a-tasker.php">Become a Tasker</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="history.php">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="login.html">Sign up / Log in</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="become-a-tasker.php">Become a Tasker</a>
                </li>
            <?php endif; ?>
        </ul>
      </div>
    </div>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="container mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <main>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>