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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - HandyHelp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f5f8fa;
        }
        .contact-hero {
            background: linear-gradient(rgba(56, 215, 255, 0.85), rgba(27, 111, 123, 0.85)),
                        url('https://images.unsplash.com/photo-1520975922203-4c1b43f3c88d') center/cover no-repeat;
            padding: 90px 0 60px 0;
            color: #fff;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        }
        .contact-hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .contact-hero p {
            font-size: 1.2rem;
            color: #eafcff;
        }
        .contact-section {
            margin-top: -60px;
            margin-bottom: 40px;
        }
        .contact-form, .contact-info {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(44,176,202,0.08);
            padding: 36px 32px;
        }
        .contact-form h4, .contact-info h4 {
            font-weight: 700;
            color: #237581;
        }
        .form-label {
            color: #237581;
            font-weight: 500;
        }
        .btn-custom-orange {
            background: linear-gradient(90deg, #2cb0ca 0%, #38e4ff 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 30px;
            transition: background 0.3s;
        }
        .btn-custom-orange:hover {
            background: linear-gradient(90deg, #38e4ff 0%, #2cb0ca 100%);
            color: #fff;
        }
        .contact-info p {
            color: #237581;
            font-size: 1.05rem;
            margin-bottom: 12px;
        }
        .contact-info i {
            color: #2cb0ca;
            margin-right: 10px;
        }
        .social-icon {
            width: 42px;
            height: 42px;
            background: #eafcff;
            color: #2cb0ca;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-right: 10px;
            transition: background 0.3s, color 0.3s;
            border: 1.5px solid #2cb0ca;
        }
        .social-icon:hover {
            background: #2cb0ca;
            color: #fff;
        }
        .contact-info h5 {
            margin-top: 30px;
            color: #237581;
            font-weight: 600;
        }
        .alert-success, .alert-danger {
            border-radius: 10px;
            font-size: 1rem;
        }
        @media (max-width: 991.98px) {
            .contact-section {
                margin-top: -30px;
            }
            .contact-form, .contact-info {
                padding: 24px 12px;
            }
        }
        @media (max-width: 767.98px) {
            .contact-hero {
                padding: 60px 0 30px 0;
                border-radius: 0 0 20px 20px;
            }
            .contact-section {
                margin-top: -20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom p-2 px-4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="../index.php">
                <img src="../images/logo2.png" alt="HandyHelp" height="48" class="me-2">Udyami Services
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDesktop">
                <ul class="navbar-nav d-flex align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="../Services2.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-semibold" href="contact.php">Contact Us</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="../dashboard.php">Dashboard</a>
                        </li>
                        <?php if (isset($_SESSION['tasker_logged_in']) && $_SESSION['tasker_logged_in'] === true): ?>
                            <li class="nav-item">
                                <a href="../tasker_dashboard.php"><button class="btn btn-outline-success">Tasker Dashboard</button></a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="../become-a-tasker.php"><button class="btn btn-outline-success">Become a Tasker</button></a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="../logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-semibold" href="../login.html">Sign up / Log in</a>
                        </li>
                        <li class="nav-item">
                            <a href="../become-a-tasker.php"><button class="btn btn-outline-success">Become a Tasker</button></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="contact-hero text-white text-center">
        <div class="container">
            <h1 class="mb-3">Contact Us</h1>
            <p>We’d love to hear from you! Whether you have a question, feedback, or need help, reach out to us anytime.</p>
        </div>
    </section>
    <!-- Contact Form & Info -->
    <section class="contact-section py-5">
        <div class="container">
            <div class="row g-5 align-items-stretch">
                <!-- Contact Form -->
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="contact-form shadow-sm h-100 d-flex flex-column justify-content-center">
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success mb-3">✅ Your message has been sent successfully!</div>
                        <?php elseif (isset($_GET['error'])): ?>
                            <div class="alert alert-danger mb-3">❌ Something went wrong. Please try again.</div>
                        <?php endif; ?>
                        <h4 class="mb-4">Send Us a Message</h4>
                        <form action="send-email.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Your Name</label>
                                <input type="text" name="name" class="form-control rounded-pill" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Your Email</label>
                                <input type="email" name="email" class="form-control rounded-pill" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control rounded-pill" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control rounded-4" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-custom-orange w-100 py-2">Send Message</button>
                        </form>
                    </div>
                </div>
                <!-- Contact Info -->
                <div class="col-lg-5">
                    <div class="contact-info shadow-sm h-100 d-flex flex-column justify-content-center">
                        <h4 class="mb-4">Contact Information</h4>
                        <p><i class="fas fa-map-marker-alt"></i>MGM's college of CS & IT, Nanded</p>
                        <p><i class="fas fa-phone-alt"></i>+91 98765 43210</p>
                        <p><i class="fas fa-envelope"></i>udyamiservices@gmail.com</p>
                        <h5 class="mt-4">Follow Us</h5>
                        <div class="d-flex mt-2">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer-section bg-dark text-white pt-3 pb-2 text-center">
        <div class="container">
            <div class="row gy-2 align-items-center">
                <div class="col-md-6 text-md-start text-center">
                    <span>&copy; 2025 Udyami Services. All rights reserved.</span>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <span>Made with <i class="fas fa-heart text-danger"></i> by Udyami Services Team</span>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
