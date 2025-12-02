<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>ShopLite Admin</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
            background: #f5f6f8;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #212529;
            color: white;
            height: 100vh;
            position: fixed;
        }

        .sidebar a {
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            color: #cfd3d7;
            font-size: 15px;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background: #343a40;
            color: #fff;
        }

        .sidebar .active {
            background: #0d6efd;
            color: white;
        }

        .content {
            margin-left: 260px;
            padding: 25px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar p-3">

        <h3 class="text-center mb-4 fw-bold">ShopLite Admin</h3>

        <a href="admin_dashboard.php"
           class="<?= basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="admin_products.php"
           class="<?= basename($_SERVER['PHP_SELF']) == 'admin_products.php' ? 'active' : '' ?>">
            <i class="bi bi-box-seam me-2"></i> Products
        </a>

        <a href="orders.php"
           class="<?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : '' ?>">
            <i class="bi bi-cart-check me-2"></i> Orders
        </a>

        <a href="users.php"
           class="<?= basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : '' ?>">
            <i class="bi bi-people me-2"></i> Users
        </a>

        <a href="logout.php">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>

    </div>

    <div class="content">
