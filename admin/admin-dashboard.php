<?php
require 'admin-auth.php';
require '../db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">Admin Panel</span>
    <span class="text-white">
        <?= $_SESSION['admin_name'] ?>
        <a href="admin-logout.php" class="btn btn-sm btn-danger ms-3">Logout</a>
    </span>
</nav>

<div class="container mt-4">
    <h3>Welcome Admin 👋</h3>

    <div class="row mt-4">
        <div class="col-md-4">
            <a href="pending-taskers.php" class="card text-decoration-none shadow">
                <div class="card-body text-center">
                    <h5>Pending Tasker Requests</h5>
                </div>
            </a>
        </div>
    </div>
</div>

</body>
</html>
