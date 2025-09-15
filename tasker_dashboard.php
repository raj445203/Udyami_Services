<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['tasker_id'])) {
    header("Location: login_tasker.php");
    exit();
}

require 'db.php'; // Database connection

$tasker_id = $_SESSION['tasker_id'];
$tasker_data = null;

// Fetch tasker profile data
$stmt = $conn->prepare("SELECT * FROM taskers WHERE id = ?");
$stmt->bind_param("i", $tasker_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $tasker_data = $result->fetch_assoc();
} else {
    session_destroy();
    header("Location: login_tasker.php");
    exit();
}

$stmt->close();

// Query to get ALL orders for this tasker, joining with users table
$all_orders_stmt = $conn->prepare("
    SELECT b.*, u.fullname AS user_name
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    WHERE b.tasker_id = ?
    ORDER BY b.created_at DESC
");
$all_orders_stmt->bind_param("i", $tasker_id);
$all_orders_stmt->execute();
$all_orders_result = $all_orders_stmt->get_result();

// Query to get PENDING orders
$pending_orders_stmt = $conn->prepare("
    SELECT b.*, u.fullname AS user_name
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    WHERE b.tasker_id = ? AND b.status = 'Pending'
    ORDER BY b.created_at DESC
");
$pending_orders_stmt->bind_param("i", $tasker_id);
$pending_orders_stmt->execute();
$pending_orders_result = $pending_orders_stmt->get_result();

// Query to get COMPLETED & REJECTED orders (history)
$history_stmt = $conn->prepare("
    SELECT b.*, u.fullname AS user_name
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    WHERE b.tasker_id = ? AND b.status IN ('Completed', 'Rejected')
    ORDER BY b.created_at DESC
");
$history_stmt->bind_param("i", $tasker_id);
$history_stmt->execute();
$history_result = $history_stmt->get_result();

$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);

include('header.php');
?>

<div class="container-fluid py-4">
    <?php if ($success): ?>
        <script>
            Swal.fire('Success', '<?= addslashes($success) ?>', 'success');
        </script>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-3 col-lg-2 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-info text-white rounded-top-4">
                    <h5 class="mb-0">Dashboard</h5>
                </div>
                <div class="list-group list-group-flush">
                    <button class="list-group-item list-group-item-action active" data-bs-toggle="tab" data-bs-target="#profile">
                        <i class="bi bi-person-circle me-2"></i> Your Profile
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#orders">
                        <i class="bi bi-list-check me-2"></i> All Orders
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#pending-orders">
                        <i class="bi bi-hourglass-split me-2"></i> Pending Orders
                    </button>
                    <button class="list-group-item list-group-item-action" data-bs-toggle="tab" data-bs-target="#history">
                        <i class="bi bi-clock-history me-2"></i> History
                    </button>
                    <a href="logout.php" class="list-group-item list-group-item-action text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="profile">
                    <div class="card shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-header bg-info text-white rounded-top-4">
                            <h4 class="mb-0">Welcome, <?= htmlspecialchars($tasker_data['fullname']) ?>!</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3 text-green border-bottom pb-2">Your Profile Details</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <p><strong>Full Name:</strong> <?= htmlspecialchars($tasker_data['fullname']) ?></p>
                                    <p><strong>Gender:</strong> <?= htmlspecialchars($tasker_data['gender']) ?></p>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($tasker_data['email']) ?></p>
                                    <p><strong>Phone:</strong> <?= htmlspecialchars($tasker_data['phone']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($tasker_data['address'])) ?></p>
                                    <p><strong>Category:</strong> <?= htmlspecialchars($tasker_data['category']) ?></p>
                                    <p><strong>Skills:</strong> <?= htmlspecialchars($tasker_data['skills']) ?></p>
                                    <p><strong>Experience:</strong> <?= htmlspecialchars($tasker_data['experience_years']) ?> years</p>
                                    <p><strong>Preferred Location:</strong> <?= htmlspecialchars($tasker_data['preferred_location']) ?></p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="orders">
                    <div class="card shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-header bg-primary text-white rounded-top-4">
                            <h5 class="mb-0">All Orders</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($all_orders_result->num_rows > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Date & Time</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($booking = $all_orders_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($booking['user_name']) ?></td>
                                                    <td><?= date('M d, Y \a\t h:i A', strtotime($booking['scheduled_datetime'])) ?></td>
                                                    <td><?= nl2br(htmlspecialchars($booking['message'])) ?></td>
                                                    <td>
                                                        <form action="update_booking_status.php" method="POST">
                                                            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
                                                            <select name="status" class="form-select" onchange="this.form.submit()">
                                                                <option value="Pending" <?= ($booking['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="Accepted" <?= ($booking['status'] == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                                                                <option value="Rejected" <?= ($booking['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                                <option value="Completed" <?= ($booking['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                            </select>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">You currently have no orders.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pending-orders">
                    <div class="card shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-header bg-warning text-white rounded-top-4">
                            <h5 class="mb-0">Pending Orders</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($pending_orders_result->num_rows > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Date & Time</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($booking = $pending_orders_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($booking['user_name']) ?></td>
                                                    <td><?= date('M d, Y \a\t h:i A', strtotime($booking['scheduled_datetime'])) ?></td>
                                                    <td><?= nl2br(htmlspecialchars($booking['message'])) ?></td>
                                                    <td>
                                                        <form action="update_booking_status.php" method="POST">
                                                            <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['id']) ?>">
                                                            <select name="status" class="form-select" onchange="this.form.submit()">
                                                                <option value="Pending" <?= ($booking['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="Accepted" <?= ($booking['status'] == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                                                                <option value="Rejected" <?= ($booking['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                                <option value="Completed" <?= ($booking['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                            </select>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">You currently have no pending orders.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="history">
                    <div class="card shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-header bg-secondary text-white rounded-top-4">
                            <h5 class="mb-0">Order History</h5>
                        </div>
                        <div class="card-body">
                            <?php if ($history_result->num_rows > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Date & Time</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($booking = $history_result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($booking['user_name']) ?></td>
                                                    <td><?= date('M d, Y \a\t h:i A', strtotime($booking['scheduled_datetime'])) ?></td>
                                                    <td><?= nl2br(htmlspecialchars($booking['message'])) ?></td>
                                                    <td>
                                                        <span class="badge 
                                                            <?php
                                                            switch($booking['status']) {
                                                                case 'Accepted': echo 'bg-success'; break;
                                                                case 'Rejected': echo 'bg-danger'; break;
                                                                case 'Completed': echo 'bg-info'; break;
                                                                default: echo 'bg-warning'; break;
                                                            }
                                                            ?>">
                                                            <?= htmlspecialchars($booking['status']) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">Your order history is currently empty.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<?php 
// Close all prepared statements and the database connection at the end
$all_orders_stmt->close();
$pending_orders_stmt->close();
$history_stmt->close();
$conn->close();

include('footer.php'); ?>