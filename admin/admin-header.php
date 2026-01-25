<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Udyami Admin</span>
    <span class="text-white">
        <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?>
    </span>
    <a href="admin-logout.php" class="btn btn-sm btn-danger ms-3">Logout</a>
</nav>

<div class="container mt-4">
