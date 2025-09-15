<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['tasker_id'])) {
    header("Location: login_tasker.php");
    exit();
}

require 'db.php';

$tasker_id = $_SESSION['tasker_id'];
$tasker_data = null;

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
$conn->close();

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
        <!-- Sidebar -->
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

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="tab-content">
                <!-- Profile Tab -->
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

                <!-- Orders Tab -->
                <div class="tab-pane fade" id="orders">
                    <div class="card shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-header bg-primary text-white rounded-top-4">
                            <h5 class="mb-0">All Orders</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">You currently have no orders.</div>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders Tab -->
                <div class="tab-pane fade" id="pending-orders">
                    <div class="card shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-header bg-warning text-white rounded-top-4">
                            <h5 class="mb-0">Pending Orders</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">You currently have no pending orders.</div>
                        </div>
                    </div>
                </div>

                <!-- History Tab -->
                <div class="tab-pane fade" id="history">
                    <div class="card shadow-lg border-0 rounded-4 mb-4">
                        <div class="card-header bg-secondary text-white rounded-top-4">
                            <h5 class="mb-0">Order History</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-secondary">Your order history is currently empty.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<?php include('footer.php'); ?>
