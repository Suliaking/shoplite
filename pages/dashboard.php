<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}
include("../includes/db.php");
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/Logo.png">
    <title>Dashboard - ShopLite</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <img src="../assets/images/logo.png" alt="ShopLite Logo" height="40" class="me-2">
                <span class="fw-bold">ShopLite</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="../process/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Personalized Welcome Section -->
    <header class="py-5 text-center bg-light border-bottom">
        <div class="container">
            <img src="../assets/images/logo.png" alt="ShopLite Logo" height="90" class="mb-3">
            <h1 class="fw-bold">Welcome, <?= htmlspecialchars($name); ?> 👋</h1>
            <p class="lead text-muted mb-3">Manage your account, view orders, and explore new deals.</p>
            <a href="products.php" class="btn btn-primary btn-lg mt-2">Shop Now</a>
        </div>
    </header>

    <!-- Dashboard Cards Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-4">Quick Access</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm text-center p-4 border-0">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">Your Profile</h5>
                            <p class="text-muted mb-3">Update your personal information and password.</p>
                            <a href="profile.php" class="btn btn-outline-primary w-100">View Profile</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm text-center p-4 border-0">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">Your Orders</h5>
                            <p class="text-muted mb-3">Check your order history and delivery progress.</p>
                            <a href="orders.php" class="btn btn-outline-success w-100">View Orders</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm text-center p-4 border-0">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">Logout</h5>
                            <p class="text-muted mb-3">End your session securely.</p>
                            <a href="../process/logout.php" class="btn btn-outline-danger w-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-3 border-top">
        <small>&copy; <?= date("Y"); ?> ShopLite. All rights reserved.</small>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>