<?php
// Start the session to access user data.
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page with a message
    header("Location: login.html?message=login_required");
    exit();
}

require 'db.php'; // Database connection

$tasker_id = $_GET['id'] ?? null;

if (!$tasker_id) {
    echo "<p>No tasker selected.</p>";
    exit;
}

// Fetch the main tasker's profile
$stmt = $conn->prepare("SELECT * FROM taskers WHERE id = ?");
if (!$stmt) {
    die("Database prepare error: " . $conn->error);
}
$stmt->bind_param("i", $tasker_id);
$stmt->execute();
$result = $stmt->get_result();
$tasker = $result->fetch_assoc();
$stmt->close();

if (!$tasker) {
    echo "<p>Tasker not found.</p>";
    exit;
}

// Fetch other taskers in the same category
$category = $tasker['category'] ?? 'semi-professional'; // Default category
$other_taskers_sql = "SELECT id, fullname, category FROM taskers WHERE category = ? AND id != ? LIMIT 5";
$other_taskers_stmt = $conn->prepare($other_taskers_sql);
$other_taskers_stmt->bind_param("si", $category, $tasker_id);
$other_taskers_stmt->execute();
$other_taskers_result = $other_taskers_stmt->get_result();
$other_taskers = $other_taskers_result->fetch_all(MYSQLI_ASSOC);
$other_taskers_stmt->close();
$conn->close();

// Prepare data from the database
$image = !empty($tasker['profile_image']) ? $tasker['profile_image'] : 'images/image.png';
$skills_list = explode(',', $tasker['skills'] ?? '');
$about_text = !empty($tasker['bio']) ? $tasker['bio'] : 'Sangewar Sangewar Adore ost atwits ad atwst vhws pallile its to tsec psd tspee yve tterzling tore. twrangire and walrickl zrated otrenstelng swiceed.';
$social_media = [
    'facebook' => $tasker['facebook'] ?? '#',
    'instagram' => $tasker['instagram'] ?? '#',
    'twitter' => $tasker['twitter'] ?? '#'
];

// Set a variable to easily check if a user is logged in
$is_user_logged_in = isset($_SESSION['user_id']);
$is_tasker_logged_in = isset($_SESSION['tasker_logged_in']) && $_SESSION['tasker_logged_in'] === true;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tasker['fullname']); ?> - Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />

    <style>
        /* --- tasker-profile.php styles --- */
        :root {
            --primary-color: #388e3c;
            --secondary-color: #f1f8e9;
            --text-dark: #333;
            --text-medium: #666;
            --text-light: #999;
            --border-radius: 12px;
            --box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            --icon-bg: #e0f2f1;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f7;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        
        main {
            flex: 1; /* Pushes the footer to the bottom */
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 5px 0;
        }

        .main-container {
            display: flex;
            gap: 20px;
            width: 100%;
            max-width: 1200px;
            box-sizing: border-box;
            align-items: flex-start;
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
        }

        .main-content {
            flex: 3;
            min-width: 500px;
        }

        .sidebar {
            flex: 1;
            min-width: 250px;
            max-width: 300px;
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .profile-card {
            background-color: var(--secondary-color);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            box-sizing: border-box;
            border: 1px solid #e1e1e1;
        }

        .profile-header {
            display: flex;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .profile-image-circle {
            background-color: var(--primary-color);
            color: #fff;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 600;
            margin-right: 20px;
            background-image: url('<?php echo htmlspecialchars($image); ?>');
            background-size: cover;
            background-position: center;
        }

        .profile-image-circle:empty::before {
            content: '<?php echo htmlspecialchars(substr($tasker['fullname'], 0, 1) . (strpos($tasker['fullname'], ' ') !== false ? substr($tasker['fullname'], strpos($tasker['fullname'], ' ') + 1, 1) : '')); ?>';
            color: white;
        }

        .profile-info h1 {
            margin: 0;
            font-size: 24px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .profile-info p {
            margin: 0;
            font-size: 14px;
            color: var(--text-medium);
            font-weight: 500;
        }

        .profile-meta {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 14px;
            color: var(--text-medium);
        }

        .profile-meta .rating,
        .profile-meta .verified {
            display: flex;
            align-items: center;
        }

        .profile-meta .rating i.fa-star {
            color: gold;
            margin-right: 5px;
        }

        .profile-meta .verified i.fa-check-circle {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .profile-content {
            display: flex;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .left-column {
            flex: 2;
            min-width: 300px;
        }

        .right-column {
            flex: 1;
            min-width: 250px;
            padding: 25px;
            background-color: #f7fdf7;
            border-radius: var(--border-radius);
            border: 1px solid #e9f5e9;
        }

        .section-heading {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .about-text {
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-medium);
        }

        .experience-location {
            margin-top: 20px;
        }

        .exp-item {
            display: flex;
            align-items: center;
            margin-top: 8px;
            font-size: 14px;
            color: var(--text-medium);
        }

        .exp-item i {
            color: var(--primary-color);
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }

        .exp-item a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-left: 10px;
        }

        .exp-item a:hover {
            text-decoration: underline;
        }

        .photo-gallery {
            margin-top: 20px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
        }

        .gallery-grid img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .gallery-grid img:hover {
            transform: scale(1.05);
        }

        .ready-to-book {
            text-align: center;
        }

        .ready-to-book h3 {
            margin-top: 0;
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .ready-to-book p {
            font-size: 14px;
            color: var(--text-medium);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: 15px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2e7d32;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
        }

        .social-media {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            justify-content: center;
        }

        .social-media a {
            color: var(--primary-color);
            font-size: 24px;
            transition: color 0.3s ease;
        }

        .social-media a:hover {
            color: #2e7d32;
        }


        /* Responsive Styles */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
                padding: 20px;
            }
            .main-content,
            .sidebar {
                min-width: 100%;
                max-width: 100%;
                position: static;
                margin-top: 20px;
            }
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
                border-bottom: none;
                padding-bottom: 0;
            }
            .profile-image-circle {
                margin: 0 0 15px 0;
                width: 80px;
                height: 80px;
            }
            .profile-info {
                border-bottom: 1px solid #e0e0e0;
                padding-bottom: 20px;
                width: 100%;
            }
            .profile-info h1 {
                font-size: 20px;
            }
            .profile-meta {
                flex-direction: column;
                gap: 5px;
                margin-top: 10px;
            }
            .profile-content {
                flex-direction: column;
                gap: 20px;
            }
            .right-column {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            .profile-meta {
                flex-direction: column;
                gap: 5px;
            }
            .btn-group {
                flex-direction: column;
            }
            .profile-image-circle {
                margin: 0 0 15px 0;
            }
        }
        /* --- Footer styles (from your footer.php file) --- */
        .footer-section {
            background-color: #041622;
            color: #ccc;
            padding: 50px 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .footer-section h5, .footer-section h6 {
            color: #ffffff;
        }
        .footer-link {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: color 0.3s;
        }
        .footer-link:hover {
            color: #40c18f;
        }
        .social-icon {
            font-size: 20px;
            color: #ccc;
            transition: color 0.3s;
        }
        .social-icon:hover {
            color: #40c18f;
        }
        .email-link {
            cursor: pointer;
        }
        .email-link:focus {
            outline: 2px solid #40c18f;
            background-color: #f0fdf9;
        }
        @media (max-width: 768px) {
            .footer-section .row > div {
                text-align: center;
            }
            .footer-section .row > div:not(:last-child) {
                margin-bottom: 20px;
            }
            .footer-section .d-flex.gap-3 {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <main>
    <div class="main-container">
        <div class="main-content">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-image-circle"></div>
                    <div class="profile-info">
                        <h1><?php echo htmlspecialchars($tasker['fullname']); ?></h1>
                        <p>
                            <?php
                            if (!empty($skills_list[0])) {
                                echo htmlspecialchars(ucwords(trim($skills_list[0])));
                            } else {
                                echo "Tasker";
                            }
                            ?> Specialist
                        </p>
                        <div class="profile-meta">
                            <span class="rating">
                                <i class="fas fa-star"></i> 4.9/5 (24 Reviews)
                            </span>
                            <?php if (isset($tasker['category']) && strtolower($tasker['category']) === 'professional'): ?>
                                <span class="verified">
                                    <i class="fas fa-check-circle"></i> Verified Professional
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="profile-content">
                    <div class="left-column">
                        <div class="experience-location">
                            <h2 class="section-heading">Experience & Location</h2>
                            <div class="exp-item">
                                <i class="fas fa-certificate"></i>
                                <span><?php echo htmlspecialchars($tasker['experience_years'] ?? '0'); ?>+ Years of Professional Care</span>
                            </div>
                            <div class="exp-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo htmlspecialchars($tasker['preferred_location'] ?? 'Not specified'); ?></span>
                            </div>
                        </div>
                        <div class="contact-skills-section" style="margin-top: 20px;">
                            <h2 class="section-heading" style="text-align: left;">Contact & Skills</h2>
                            <div class="exp-item" style="justify-content: left;">
                                <i class="fas fa-phone"></i>
                                <span><?php echo htmlspecialchars($tasker['phone'] ?? 'Not specified'); ?></span>
                            </div>
                            <div class="exp-item" style="justify-content: left; margin-bottom: 20px;">
                                <i class="fas fa-envelope"></i>
                                <span><?php echo htmlspecialchars($tasker['email']); ?></span>
                            </div>
                            <h4 style="text-align: left; font-size: 16px; margin-bottom: 10px;">Skills & Expertise</h4>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: left;">
                                <?php foreach ($skills_list as $skill): ?>
                                    <span style="background-color: #e0f2f1; color: var(--primary-color); padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 500;">
                                        <?php echo htmlspecialchars(trim($skill)); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                            <div class="social-media" style="justify-content: left;">
                                <a href="<?php echo htmlspecialchars($social_media['facebook']); ?>" target="_blank" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="<?php echo htmlspecialchars($social_media['twitter']); ?>" target="_blank" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="<?php echo htmlspecialchars($social_media['instagram']); ?>" target="_blank" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>

                        <div class="photo-gallery">
                            <h2 class="section-heading">Photo Gallery</h2>
                            <div class="gallery-grid">
                                <img src="https://images.unsplash.com/photo-1543462828-875f4d1e2e31?w=500&auto=format&fit=crop&q=60" alt="image 1">
                                <img src="https://images.unsplash.com/photo-1596492784531-fa9143093284?w=500&auto=format&fit=crop&q=60" alt="image 2">
                                <img src="https://images.unsplash.com/photo-1587300003294-19232fd9431d?w=500&auto=format&fit=crop&q=60" alt="image 3">
                                <img src="https://images.unsplash.com/photo-1537151608828-ea2b12279152?w=500&auto=format&fit=crop&q=60" alt="image 4">
                                <img src="https://images.unsplash.com/photo-1583511655073-77209734e568?w=500&auto=format&fit=crop&q=60" alt="image 5">
                                <img src="https://images.unsplash.com/photo-1502479532551-7f9984951475?w=500&auto=format&fit=crop&q=60" alt="image 6">
                            </div>
                        </div>
                    </div>
                    <div class="right-column">
                        <div class="ready-to-book">
                            <h3>Ready to Book?</h3>
                            <p>Contact to discuss your project and schedule a booking.</p>
                            <div class="btn-group">
                                <a href="booking.php?tasker_id=<?php echo htmlspecialchars($tasker['id']); ?>" class="btn btn-primary">
                                    <i class="fas fa-calendar-alt"></i> Book Now
                                </a>
                                <a href="#" class="btn btn-secondary">
                                    <i class="fas fa-envelope"></i> Send a Message
                                </a>
                            </div>
                            <p style="font-weight: 500; color: var(--text-medium); margin: 25px 0 15px;">Or Connect Directly:</p>
                            <div class="btn-group">
                                <a href="tel:<?php echo htmlspecialchars($tasker['phone']); ?>" class="btn btn-secondary">
                                    <i class="fas fa-phone"></i> Call Now
                                </a>
                                <a href="mailto:<?php echo htmlspecialchars($tasker['email']); ?>" class="btn btn-secondary">
                                    <i class="fas fa-envelope"></i> Email Directly
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>