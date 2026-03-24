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
                            <a class="nav-link text-dark fw-semibold" href="logout.php">
                                <i class="fas fa-sign-out-alt me-1"></i> Logout
                            </a>
                            <a href="tasker_dashboard.php" class="btn btn-outline-success">Tasker Dashboard</a>
                        </li>
                    <?php else: ?>
                        <!-- Non-logged in users -->
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="login.html">
                                <i class="fas fa-sign-in-alt me-1"></i> Sign up / Log in
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="become-a-tasker.php">
                                <button class="btn btn-outline-success">
                                    <i class="fas fa-user-plus me-1"></i> Become a Tasker
                                </button>
                            </a>
                            <a href="become-a-tasker.php" class="btn btn-outline-success">Become a Tasker</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                <img src="images/logo2.png" alt="HandyHelp" height="30"> Udyami Services
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link active text-dark fw-semibold" aria-current="page" href="index.php">
                        <i class="fas fa-home me-2"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="Services2.php">
                        <i class="fas fa-tools me-2"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="contact/contact.php">
                        <i class="fas fa-envelope me-2"></i> Contact Us
                    </a>
                </li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User Menu Items -->
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <!-- REMOVED: Live Map from offcanvas -->
                    
                    <?php if (isset($_SESSION['tasker_logged_in']) && $_SESSION['tasker_logged_in'] === true): ?>
                        <!-- Tasker Menu Items -->
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="tasker_dashboard.php">
                                <i class="fas fa-briefcase me-2"></i> Tasker Dashboard
                            </a>
                        </li>
                        <!-- REMOVED: My Location from offcanvas -->
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="become-a-tasker.php">
                                <i class="fas fa-user-plus me-2"></i> Become a Tasker
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="history.php">
                            <i class="fas fa-history me-2"></i> History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </li>

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
                    <!-- Non-logged in users menu items -->
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="login.html">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign up / Log in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="become-a-tasker.php">
                            <i class="fas fa-user-plus me-2"></i> Become a Tasker
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="become-a-tasker.php">Become a Tasker</a></li>
                <?php endif; ?>
            </ul>
            
            <!-- Optional: User profile summary in offcanvas -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <hr class="my-3">
                <div class="d-flex align-items-center p-2 bg-light rounded">
                    <i class="fas fa-user-circle fa-2x me-2 text-primary"></i>
                    <div>
                        <small class="text-muted">Logged in as</small>
                        <div class="fw-bold">
                            <?php 
                            if (isset($_SESSION['user_name'])) {
                                echo htmlspecialchars($_SESSION['user_name']);
                            } else if (isset($_SESSION['fullname'])) {
                                echo htmlspecialchars($_SESSION['fullname']);
                            } else {
                                echo 'User';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>

            <?php else: ?>

                <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="become-a-tasker.php">Become a Tasker</a></li>

            <?php endif; ?>
        </div>
    </div>

        </ul>
    </div>
</div>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="container mt-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="container mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
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
    
    <!-- Global JavaScript for location handling -->
    <script>
    // Function to check if user is logged in (available globally)
    function isUserLoggedIn() {
        return <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    }
    
    // Function to get user role
    function getUserRole() {
        <?php if (isset($_SESSION['tasker_logged_in']) && $_SESSION['tasker_logged_in'] === true): ?>
        return 'tasker';
        <?php elseif (isset($_SESSION['user_id'])): ?>
        return 'user';
        <?php else: ?>
        return 'guest';
        <?php endif; ?>
    }
    
    // Add active class to current nav item
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href === currentPage) {
                link.classList.add('active');
                link.style.fontWeight = 'bold';
                link.style.color = '#0f5a5e';
            }
        });
    });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>