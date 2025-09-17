<?php
// Start the session to access user data.
session_start();

// Check if the tasker is logged in. If not, redirect to the login page.
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
    // If tasker data can't be fetched, destroy the session and redirect
    session_destroy();
    header("Location: login_tasker.php");
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
        // Sanitize and validate input
        $fullname = trim($_POST['fullname'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $skills = trim($_POST['skills'] ?? '');
        $experience = (int)($_POST['experience_years'] ?? 0);
        $location = trim($_POST['preferred_location'] ?? '');

        // Use a more secure password hashing if implementing password change

        $update_stmt = $conn->prepare("
            UPDATE taskers 
            SET fullname = ?, email = ?, phone = ?, address = ?, gender = ?, category = ?, skills = ?, experience_years = ?, preferred_location = ?
            WHERE id = ?
        ");

        if (!$update_stmt) {
            $message = "Database prepare error: " . $conn->error;
            $message_type = 'danger';
        } else {
            $update_stmt->bind_param("ssssssisi", $fullname, $email, $phone, $address, $gender, $category, $skills, $experience, $location, $tasker_id);

            if ($update_stmt->execute()) {
                $message = "Profile updated successfully!";
                $message_type = 'success';
                // Re-fetch tasker data to display latest changes
                $tasker_result = $conn->query("SELECT * FROM taskers WHERE id = $tasker_id");
                $tasker_data = $tasker_result->fetch_assoc();
            } else {
                $message = "Error updating profile: " . $conn->error;
                $message_type = 'danger';
            }
            $update_stmt->close();
        }
    }
}

// Get the tasker's full name from the fetched data
$tasker_fullname = htmlspecialchars($tasker_data['fullname']);

// Determine which tab is active based on the URL parameter
$active_tab = $_GET['tab'] ?? 'dashboard';

// --- BOOKING STATUS LOGIC ---
$bookings = [];
$booking_status_message = '';
if ($active_tab === 'all-orders' || $active_tab === 'pending-orders' || $active_tab === 'history') {
    $sql = "
        SELECT 
            b.*, 
            u.fullname AS user_name
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        WHERE b.tasker_id = ?
    ";

    if ($active_tab === 'pending-orders') {
        $sql .= " AND b.status = 'Pending'";
    } elseif ($active_tab === 'history') {
        $sql .= " AND b.status IN ('Completed', 'Rejected', 'Accepted')"; // Include 'Accepted' in history
    }

    $sql .= " ORDER BY b.created_at DESC";

    $bookings_stmt = $conn->prepare($sql);
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

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HandyHelp - Tasker Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f9fdfc;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: calc(100vh - 76px);
            /* Adjust based on your header height */
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

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9fdfc;
        }

        .status-badge {
            padding: .3em .6em;
            border-radius: 1rem;
            font-weight: bold;
            display: inline-block;
        }

        .status-Pending {
            background-color: #fff3cd;
            color: #664d03;
        }

        .status-Accepted {
            background-color: #d1e7dd;
            color: #0a362b;
        }

        .status-Rejected {
            background-color: #f8d7da;
            color: #58151c;
        }

        .status-Completed {
            background-color: #cff4fc;
            color: #055160;
        }

        .form-control:disabled {
            background-color: #e9ecef;
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
    <?php include('header.php'); // Assuming a similar header exists 
    ?>

    <div class="dashboard-wrapper">
        <div class="sidebar" id="dashboard-sidebar">
            <h6 class="text-uppercase fw-bold mb-4">Tasker Menu</h6>
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
        </div>

        <div class="main-content">
            <div class="main-header d-flex justify-content-between align-items-center">
                <button class="btn toggle-btn d-md-none" id="sidebar-toggle-btn">
                    <i class="bi bi-list"></i> Menu
                </button>
                <h3 class="h4 mb-0 text-custom-green"><?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $active_tab))); ?></h3>
                <a href="logout.php" class="btn btn-logout d-md-none">Logout</a>
            </div>

            <?php if ($active_tab === 'dashboard'): ?>
                <h4 class="text-custom-green mb-4">Welcome, <?php echo $tasker_fullname; ?>! </h4>
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
                                <p class="card-text text-muted">View your new and pending booking requests.</p>
                                <a href="tasker_dashboard.php?tab=pending-orders" class="btn btn-link-action w-100 mt-3">View Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <i class="bi bi-clock-history card-icon mb-3"></i>
                                <h5 class="card-title text-custom-green">Order History</h5>
                                <p class="card-text text-muted">See all your past completed and rejected jobs.</p>
                                <a href="tasker_dashboard.php?tab=history" class="btn btn-link-action w-100 mt-3">View History</a>
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
                    <form method="POST" action="tasker_dashboard.php?tab=profile" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <label for="profile_image_upload" class="profile-img-container mb-3">
                                <img src="<?php echo htmlspecialchars($tasker_data['profile_image'] ?? 'https://placehold.co/150x150/d1e7dd/084650?text=Profile'); ?>" alt="Profile Image" class="rounded">
                            </label>
                            <input type="file" id="profile_image_upload" name="profile_image" class="d-none">
                            <small class="text-muted">Click the image to upload a new one.</small>
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
                                <input type="tel" name="phone" class="form-control" id="phone" value="<?php echo htmlspecialchars($tasker_data['phone']); ?>">
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
                                        <th>Date & Time</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                                            <td><?php echo date('M d, Y \a\t h:i A', strtotime($booking['scheduled_datetime'])); ?></td>
                                            <td><?php echo nl2br(htmlspecialchars($booking['message'])); ?></td>
                                            <td>
                                                <form action="update_booking_status.php" method="POST">
                                                    <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                                        <option value="Pending" <?php echo ($booking['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Accepted" <?php echo ($booking['status'] == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                                                        <option value="Rejected" <?php echo ($booking['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                        <option value="Completed" <?php echo ($booking['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                    </select>
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
                                You currently have no pending orders.
                            <?php elseif ($active_tab === 'history'): ?>
                                Your order history is currently empty.
                            <?php else: ?>
                                You currently have no orders.
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