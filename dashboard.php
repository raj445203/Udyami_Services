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

// Safe htmlspecialchars function that handles null values
function safe_html($string, $flags = ENT_QUOTES, $encoding = 'UTF-8', $double_encode = true) {
    if ($string === null) {
        return '';
    }
    return htmlspecialchars($string, $flags, $encoding, $double_encode);
}

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
    session_destroy();
    header("Location: login.php");
    exit();
}

// Handle profile update form submission
$message = '';
$message_type = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "CSRF token validation failed. Please try again.";
        $message_type = 'danger';
    } else {
        $fullname = $_POST['fullname'] ?? $user['fullname'];
        $email = $_POST['email'] ?? $user['email'];
        $profile_image_path = $user['profile_image'];

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . uniqid() . "_" . basename($_FILES["profile_image"]["name"]);
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $profile_image_path = $target_file;
            }
        }

        $update_stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, profile_image = ? WHERE id = ?");
        if ($update_stmt) {
            $update_stmt->bind_param("sssi", $fullname, $email, $profile_image_path, $user_id);
            if ($update_stmt->execute()) {
                $message = "Profile updated successfully!";
                $message_type = 'success';
                $user_result = $conn->query("SELECT * FROM users WHERE id = $user_id");
                $user = $user_result->fetch_assoc();
                $_SESSION['fullname'] = $user['fullname'];
            } else {
                $message = "Error updating profile: " . $conn->error;
                $message_type = 'danger';
            }
            $update_stmt->close();
        }
    }
}

$user_fullname = safe_html($user['fullname'] ?? 'User');
$active_tab = $_GET['tab'] ?? 'dashboard';

// Check what columns exist
$columns_check = $conn->query("SHOW COLUMNS FROM bookings");
$existing_columns = [];
while ($col = $columns_check->fetch_assoc()) {
    $existing_columns[] = $col['Field'];
}

$booking_status_message = '';
$bookings_result = null;

if ($active_tab === 'booking-status' || $active_tab === 'active-tracking') {
    $select_fields = "b.id, b.scheduled_datetime, b.message, b.status";
    
    if (in_array('service_type', $existing_columns)) {
        $select_fields .= ", b.service_type";
    } else {
        $select_fields .= ", 'General Service' as service_type";
    }
    
    if (in_array('tracking_enabled', $existing_columns)) {
        $select_fields .= ", b.tracking_enabled";
    } else {
        $select_fields .= ", FALSE as tracking_enabled";
    }
    
    $bookings_stmt = $conn->prepare("
        SELECT 
            $select_fields,
            t.id AS tasker_id,
            t.fullname AS tasker_name,
            t.profile_image AS tasker_image,
            t.current_latitude,
            t.current_longitude,
            t.last_location_update
        FROM bookings b
        JOIN taskers t ON b.tasker_id = t.id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC
    ");
    
    if ($bookings_stmt) {
        $bookings_stmt->bind_param("i", $user_id);
        $bookings_stmt->execute();
        $bookings_result = $bookings_stmt->get_result();
    }

    if (isset($_GET['booking_status'])) {
        $status_type = $_GET['booking_status'] === 'success' ? 'success' : 'danger';
        $booking_status_message = '<div class="alert alert-' . $status_type . ' alert-dismissible fade show" role="alert">Booking request sent successfully! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Udyami Services - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        /* Remove body padding-top since header already has it */
        body {
            background-color: #f9fdfc;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: calc(100vh - 76px);
            margin-top: 76px; /* Add margin to account for fixed header */
        }

        .sidebar {
            width: 280px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 20px;
            transition: transform 0.3s ease-in-out;
            transform: translateX(0);
            position: fixed;
            left: 0;
            top: 76px;
            bottom: 0;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .main-content {
            flex-grow: 1;
            padding: 30px;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1040;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .dashboard-wrapper {
                margin-top: 60px;
            }
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

        .sidebar-link:hover,
        .sidebar-link.active {
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

        .status-badge {
            padding: .3em .6em;
            border-radius: 1rem;
            font-weight: bold;
            display: inline-block;
        }

        .status-Pending,
        .status-pending {
            background-color: #fff3cd;
            color: #664d03;
        }

        .status-Accepted,
        .status-accepted {
            background-color: #d1e7dd;
            color: #0a362b;
        }

        .status-Rejected,
        .status-rejected {
            background-color: #f8d7da;
            color: #58151c;
        }

        .status-Completed,
        .status-completed {
            background-color: #cff4fc;
            color: #055160;
        }

        .status-in_progress {
            background-color: #cfe2ff;
            color: #084298;
        }

        .track-btn {
            background-color: #0f5a5e;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .track-btn:hover {
            background-color: #0b636f;
            transform: scale(1.05);
        }

        .live-tracking-badge {
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            color: white;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.7;
                transform: scale(0.95);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .tasker-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .urgent-card {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
        }

        .urgent-card .card-icon {
            color: white;
        }

        .modal-map {
            height: 400px;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <div class="dashboard-wrapper">
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
            <a href="dashboard.php?tab=booking-status" class="sidebar-link <?php echo ($active_tab === 'booking-status' ? 'active' : ''); ?>">
                <i class="bi bi-journal-check"></i> Booking Status
            </a>
            <a href="dashboard.php?tab=active-tracking" class="sidebar-link <?php echo ($active_tab === 'active-tracking' ? 'active' : ''); ?>">
                <i class="bi bi-geo-alt-fill"></i> Active Tracking
            </a>
            <hr class="my-3">
            <a href="logout.php" class="sidebar-link text-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <div class="main-content">
            <div class="main-header d-flex justify-content-between align-items-center">
                <button class="btn toggle-btn d-md-none" id="sidebar-toggle-btn">
                    <i class="bi bi-list"></i> Menu
                </button>
                <h3 class="h4 mb-0 text-custom-green"><?php echo safe_html(ucfirst(str_replace('-', ' ', $active_tab))); ?></h3>
                <a href="logout.php" class="btn btn-logout d-md-none">Logout</a>
            </div>

            <?php if ($active_tab === 'dashboard'): ?>
                <h4 class="text-custom-green mb-4">Welcome, <?php echo $user_fullname; ?>! </h4>

                <?php
                $conn_active = new mysqli($servername, $username, $password, $dbname);
                $active_sql = "SELECT COUNT(*) as active_count FROM bookings WHERE user_id = ? AND status IN ('Accepted', 'in_progress')";
                $active_stmt = $conn_active->prepare($active_sql);
                if ($active_stmt) {
                    $active_stmt->bind_param("i", $user_id);
                    $active_stmt->execute();
                    $active_result = $active_stmt->get_result();
                    $active_count = $active_result->fetch_assoc()['active_count'] ?? 0;
                } else {
                    $active_count = 0;
                }
                $conn_active->close();
                ?>

                <?php if ($active_count > 0): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        You have <strong><?php echo $active_count; ?> active booking(s)</strong> that are currently in progress.
                        <a href="dashboard.php?tab=booking-status" class="alert-link">View all bookings</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

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
                <h4 class="text-custom-green">Edit Profile</h4>
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?> mt-4" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <div class="card p-4 rounded-3 shadow-sm">
                    <form method="POST" action="dashboard.php?tab=profile" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <label for="profile_image_upload" class="profile-img-container mb-3">
                                <img src="<?php echo safe_html($user['profile_image'] ?? 'https://placehold.co/150x150/d1e7dd/084650?text=Profile'); ?>" alt="Profile Image" class="rounded">
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
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo safe_html($user['email'] ?? ''); ?>">
                            </div>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary mt-3">Save Changes</button>
                    </form>
                </div>

            <?php elseif ($active_tab === 'become-a-tasker'): ?>
                <h4 class="text-custom-green">Become a Tasker</h4>
                <div class="card p-4 rounded-3 shadow-sm">
                    <p class="text-muted">Ready to offer your skills? Join our platform now to become a tasker.</p>
                    <a href="register-tasker.php" class="btn btn-link-action mt-3">Join Now</a>
                </div>

            <?php elseif ($active_tab === 'booking-status'): ?>
                <h4 class="text-custom-green">My Booking Status</h4>
                <div class="mt-4">
                    <?php echo $booking_status_message; ?>
                    <?php if ($bookings_result && $bookings_result->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tasker</th>
                                        <th>Service</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo safe_html($booking['tasker_image'] ?? 'images/default-avatar.png'); ?>"
                                                         class="tasker-avatar-small me-2"
                                                         onerror="this.src='images/default-avatar.png'">
                                                    <span><?php echo safe_html($booking['tasker_name'] ?? 'Unknown Tasker'); ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo safe_html($booking['service_type'] ?? 'General Service'); ?></td>
                                            <td><?php echo date('M d, Y \a\t h:i A', strtotime($booking['scheduled_datetime'] ?? 'now')); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo strtolower($booking['status'] ?? 'pending'); ?>">
                                                    <?php echo ucfirst(str_replace('_', ' ', $booking['status'] ?? 'Pending')); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (in_array(strtolower($booking['status'] ?? ''), ['accepted', 'in_progress'])): ?>
                                                    <button onclick="showTaskerLocation(<?php echo $booking['id'] ?? 0; ?>, '<?php echo addslashes($booking['tasker_name'] ?? 'Tasker'); ?>', <?php echo $booking['tasker_id'] ?? 0; ?>)"
                                                            class="btn track-btn btn-sm">
                                                        <i class="bi bi-geo-alt-fill"></i> Track Live
                                                    </button>
                                                    <?php if (isset($booking['tracking_enabled']) && $booking['tracking_enabled']): ?>
                                                        <span class="live-tracking-badge ms-2">
                                                            <i class="bi bi-broadcast"></i> LIVE
                                                        </span>
                                                    <?php endif; ?>
                                                <?php elseif (($booking['status'] ?? '') == 'Pending'): ?>
                                                    <span class="text-muted small">
                                                        <i class="bi bi-hourglass-split"></i> Awaiting response
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            You have no booking requests yet.
                            <a href="Services2.php" class="alert-link">Browse services</a> to get started!
                        </div>
                    <?php endif; ?>
                </div>

            <?php elseif ($active_tab === 'active-tracking'): ?>
                <h4 class="text-custom-green">Active Live Tracking</h4>
                <div class="mt-4">
                    <?php
                    $conn_track = new mysqli($servername, $username, $password, $dbname);
                    $tracking_sql = "SELECT 
                                        b.id,
                                        b.scheduled_datetime, 
                                        b.status,
                                        b.service_type,
                                        b.tracking_enabled,
                                        t.id AS tasker_id,
                                        t.fullname AS tasker_name,
                                        t.profile_image AS tasker_image,
                                        t.current_latitude,
                                        t.current_longitude,
                                        t.last_location_update
                                    FROM bookings b
                                    JOIN taskers t ON b.tasker_id = t.id
                                    WHERE b.user_id = ? 
                                    AND b.status IN ('Accepted', 'in_progress')
                                    AND b.tracking_enabled = TRUE
                                    ORDER BY b.scheduled_datetime ASC";
                    $tracking_stmt = $conn_track->prepare($tracking_sql);
                    if ($tracking_stmt) {
                        $tracking_stmt->bind_param("i", $user_id);
                        $tracking_stmt->execute();
                        $tracking_result = $tracking_stmt->get_result();
                    } else {
                        $tracking_result = null;
                    }
                    ?>

                    <?php if ($tracking_result && $tracking_result->num_rows > 0): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            You have <strong><?php echo $tracking_result->num_rows; ?> active booking(s)</strong> with live tracking enabled.
                        </div>

                        <div class="row">
                            <?php while ($active_booking = $tracking_result->fetch_assoc()): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card booking-card border-0 shadow-sm rounded-3">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="<?php echo safe_html($active_booking['tasker_image'] ?? 'images/default-avatar.png'); ?>"
                                                     class="tasker-avatar-small me-3"
                                                     onerror="this.src='images/default-avatar.png'">
                                                <div>
                                                    <h6 class="mb-0"><?php echo safe_html($active_booking['tasker_name'] ?? 'Tasker'); ?></h6>
                                                    <small class="text-muted"><?php echo safe_html($active_booking['service_type'] ?? 'Service'); ?></small>
                                                </div>
                                                <div class="ms-auto">
                                                    <span class="live-tracking-badge">
                                                        <i class="bi bi-broadcast"></i> LIVE
                                                    </span>
                                                </div>
                                            </div>
                                            <button onclick="showTaskerLocation(<?php echo $active_booking['id'] ?? 0; ?>, '<?php echo addslashes($active_booking['tasker_name'] ?? 'Tasker'); ?>', <?php echo $active_booking['tasker_id'] ?? 0; ?>)"
                                                    class="btn btn-link-action w-100">
                                                <i class="bi bi-geo-alt-fill me-2"></i> Track in Real-Time
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle me-2"></i>
                            You don't have any active bookings with live tracking at the moment.
                        </div>
                    <?php endif; ?>
                    <?php $conn_track->close(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tasker Location Modal -->
    <div class="modal fade" id="taskerLocationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tasker Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="taskerLocationMap" class="modal-map"></div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-geo-alt-fill"></i> Distance:</strong> <span id="distanceToTasker">Calculating...</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-clock"></i> Last Update:</strong> <span id="taskerLastUpdate">-</span></p>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> The tasker is on their way to your location. You can track their live position on this map.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" id="openMapsBtn" class="btn btn-primary" target="_blank">
                        <i class="bi bi-map"></i> Open in Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let taskerMap;
        let taskerMarker;
        let userMarker;
        let routeLine;
        let trackingInterval;
        let currentTaskerLat = null;
        let currentTaskerLng = null;
        let currentUserLat = null;
        let currentUserLng = null;

        // Sidebar toggle
        const sidebar = document.getElementById('dashboard-sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle-btn');

        function closeSidebar() {
            sidebar.classList.remove('open');
        }

        function openSidebar() {
            sidebar.classList.add('open');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                if (sidebar.classList.contains('open')) closeSidebar();
                else openSidebar();
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    closeSidebar();
                }
            }
        });

        // Profile image upload
        const profileContainer = document.querySelector('.profile-img-container');
        if (profileContainer) {
            profileContainer.addEventListener('click', function() {
                document.getElementById('profile_image_upload').click();
            });
            const fileInput = document.getElementById('profile_image_upload');
            if (fileInput) {
                fileInput.addEventListener('change', function(event) {
                    const [file] = event.target.files;
                    if (file) {
                        document.querySelector('.profile-img-container img').src = URL.createObjectURL(file);
                    }
                });
            }
        }

        // Get user's current location and update server
        function updateUserLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    currentUserLat = position.coords.latitude;
                    currentUserLng = position.coords.longitude;
                    
                    $.ajax({
                        url: 'update_location.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            latitude: currentUserLat,
                            longitude: currentUserLng
                        })
                    });
                });
            }
        }

        updateUserLocation();
        setInterval(updateUserLocation, 10000);

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        window.showTaskerLocation = function(bookingId, taskerName, taskerId) {
            $('#taskerLocationModal .modal-title').text(`Tracking ${taskerName}'s Location`);
            $('#taskerLocationModal').modal('show');

            setTimeout(function() {
                initLeafletMap(bookingId);
            }, 500);

            fetchTaskerLocation(bookingId);

            if (trackingInterval) clearInterval(trackingInterval);
            trackingInterval = setInterval(() => fetchTaskerLocation(bookingId), 5000);
        };

        function initLeafletMap(bookingId) {
            const mapElement = document.getElementById('taskerLocationMap');
            if (!mapElement) return;

            const defaultCenter = [20.5937, 78.9629];
            
            if (taskerMap) {
                taskerMap.remove();
            }
            
            taskerMap = L.map('taskerLocationMap').setView(defaultCenter, 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(taskerMap);

            if (currentUserLat && currentUserLng) {
                const userIcon = L.divIcon({
                    className: 'custom-icon',
                    html: '<div style="background-color: #007bff; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"></div>',
                    iconSize: [28, 28]
                });
                userMarker = L.marker([currentUserLat, currentUserLng], { icon: userIcon })
                    .addTo(taskerMap)
                    .bindPopup('<strong>Your Location</strong><br>You are here');
                
                taskerMap.setView([currentUserLat, currentUserLng], 13);
            }
        }

        function fetchTaskerLocation(bookingId) {
            $.ajax({
                url: 'get_locations.php',
                method: 'GET',
                data: { booking_id: bookingId },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.booking) {
                        const lat = parseFloat(response.booking.current_latitude);
                        const lng = parseFloat(response.booking.current_longitude);
                        const distance = response.distance;
                        const lastUpdate = response.booking.last_location_update;

                        if (lat && lng) {
                            currentTaskerLat = lat;
                            currentTaskerLng = lng;
                            
                            const taskerPosition = [lat, lng];

                            let distanceKm = null;
                            if (currentUserLat && currentUserLng) {
                                distanceKm = calculateDistance(currentUserLat, currentUserLng, lat, lng);
                            } else if (distance) {
                                distanceKm = distance;
                            }
                            
                            if (distanceKm !== null) {
                                const distanceKmFixed = distanceKm.toFixed(2);
                                let distanceHtml = `${distanceKmFixed} km`;
                                if (distanceKm < 0.5) {
                                    distanceHtml = `<span class="text-success">${distanceKmFixed} km - Very close!</span>`;
                                    $('#distanceToTasker').html(`${distanceHtml}<br><small class="text-success">Tasker is arriving soon!</small>`);
                                } else {
                                    const etaMinutes = Math.round((distanceKm / 30) * 60);
                                    $('#distanceToTasker').html(`${distanceHtml}<br><small>ETA: ${etaMinutes} minutes</small>`);
                                }
                            } else {
                                $('#distanceToTasker').text('Calculating...');
                            }

                            $('#taskerLastUpdate').text(lastUpdate ? new Date(lastUpdate).toLocaleTimeString() : 'Just now');
                            $('#openMapsBtn').attr('href', `https://www.google.com/maps?q=${lat},${lng}`);

                            if (taskerMap) {
                                const taskerIcon = L.divIcon({
                                    className: 'custom-icon',
                                    html: '<div style="background-color: #28a745; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"></div>',
                                    iconSize: [28, 28]
                                });
                                
                                if (taskerMarker) {
                                    taskerMarker.setLatLng(taskerPosition);
                                } else {
                                    taskerMarker = L.marker(taskerPosition, { icon: taskerIcon })
                                        .addTo(taskerMap)
                                        .bindPopup('<strong>Tasker Location</strong><br>On the way to you');
                                }
                                
                                if (routeLine) {
                                    taskerMap.removeLayer(routeLine);
                                }
                                
                                if (currentUserLat && currentUserLng && lat && lng) {
                                    routeLine = L.polyline([[currentUserLat, currentUserLng], [lat, lng]], {
                                        color: '#0f5a5e',
                                        weight: 4,
                                        opacity: 0.7,
                                        dashArray: '5, 10'
                                    }).addTo(taskerMap);
                                    
                                    const bounds = L.latLngBounds([[currentUserLat, currentUserLng], [lat, lng]]);
                                    taskerMap.fitBounds(bounds, { padding: [50, 50] });
                                } else {
                                    taskerMap.setView(taskerPosition, 14);
                                }
                            }
                        } else {
                            $('#distanceToTasker').text('Waiting for tasker location...');
                            $('#taskerLastUpdate').text('-');
                        }
                    } else {
                        $('#distanceToTasker').text('No location data available');
                    }
                },
                error: function() {
                    $('#distanceToTasker').text('Error fetching location');
                }
            });
        }

        $('#taskerLocationModal').on('hidden.bs.modal', function() {
            if (trackingInterval) {
                clearInterval(trackingInterval);
            }
            if (taskerMap) {
                taskerMap.remove();
                taskerMap = null;
            }
            taskerMarker = null;
            userMarker = null;
            routeLine = null;
        });
    </script>
</body>

</html>