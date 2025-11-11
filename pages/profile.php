<?php
session_start();
include("../includes/db.php");

// Ensure user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: ../login.php");
    exit();
}

$name = $_SESSION['name'];
$query = "SELECT * FROM users WHERE name = '$name'";

$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile - ShopLite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #4b2c20;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <img src="../assets/images/logo.png" alt="ShopLite Logo" height="40" class="me-2">
                <span class="fw-bold">ShopLite</span>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a href="dashboard.php"
                            class="nav-link text-white fw-semibold mx-2">Dashboard</a></li>
                    <li class="nav-item"><a href="profile.php"
                            class="nav-link text-warning fw-semibold mx-2">Profile</a></li>
                    <li class="nav-item"><a href="orders.php" class="nav-link text-white fw-semibold mx-2">Orders</a>
                    </li>
                    <li class="nav-item"><a href="cart.php" class="nav-link text-white fw-semibold mx-2"><i
                                class="bi bi-cart"></i> Cart</a></li>
                    <li class="nav-item">
                        <a href="../process/logout.php" class="btn btn-danger btn-sm ms-3 px-3 fw-semibold">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <img src="../profile_image_upload/<?= !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : 'default.jpg'; ?>"
                alt="Profile Image">
            <h3><?= htmlspecialchars($user['name']); ?></h3>
            <p class="text-muted mb-0"><?= htmlspecialchars($user['email']); ?></p>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" class="form-control"
                    readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? ''); ?>"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Address</label>
                <textarea name="address" rows="2"
                    class="form-control"><?= htmlspecialchars($user['address'] ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Profile Picture</label>
                <input type="file" name="profile_pic" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" name="update_profile" class="btn btn-primary"><i class="bi bi-save"></i> Update
                    Profile</button>
                <a href="change_password.php" class="btn btn-secondary"><i class="bi bi-lock"></i> Change Password</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>