<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("../includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - ShopLite</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
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

        .card {
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Sidebar -->
    <div class="sidebar p-3">

        <h3 class="text-center mb-4 fw-bold">ShopLite Admin</h3>

        <a href="admin_dashboard.php" class="active">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="admin_products.php">
            <i class="bi bi-box-seam me-2"></i> Products
        </a>

        <a href="orders.php">
            <i class="bi bi-cart-check me-2"></i> Orders
        </a>

        <a href="users.php">
            <i class="bi bi-people me-2"></i> Users
        </a>

        <a href="logout.php">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>

    </div>

    <!-- Content Area -->
    <div class="content">

        <h2 class="mb-3">Welcome, <?= htmlspecialchars($_SESSION['admin_name']); ?></h2>

        <div class="row g-3">

            <!-- Total Products -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h6 class="text-muted">Total Products</h6>
                    <h2 class="fw-bold">
                        <?php
                        $result = $conn->query("SELECT COUNT(*) AS total FROM products");
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?>
                    </h2>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h6 class="text-muted">Total Users</h6>
                    <h2 class="fw-bold">
                        <?php
                        $result = $conn->query("SELECT COUNT(*) AS total FROM users");
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?>
                    </h2>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <h6 class="text-muted">Total Orders</h6>
                    <h2 class="fw-bold">
                        <?php
                        $result = $conn->query("SELECT COUNT(*) AS total FROM orders");
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?>
                    </h2>
                </div>
            </div>

        </div>

    </div>

</body>

</html>