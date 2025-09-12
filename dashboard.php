<?php
// Start the session to access user data.
session_start();

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require 'db.php';

// Generate a CSRF token if one doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
if (!$stmt) {
    die("Database prepare error: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

if (!$user) {
    // If user data can't be fetched, destroy the session and redirect
    session_destroy();
    header("Location: login.php");
    exit();
}

// Handle profile update form submission
$message = '';
$message_type = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    // CSRF Token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "CSRF token validation failed. Please try again.";
        $message_type = 'danger';
    } else {
        $fullname = $_POST['fullname'] ?? $user['fullname'];
        $email = $_POST['email'] ?? $user['email'];
        
        $update_stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ? WHERE id = ?");
        if (!$update_stmt) {
            $message = "Database prepare error: " . $conn->error;
            $message_type = 'danger';
        } else {
            $update_stmt->bind_param("ssi", $fullname, $email, $user_id);
        
            if ($update_stmt->execute()) {
                $message = "Profile updated successfully!";
                $message_type = 'success';
                // Re-fetch user data to display latest changes
                $user_result = $conn->query("SELECT * FROM users WHERE id = $user_id");
                $user = $user_result->fetch_assoc();
                $_SESSION['fullname'] = $user['fullname']; // Update session fullname
            } else {
                $message = "Error updating profile: " . $conn->error;
                $message_type = 'danger';
            }
            $update_stmt->close();
        }
    }
}

// Get the user's full name from the fetched data
$user_fullname = htmlspecialchars($user['fullname']);

// Determine which tab is active based on the URL parameter
$active_tab = $_GET['tab'] ?? 'dashboard';

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HandyHelp - Dashboard</title>
    
    <!-- Bootstrap CSS for layout and styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons for professional-looking icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f9fdfc;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        .dashboard-wrapper {
            display: flex;
            min-height: calc(100vh - 76px); /* Adjust based on your header height */
        }
        .sidebar {
            width: 280px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
            transition: transform 0.3s ease-in-out;
            transform: translateX(0);
        }
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        .main-content {
            flex-grow: 1;
            padding: 30px;
        }
        .text-custom-green {
            color: #084650ff !important;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 5px;
            color: #495057;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.2s, color 0.2s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #084650ff;
            color: #fff;
        }
        .sidebar-link .bi {
            font-size: 1.2rem;
            margin-right: 15px;
        }
        .main-header {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .toggle-btn {
            background-color: #084650ff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
        }
        .profile-img-container {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            border: 3px solid #084650ff;
            cursor: pointer;
        }
        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .card-icon {
            font-size: 2.5rem;
            color: #084650ff;
        }
        .btn-link-action {
            background-color: #084650ff;
            color: white;
            transition: background-color 0.3s;
        }
        .btn-link-action:hover {
            background-color: #14566cff;
            color: white;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            transition: background-color 0.3s;
        }
        .btn-logout:hover {
            background-color: #c82333;
            color: white;
        }
        @media (max-width: 768px) {
            .dashboard-wrapper {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                position: relative;
            }
            .sidebar.collapsed {
                display: none;
            }
            .main-content {
                padding-top: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <div class="sidebar" id="dashboard-sidebar">
            <h6 class="text-uppercase fw-bold mb-4">Dashboard Menu</h6>
            <a href="dashboard.php?tab=dashboard" class="sidebar-link <?php echo ($active_tab === 'dashboard' ? 'active' : ''); ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="dashboard.php?tab=profile" class="sidebar-link <?php echo ($active_tab === 'profile' ? 'active' : ''); ?>">
                <i class="bi bi-person-circle"></i> Profile
            </a>
            <a href="dashboard.php?tab=become-a-tasker" class="sidebar-link <?php echo ($active_tab === 'become-a-tasker' ? 'active' : ''); ?>">
                <i class="bi bi-briefcase"></i> Become a Tasker
            </a>
            <hr class="my-3">
            <a href="logout.php" class="sidebar-link text-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Main Content Header -->
            <div class="main-header d-flex justify-content-between align-items-center">
                <button class="btn toggle-btn d-md-none" id="sidebar-toggle-btn">
                    <i class="bi bi-list"></i> Menu
                </button>
                <h3 class="h4 mb-0 text-custom-green"><?php echo htmlspecialchars(ucfirst($active_tab)); ?></h3>
                <!-- Logout button for small screens -->
                <a href="logout.php" class="btn btn-logout d-md-none">Logout</a>
            </div>

            <!-- Dynamic content will load here based on the active tab -->
            <?php if ($active_tab === 'dashboard'): ?>
                <!-- Content for the main dashboard overview -->
                <h4 class="text-custom-green mb-4">Welcome, <?php echo $user_fullname; ?>!</h4>
                <div class="row g-4 mt-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <i class="bi bi-person-circle card-icon mb-3"></i>
                                <h5 class="card-title text-custom-green">My Profile</h5>
                                <p class="card-text text-muted">View and update your personal information.</p>
                                <a href="dashboard.php?tab=profile" class="btn btn-link-action w-100 mt-3">Go to Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <i class="bi bi-search card-icon mb-3"></i>
                                <h5 class="card-title text-custom-green">Find a Tasker</h5>
                                <p class="card-text text-muted">Browse for new taskers for your next project.</p>
                                <a href="Services2.php" class="btn btn-link-action w-100 mt-3">Browse Services</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <i class="bi bi-briefcase card-icon mb-3"></i>
                                <h5 class="card-title text-custom-green">Become a Tasker</h5>
                                <p class="card-text text-muted">Join our platform and start offering your services to others.</p>
                                <a href="dashboard.php?tab=become-a-tasker" class="btn btn-link-action w-100 mt-3">Sign Up Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif ($active_tab === 'profile'): ?>
                <!-- Content for the Profile tab -->
                <h4 class="text-custom-green">Edit Profile</h4>
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?> mt-4" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <div class="card p-4 rounded-3 shadow-sm">
                    <form method="POST" action="dashboard.php?tab=profile" enctype="multipart/form-data">
                        <!-- Add a hidden CSRF token field -->
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <label for="profile_image_upload" class="profile-img-container mb-3">
                                <img src="<?php echo htmlspecialchars($user['profile_image'] ?? 'https://placehold.co/150x150/d1e7dd/084650?text=Profile'); ?>" alt="Profile Image" class="rounded">
                            </label>
                            <input type="file" id="profile_image_upload" name="profile_image" class="d-none">
                            <small class="text-muted">Click the image to upload a new one.</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo $user_fullname; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                            <!-- Phone and Location fields removed -->
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary mt-3">Save Changes</button>
                    </form>
                </div>
            <?php elseif ($active_tab === 'become-a-tasker'): ?>
                <!-- Content for Become a Tasker tab -->
                <h4 class="text-custom-green">Become a Tasker</h4>
                <div class="card p-4 rounded-3 shadow-sm">
                    <p class="text-muted">Ready to offer your skills? Join our platform now to become a tasker.</p>
                    <a href="register-tasker.php" class="btn btn-link-action mt-3">Join Now</a>
                </div>
            <?php else: ?>
                <!-- Fallback content if the tab is not recognized -->
                <h4 class="text-custom-green">Error</h4>
                <div class="card p-4 rounded-3 shadow-sm">
                    <p>The requested tab was not found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS Bundle for responsive features and card functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebar-toggle-btn').addEventListener('click', function() {
            var sidebar = document.getElementById('dashboard-sidebar');
            if (window.innerWidth <= 768) {
                if (sidebar.classList.contains('collapsed')) {
                    sidebar.classList.remove('collapsed');
                } else {
                    sidebar.classList.add('collapsed');
                }
            }
        });
        
        // This script handles the click event on the profile image
        document.querySelector('.profile-img-container').addEventListener('click', function() {
            document.getElementById('profile_image_upload').click();
        });
        
        // This script updates the displayed image when a new file is selected
        document.getElementById('profile_image_upload').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.querySelector('.profile-img-container img').src = URL.createObjectURL(file);
            }
        });
    </script>
</body>
</html>
