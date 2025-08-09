<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - HandyHelp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Hero Section */
.contact-hero {
    background: linear-gradient(rgba(56, 215, 255, 0.85), rgba(27, 111, 123, 0.85)),
                url('https://images.unsplash.com/photo-1520975922203-4c1b43f3c88d') center/cover no-repeat;
    padding: 80px 0;
}

/* Custom Orange */
.text-custom-orange {
    color: #38e4ff;
}
.btn-custom-orange {
    background-color: #5ebdca;
    color: #fff;
    border: none;
}
.btn-custom-orange:hover {
    background-color: #2ed5e7;
}

/* Social Icons */
.social-icon {
    width: 40px;
    height: 40px;
    background-color: #0d5766;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background-color 0.3s ease;
}
.social-icon:hover {
    background-color: #116177;
}

/* Form & Info Card */
.contact-form,
.contact-info {
    background: white;
}

    </style>
</head>
<body>


     <nav class="navbar navbar-light bg-white border-bottom p-3 px-4">
    <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
        <img src="images/logo2.png" alt="HandyHelp" height="50">HandyHelp
    </a>
    <div class="d-flex gap-3 align-items-center">
        <a href="Services2.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Services</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- User is logged in -->
            <a href="dashboard.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Dashboard</a>
            <a href="history.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">History</a>
            <a href="logout.php" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Logout</a>
            <a href="become-a-tasker.php"><button class="btn btn-outline-success">Become a Tasker</button></a>
        <?php else: ?>
            <!-- User not logged in -->
            <a href="login.html" class="text-dark fw-semibold text-decoration-none d-none d-md-block">Sign up / Log in</a>
            <a href="become-a-tasker.php"><button class="btn btn-outline-success">Become a Tasker</button></a>
        <?php endif; ?>

        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Hero Section -->
<section class="contact-hero text-white text-center">
    <div class="container">
        <h1 class="mb-3">Get in Touch</h1>
        <p>We’d love to hear from you! Whether you have a question, feedback, or need help, reach out to us anytime.</p>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="contact-form p-4 shadow-sm rounded">
                    <h4 class="mb-4">Send Us a Message</h4>
                  <form action="send_email.php" method="POST">
    <div class="mb-3">
        <label>Your Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Your Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Subject</label>
        <input type="text" name="subject" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Message</label>
        <textarea name="message" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-custom-orange w-100">Send Message</button>
</form>

                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="contact-info p-4 shadow-sm rounded">
                    <h4 class="mb-4">Contact Information</h4>
                    <p><i class="fas fa-map-marker-alt me-2 text-custom-orange"></i> 123 HandyHelp Street, Mumbai, India</p>
                    <p><i class="fas fa-phone-alt me-2 text-custom-orange"></i> +91 98765 43210</p>
                    <p><i class="fas fa-envelope me-2 text-custom-orange"></i> support@handyhelp.com</p>
                    
                    <div class="mt-4">
                        <h5>Follow Us</h5>
                        <div class="d-flex gap-3 mt-2">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="text-center py-4">
    <p class="mb-0">&copy; 2025 HandyHelp. All rights reserved.</p>
</footer>

</body>
</html>
