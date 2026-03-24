<?php
// Start the session to access user data.
session_start();

// Safe htmlspecialchars function that handles null values
function safe_html($string, $flags = ENT_QUOTES, $encoding = 'UTF-8', $double_encode = true) {
    if ($string === null) {
        return '';
    }
    return htmlspecialchars($string, $flags, $encoding, $double_encode);
}

// Check if the tasker is logged in. If not, redirect to the login page.
require 'includes/auth_tasker.php';
require 'includes/tasker_status.php';
if (!isset($_SESSION['tasker_id'])) {
    header("Location: login_tasker.php");
    exit();
}

// Include the database connection file
require 'db.php';

// Generate a CSRF token if one doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch tasker data from the database
$tasker_id = $_SESSION['tasker_id'];
$stmt = $conn->prepare("SELECT * FROM taskers WHERE id = ?");
if (!$stmt) {
    die("Database prepare error: " . $conn->error);
}
$stmt->bind_param("i", $tasker_id);
$stmt->execute();
$tasker_result = $stmt->get_result();
$tasker_data = $tasker_result->fetch_assoc();
$stmt->close();

if (!$tasker_data) {
    session_destroy();
    header("Location: login_tasker.php");
    exit();
}

// Handle profile update form submission
$message = '';
$message_type = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "CSRF token validation failed.";
        $message_type = 'danger';
    } else {

        // Sanitize inputs
        $fullname = trim($_POST['fullname']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address']);
        $gender = trim($_POST['gender']);
        $category = trim($_POST['category']);
        $skills = trim($_POST['skills']);
        $experience = (int)$_POST['experience_years'];
        $location = trim($_POST['preferred_location']);

        // Profile image upload
        $profile_image_path = $tasker_data['profile_image'];

        if (!empty($_FILES['profile_image']['name'])) {

            $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
            $file_name = $_FILES['profile_image']['name'];
            $file_tmp = $_FILES['profile_image']['tmp_name'];
            $file_size = $_FILES['profile_image']['size'];

            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed_types)) {
                $message = "Only JPG, PNG, WEBP images are allowed.";
                $message_type = 'danger';
            } elseif ($file_size > 2 * 1024 * 1024) {
                $message = "Image size must be less than 2MB.";
                $message_type = 'danger';
            } else {

                $upload_dir = "uploads/taskers/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $new_file_name = "tasker_" . $tasker_id . "_" . time() . "." . $ext;
                $upload_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {

                    if (!empty($tasker_data['profile_image']) && file_exists($tasker_data['profile_image'])) {
                        unlink($tasker_data['profile_image']);
                    }

                    $profile_image_path = $upload_path;
                } else {
                    $message = "Failed to upload image.";
                    $message_type = 'danger';
                }
            }
        }

        // Gallery image upload
        if (!empty($_FILES['gallery_image']['name'])) {

            $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
            $upload_dir = "uploads/taskers/";

            $image_name = $_FILES['gallery_image']['name'];
            $tmp_name = $_FILES['gallery_image']['tmp_name'];
            $size = $_FILES['gallery_image']['size'];
            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed_types) && $size <= 2 * 1024 * 1024) {
                $new_name = "gallery_" . $tasker_id . "_" . time() . "." . $ext;
                $path = $upload_dir . $new_name;

                if (move_uploaded_file($tmp_name, $path)) {
                    $table_check = $conn->query("SHOW TABLES LIKE 'tasker_photos'");
                    if ($table_check->num_rows > 0) {
                        $stmt = $conn->prepare("INSERT INTO tasker_photos (tasker_id, photo_url) VALUES (?, ?)");
                        if ($stmt) {
                            $stmt->bind_param("is", $tasker_id, $new_name);
                            $stmt->execute();
                            $stmt->close();
                        }
                    }
                } else {
                    $message = "Failed to upload image.";
                    $message_type = 'danger';
                }
            } elseif ($size > 2 * 1024 * 1024) {
                $message = "Image size must be less than 2MB.";
                $message_type = 'danger';
            } else {
                $message = "Only JPG, PNG, WEBP images are allowed.";
                $message_type = 'danger';
            }
        }

        if (empty($message)) {

            $update_stmt = $conn->prepare("
                UPDATE taskers SET
                fullname = ?, email = ?, phone = ?, address = ?, gender = ?,
                category = ?, skills = ?, experience_years = ?, preferred_location = ?, profile_image = ?
                WHERE id = ?
            ");

            if ($update_stmt) {
                $update_stmt->bind_param(
                    "sssssssissi",
                    $fullname,
                    $email,
                    $phone,
                    $address,
                    $gender,
                    $category,
                    $skills,
                    $experience,
                    $location,
                    $profile_image_path,
                    $tasker_id
                );

                if ($update_stmt->execute()) {
                    $message = "Profile updated successfully!";
                    $message_type = 'success';
                    $tasker_data = $conn->query("SELECT * FROM taskers WHERE id = $tasker_id")->fetch_assoc();
                } else {
                    $message = "Profile update failed.";
                    $message_type = 'danger';
                }

                $update_stmt->close();
            } else {
                $message = "Failed to prepare update statement.";
                $message_type = 'danger';
            }
        }
    }
}

$tasker_fullname = safe_html($tasker_data['fullname'] ?? 'Tasker');
$active_tab = $_GET['tab'] ?? 'dashboard';

// Check what columns exist in users table
$columns_check = $conn->query("SHOW COLUMNS FROM users");
$user_columns = [];
while ($col = $columns_check->fetch_assoc()) {
    $user_columns[] = $col['Field'];
}

// --- BOOKING STATUS LOGIC ---
$bookings = [];

if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    $message_type = 'success';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    $message = $_SESSION['error_message'];
    $message_type = 'danger';
    unset($_SESSION['error_message']);
}

if ($active_tab === 'all-orders' || $active_tab === 'pending-orders' || $active_tab === 'history') {
    $select_fields = "b.*, u.fullname AS user_name";
    
    if (in_array('phone', $user_columns)) {
        $select_fields .= ", u.phone AS user_phone";
    } else {
        $select_fields .= ", '' AS user_phone";
    }
    
    if (in_array('current_latitude', $user_columns)) {
        $select_fields .= ", u.current_latitude, u.current_longitude";
    }
    
    if (in_array('last_location_update', $user_columns)) {
        $select_fields .= ", u.last_location_update";
    }
    
    $sql = "
        SELECT $select_fields
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        WHERE b.tasker_id = ?
    ";

    if ($active_tab === 'pending-orders') {
        $sql .= " AND b.status = 'Pending'";
    } elseif ($active_tab === 'history') {
        $sql .= " AND b.status IN ('Completed', 'Rejected')";
    }

    $sql .= " ORDER BY b.created_at DESC";

    $bookings_stmt = $conn->prepare($sql);
    if ($bookings_stmt) {
        $bookings_stmt->bind_param("i", $tasker_id);
        $bookings_stmt->execute();
        $bookings_result = $bookings_stmt->get_result();

        if ($bookings_result->num_rows > 0) {
            while ($row = $bookings_result->fetch_assoc()) {
                $bookings[] = $row;
            }
        }
        $bookings_stmt->close();
    }
}

// Get active bookings for location tracking
$active_bookings = [];
if ($tasker_data['is_available']) {
    $select_fields = "b.id, b.user_id, u.fullname as user_name, b.status, b.service_type";
    
    if (in_array('current_latitude', $user_columns)) {
        $select_fields .= ", u.current_latitude, u.current_longitude";
    }
    
    if (in_array('last_location_update', $user_columns)) {
        $select_fields .= ", u.last_location_update";
    }
    
    $active_sql = "SELECT $select_fields
                   FROM bookings b
                   JOIN users u ON b.user_id = u.id
                   WHERE b.tasker_id = ? AND b.status IN ('Accepted', 'in_progress')
                   ORDER BY b.created_at DESC";
    $active_stmt = $conn->prepare($active_sql);
    if ($active_stmt) {
        $active_stmt->bind_param("i", $tasker_id);
        $active_stmt->execute();
        $active_result = $active_stmt->get_result();
        while ($row = $active_result->fetch_assoc()) {
            $active_bookings[] = $row;
        }
        $active_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Udyami Services - Tasker Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body {
            background-color: #f9fdfc;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: calc(100vh - 76px);
        }

        .sidebar {
            width: 280px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

        .online-status-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 20px;
            color: white;
            margin-bottom: 30px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 120px;
            height: 60px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #dc3545;
            transition: 0.4s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 52px;
            width: 52px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: #28a745;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(60px);
        }

        .online-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
            margin-right: 5px;
        }

        .online {
            background-color: #28a745;
            box-shadow: 0 0 5px #28a745;
        }

        .offline {
            background-color: #dc3545;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .location-btn {
            background-color: #0f5a5e;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .location-btn:hover {
            background-color: #0b636f;
            transform: scale(1.05);
        }

        .live-badge {
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            animation: pulse 1.5s infinite;
            display: inline-block;
        }

        .modal-map {
            height: 400px;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .sidebar.open {
                display: block;
                position: absolute;
                z-index: 1050;
                background: #fff;
                width: 80%;
                left: 0;
                top: 0;
                height: 100vh;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
                transition: all 0.3s;
            }
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <div class="dashboard-wrapper">
        <div class="sidebar" id="dashboard-sidebar">
            <h6 class="text-uppercase fw-bold mb-4">Tasker Menu</h6>
            <?php if ($registration_status === 'pending'): ?>
                <div class="alert alert-warning">
                    ⏳ Your registration is under admin review.
                </div>
            <?php elseif ($registration_status === 'rejected'): ?>
                <div class="alert alert-danger">
                    ❌ Registration rejected. Please contact admin.
                </div>
            <?php else: ?>
                <a href="tasker_dashboard.php?tab=dashboard" class="sidebar-link <?php echo ($active_tab === 'dashboard' ? 'active' : ''); ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="tasker_dashboard.php?tab=profile" class="sidebar-link <?php echo ($active_tab === 'profile' ? 'active' : ''); ?>">
                    <i class="bi bi-person-circle"></i> Profile
                </a>
                <a href="tasker_dashboard.php?tab=all-orders" class="sidebar-link <?php echo ($active_tab === 'all-orders' ? 'active' : ''); ?>">
                    <i class="bi bi-list-check"></i> All Orders
                </a>
                <a href="tasker_dashboard.php?tab=pending-orders" class="sidebar-link <?php echo ($active_tab === 'pending-orders' ? 'active' : ''); ?>">
                    <i class="bi bi-hourglass-split"></i> Pending Orders
                </a>
                <a href="tasker_dashboard.php?tab=history" class="sidebar-link <?php echo ($active_tab === 'history' ? 'active' : ''); ?>">
                    <i class="bi bi-clock-history"></i> History
                </a>
                <hr class="my-3">
                <a href="logout-tasker.php" class="sidebar-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            <?php endif; ?>
        </div>

        <div class="main-content">
            <div class="main-header d-flex justify-content-between align-items-center">
                <button class="btn toggle-btn d-md-none" id="sidebar-toggle-btn">
                    <i class="bi bi-list"></i> Menu
                </button>
              <h3 class="h4 mb-0 text-custom-green"><?php echo safe_html(ucfirst(str_replace('-', ' ', $active_tab))); ?></h3>
                <div>
                    <a href="logout-tasker.php" class="btn btn-logout d-md-none">Logout</a>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($active_tab === 'dashboard'): ?>
                <div class="online-status-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-2">Welcome, <?php echo $tasker_fullname; ?>!</h3>
                            <p class="mb-0">Manage your availability for service requests</p>
                            <div class="mt-2" id="locationStatus">
                                <?php if ($tasker_data['current_latitude']): ?>
                                    <i class="bi bi-check-circle text-success"></i> Last location: <?php echo date('H:i:s', strtotime($tasker_data['last_location_update'] ?? 'now')); ?>
                                <?php else: ?>
                                    <i class="bi bi-exclamation-triangle text-warning"></i> No location data yet
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <form method="POST" action="toggle_availability.php" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="toggle_status" onchange="this.form.submit()" 
                                               <?php echo $tasker_data['is_available'] ? 'checked' : ''; ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                    <div class="mt-2">
                                        <span class="online-indicator <?php echo $tasker_data['is_available'] ? 'online' : 'offline'; ?>"></span>
                                        <span id="statusText">
                                            <?php echo $tasker_data['is_available'] ? 'ONLINE - Available for services' : 'OFFLINE - Not receiving requests'; ?>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($active_bookings)): ?>
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        You have <strong><?php echo count($active_bookings); ?> active booking(s)</strong> in progress.
                        <a href="tasker_dashboard.php?tab=all-orders" class="alert-link">View all orders</a>
                    </div>
                <?php endif; ?>

                <div class="row g-4 mt-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <i class="bi bi-person-circle card-icon mb-3"></i>
                                <h5 class="card-title text-custom-green">My Profile</h5>
                                <p class="card-text text-muted">View and update your personal information.</p>
                                <a href="tasker_dashboard.php?tab=profile" class="btn btn-link-action w-100 mt-3">Go to Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <i class="bi bi-hourglass-split card-icon mb-3"></i>
                                <h5 class="card-title text-custom-green">Pending Orders</h5>
                                <p class="card-text text-muted">View and manage new booking requests.</p>
                                <a href="tasker_dashboard.php?tab=pending-orders" class="btn btn-link-action w-100 mt-3">View Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <i class="bi bi-clock-history card-icon mb-3"></i>
                                <h5 class="card-title text-custom-green">Order History</h5>
                                <p class="card-text text-muted">See all your past completed jobs.</p>
                                <a href="tasker_dashboard.php?tab=history" class="btn btn-link-action w-100 mt-3">View History</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($active_bookings)): ?>
                    <div class="mt-4">
                        <h5 class="text-custom-green">Active Bookings</h5>
                        <div class="row">
                            <?php foreach ($active_bookings as $active_booking): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card mb-3 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="bi bi-person-circle fs-1 me-3 text-custom-green"></i>
                                                <div>
                                                   <h6 class="mb-0"><?php echo safe_html($active_booking['user_name'] ?? 'Customer'); ?></h6>
<small class="text-muted"><?php echo safe_html($active_booking['service_type'] ?? 'Service'); ?></small>
                                                </div>
                                                <div class="ms-auto">
                                                    <span class="live-badge">
                                                        <i class="bi bi-broadcast"></i> LIVE
                                                    </span>
                                                </div>
                                            </div>
                                            <button class="btn location-btn w-100" onclick="showCustomerLocation(<?php echo $active_booking['id']; ?>, '<?php echo addslashes($active_booking['user_name']); ?>')">
                                                <i class="bi bi-geo-alt-fill"></i> View Customer Location
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php elseif ($active_tab === 'profile'): ?>
                <h4 class="text-custom-green">Edit Profile</h4>
                <div class="card p-4 rounded-3 shadow-sm">
                    <form method="POST" action="tasker_dashboard.php?tab=profile" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <label for="profile_image_upload" class="profile-img-container mb-3">
                               <img src="<?php echo safe_html($tasker_data['profile_image'] ?? 'https://placehold.co/150x150/d1e7dd/084650?text=Profile'); ?>" alt="Profile Image" class="rounded">
                            </label>
                            <input type="file" id="profile_image_upload" name="profile_image" class="d-none">
                            <small class="text-muted">Click the image to upload a new one.</small>
                        </div>

                        <hr>

                        <h5 class="text-custom-green mb-3">Upload Gallery Image</h5>

                        <div class="mb-3">
                            <input type="file" name="gallery_image" class="form-control" accept="image/*">
                            <small class="text-muted">Upload a single image (max 2MB).</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo htmlspecialchars($tasker_data['fullname']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($tasker_data['email']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" id="phone" value="<?php echo htmlspecialchars($tasker_data['phone'] ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" class="form-control" id="gender">
                                    <option value="Male" <?php echo ($tasker_data['gender'] === 'Male' ? 'selected' : ''); ?>>Male</option>
                                    <option value="Female" <?php echo ($tasker_data['gender'] === 'Female' ? 'selected' : ''); ?>>Female</option>
                                    <option value="Other" <?php echo ($tasker_data['gender'] === 'Other' ? 'selected' : ''); ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control" id="address" rows="3"><?php echo htmlspecialchars($tasker_data['address']); ?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" name="category" class="form-control" id="category" value="<?php echo htmlspecialchars($tasker_data['category']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                <input type="text" name="skills" class="form-control" id="skills" value="<?php echo htmlspecialchars($tasker_data['skills']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="experience_years" class="form-label">Experience (Years)</label>
                                <input type="number" name="experience_years" class="form-control" id="experience_years" value="<?php echo htmlspecialchars($tasker_data['experience_years']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="preferred_location" class="form-label">Preferred Location</label>
                                <input type="text" name="preferred_location" class="form-control" id="preferred_location" value="<?php echo htmlspecialchars($tasker_data['preferred_location']); ?>">
                            </div>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary mt-3">Save Changes</button>
                    </form>
                </div>

            <?php elseif ($active_tab === 'all-orders' || $active_tab === 'pending-orders' || $active_tab === 'history'): ?>
                <h4 class="text-custom-green"><?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $active_tab))); ?></h4>
                <div class="mt-4">
                    <?php if (!empty($bookings)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Date & Time</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-person-circle fs-4 me-2"></i>
                                                    <?php echo htmlspecialchars($booking['user_name']); ?>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($booking['user_phone'] ?? 'N/A'); ?></td>
                                            <td><?php echo date('M d, Y \a\t h:i A', strtotime($booking['scheduled_datetime'])); ?></td>
                                            <td><?php echo htmlspecialchars($booking['service_type'] ?? 'General Service'); ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo strtolower($booking['status']); ?>">
                                                    <?php echo ucfirst(str_replace('_', ' ', $booking['status'])); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <form action="update_booking_status.php" method="POST" class="d-flex gap-2 flex-wrap">
                                                    <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                                    <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                                        <option value="Pending" <?php echo ($booking['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Accepted" <?php echo ($booking['status'] == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                                                        <option value="Rejected" <?php echo ($booking['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                        <option value="Completed" <?php echo ($booking['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                    </select>
                                                    
                                                    <?php if (in_array($booking['status'], ['Accepted', 'in_progress'])): ?>
                                                        <button type="button" class="btn btn-sm btn-info" onclick="showCustomerLocation(<?php echo $booking['id']; ?>, '<?php echo addslashes($booking['user_name']); ?>')">
                                                            <i class="bi bi-geo-alt-fill"></i> View Location
                                                        </button>
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info" role="alert">
                            <?php if ($active_tab === 'pending-orders'): ?>
                                You have no pending orders at the moment.
                            <?php elseif ($active_tab === 'history'): ?>
                                Your order history is empty.
                            <?php else: ?>
                                You have no orders yet.
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <h4 class="text-custom-green">Error</h4>
                <div class="card p-4 rounded-3 shadow-sm">
                    <p>The requested tab was not found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Customer Location Modal with Leaflet Map -->
    <div class="modal fade" id="customerLocationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="customerLocationMap" class="modal-map"></div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-geo-alt-fill"></i> Distance:</strong> <span id="distanceToCustomer">Calculating...</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-clock"></i> Last Update:</strong> <span id="customerLastUpdate">-</span></p>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Navigate to this location to start the service. The customer can see your location in real-time.
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
        let customerMap;
        let customerMarker;
        let taskerMarker;
        let routeLine;
        let trackingInterval;
        let currentCustomerLat = null;
        let currentCustomerLng = null;
        let currentTaskerLat = null;
        let currentTaskerLng = null;

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

        document.querySelectorAll('#dashboard-sidebar .sidebar-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) closeSidebar();
            });
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

        // Update tasker location when online
        <?php if ($tasker_data['is_available'] == 1): ?>
        function updateTaskerLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        currentTaskerLat = lat;
                        currentTaskerLng = lng;
                        
                        $.ajax({
                            url: 'update_location.php',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                latitude: lat,
                                longitude: lng
                            }),
                            success: function(response) {
                                console.log("Tasker location updated");
                                if (response.success) {
                                    $('#locationStatus').html('<i class="bi bi-check-circle text-success"></i> Location updated: ' + new Date().toLocaleTimeString());
                                }
                            }
                        });
                    },
                    function(error) {
                        console.log("Geolocation error:", error);
                        $('#locationStatus').html('<i class="bi bi-exclamation-triangle text-warning"></i> Unable to get location');
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            }
        }
        
        updateTaskerLocation();
        setInterval(updateTaskerLocation, 10000);
        <?php endif; ?>

        // Calculate distance between two points (Haversine formula)
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

        // Show customer location in modal
        window.showCustomerLocation = function(bookingId, userName) {
            console.log("showCustomerLocation called with:", bookingId, userName);
            
            $('#customerLocationModal .modal-title').text(`${userName}'s Location`);
            $('#customerLocationModal').modal('show');

            setTimeout(function() {
                initLeafletMap(bookingId);
            }, 500);

            fetchCustomerLocation(bookingId);

            if (trackingInterval) clearInterval(trackingInterval);
            trackingInterval = setInterval(() => fetchCustomerLocation(bookingId), 5000);
        };

        function initLeafletMap(bookingId) {
            const mapElement = document.getElementById('customerLocationMap');
            if (!mapElement) {
                console.error("Map element not found");
                return;
            }

            // Default center (India)
            const defaultCenter = [20.5937, 78.9629];
            
            if (customerMap) {
                customerMap.remove();
            }
            
            customerMap = L.map('customerLocationMap').setView(defaultCenter, 5);
            
            // Add tile layer (free, no API key)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(customerMap);

            // Add tasker marker if we have location
            if (currentTaskerLat && currentTaskerLng) {
                const taskerIcon = L.divIcon({
                    className: 'custom-icon',
                    html: '<div style="background-color: #28a745; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"></div>',
                    iconSize: [28, 28]
                });
                taskerMarker = L.marker([currentTaskerLat, currentTaskerLng], { icon: taskerIcon })
                    .addTo(customerMap)
                    .bindPopup('<strong>Your Location</strong><br>You are here');
                
                customerMap.setView([currentTaskerLat, currentTaskerLng], 13);
            }
            
            console.log("Map initialized");
        }

        function fetchCustomerLocation(bookingId) {
            console.log("Fetching customer location for booking:", bookingId);
            
            $.ajax({
                url: 'get_locations.php',
                method: 'GET',
                data: { booking_id: bookingId },
                dataType: 'json',
                success: function(response) {
                    console.log("Customer location response:", response);

                    if (response.success && response.booking) {
                        const lat = parseFloat(response.booking.current_latitude);
                        const lng = parseFloat(response.booking.current_longitude);
                        const distance = response.distance;
                        const lastUpdate = response.booking.last_location_update;

                        if (lat && lng) {
                            currentCustomerLat = lat;
                            currentCustomerLng = lng;
                            
                            const customerPosition = [lat, lng];

                            // Calculate distance if we have both locations
                            let distanceKm = null;
                            if (currentTaskerLat && currentTaskerLng) {
                                distanceKm = calculateDistance(currentTaskerLat, currentTaskerLng, lat, lng);
                            } else if (distance) {
                                distanceKm = distance;
                            }
                            
                            if (distanceKm !== null) {
                                const distanceKmFixed = distanceKm.toFixed(2);
                                let distanceHtml = `${distanceKmFixed} km`;
                                if (distanceKm < 0.5) {
                                    distanceHtml = `<span class="text-success">${distanceKmFixed} km - Very close!</span>`;
                                    $('#distanceToCustomer').html(`${distanceHtml}<br><small class="text-success">You are almost there!</small>`);
                                } else {
                                    const etaMinutes = Math.round((distanceKm / 30) * 60);
                                    $('#distanceToCustomer').html(`${distanceHtml}<br><small>ETA: ${etaMinutes} minutes</small>`);
                                }
                            } else {
                                $('#distanceToCustomer').text('Calculating...');
                            }

                            $('#customerLastUpdate').text(lastUpdate ? new Date(lastUpdate).toLocaleTimeString() : 'Just now');
                            $('#openMapsBtn').attr('href', `https://www.google.com/maps?q=${lat},${lng}`);

                            if (customerMap) {
                                const customerIcon = L.divIcon({
                                    className: 'custom-icon',
                                    html: '<div style="background-color: #dc3545; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"></div>',
                                    iconSize: [28, 28]
                                });
                                
                                if (customerMarker) {
                                    customerMarker.setLatLng(customerPosition);
                                } else {
                                    customerMarker = L.marker(customerPosition, { icon: customerIcon })
                                        .addTo(customerMap)
                                        .bindPopup('<strong>Customer Location</strong><br>Service location');
                                }
                                
                                // Draw route line between tasker and customer
                                if (routeLine) {
                                    customerMap.removeLayer(routeLine);
                                }
                                
                                if (currentTaskerLat && currentTaskerLng && lat && lng) {
                                    routeLine = L.polyline([[currentTaskerLat, currentTaskerLng], [lat, lng]], {
                                        color: '#0f5a5e',
                                        weight: 4,
                                        opacity: 0.7,
                                        dashArray: '5, 10'
                                    }).addTo(customerMap);
                                    
                                    // Fit bounds to show both markers
                                    const bounds = L.latLngBounds([[currentTaskerLat, currentTaskerLng], [lat, lng]]);
                                    customerMap.fitBounds(bounds, { padding: [50, 50] });
                                } else {
                                    customerMap.setView(customerPosition, 14);
                                }
                            }
                        } else {
                            $('#distanceToCustomer').text('Waiting for customer location...');
                            $('#customerLastUpdate').text('-');
                        }
                    } else {
                        $('#distanceToCustomer').text('No location data available');
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error fetching customer location:", error);
                    $('#distanceToCustomer').text('Error fetching location');
                }
            });
        }

        // Clean up interval when modal is closed
        $('#customerLocationModal').on('hidden.bs.modal', function() {
            if (trackingInterval) {
                clearInterval(trackingInterval);
            }
            if (customerMap) {
                customerMap.remove();
                customerMap = null;
            }
            customerMarker = null;
            taskerMarker = null;
            routeLine = null;
        });
        
        // Debug: Check if function is available
        console.log("showCustomerLocation function defined:", typeof window.showCustomerLocation === 'function');
    </script>
</body>

</html>