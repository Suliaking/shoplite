<?php
session_start();
include("../includes/db.php");

// Ensure user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: ../pages/login.php");
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
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #4b2c20;">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center text-white" href="../index.php">
                <img src="../assets/images/logo.png" alt="ShopLite Logo" height="42" class="me-2">
                <span class="fw-semibold fs-5">ShopLite</span>
            </a>

            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto nav-menu">

                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold active-link" href="dashboard.php">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="products.php">Products</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="orders.php">Orders</a>
                    </li>

                    <li class="nav-item position-relative">
                        <a class="nav-link text-white" href="cart.php">🛒 Cart</a>
                        <span class="badge rounded-pill position-absolute top-0 start-100 translate-middle bg-danger"
                            style="font-size: 0.65rem;">
                            2
                        </span>
                    </li>

                </ul>
            </div>

        </div>
    </nav>

    <!-- Fund Wallet Modal -->
    <div class="modal fade" id="fundWalletModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Fund Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="../process/fund_wallet.php" method="POST">

                    <!-- This hidden field MUST be inside the form -->
                    <input type="hidden" name="name" value="<?= $user['name']; ?>">

                    <div class="modal-body">
                        <label class="form-label">Enter Amount</label>
                        <input type="number" name="amount" class="form-control" required min="100"
                            placeholder="Minimum ₦100">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Funds</button>
                    </div>

                </form>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success text-center">
                        Wallet funded successfully!
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Profile Header -->
    <div class="container py-5 text-center">

        <img src="../profile_image_upload/<?= !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : 'default.png'; ?>"
            alt="Profile Image" class="rounded-circle shadow-sm"
            style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #ddd;">

        <h3 class="mt-3 mb-0"><?= htmlspecialchars($user['name']); ?></h3>
        <p class="text-muted"><?= htmlspecialchars($user['email']); ?></p>

    </div>


    <!-- Profile Tabs -->
    <ul class="nav nav-tabs justify-content-center mb-4 profile-tabs">

        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#overview">
                <i class="bi bi-person-lines-fill me-1"></i> Overview
            </a>
        </li>

        <!-- WALLET TAB BUTTON -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#wallet">
                <i class="bi bi-wallet2 me-1"></i> Wallet
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#edit">
                <i class="bi bi-pencil-square me-1"></i> Edit Profile
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#security">
                <i class="bi bi-shield-lock me-1"></i> Security
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#activity">
                <i class="bi bi-clock-history me-1"></i> Recent Activity
            </a>
        </li>

        <li class="nav-item">
            <button id="themeToggle" class="btn btn-outline-light btn-sm ms-3">
                <i class="bi bi-moon-stars"></i>
            </button>
        </li>

    </ul>

    <!-- Tab Content -->
    <div class="tab-content">


        <!-- OVERVIEW TAB -->
        <div class="tab-pane fade show active" id="overview">
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">

                        <div class="card shadow-sm border-0 text-center">
                            <div class="card-body">

                                <h5 class="card-title mb-4">Account Information</h5>

                                <p><strong>Name:</strong> <span class="text-muted"><?= $user['name']; ?></span></p>
                                <p><strong>Email:</strong> <span class="text-muted"><?= $user['email']; ?></span></p>
                                <p><strong>Phone:</strong> <span
                                        class="text-muted"><?= $user['phone'] ?? 'Not added'; ?></span></p>
                                <p><strong>Address:</strong> <span
                                        class="text-muted"><?= $user['address'] ?? 'No address'; ?></span></p>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- WALLET TAB -->
        <div class="tab-pane fade" id="wallet">
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">

                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body text-center">

                                <h4 class="mb-3">
                                    <i class="bi bi-wallet2 me-1"></i> My Wallet
                                </h4>

                                <p class="mb-1">
                                    <strong>Wallet Balance:</strong>
                                    <span class="text-success fw-bold fs-4">
                                        ₦<?= number_format($user['wallet_balance'], 2); ?>
                                    </span>
                                </p>

                                <p class="mb-3">
                                    <strong>Account Number:</strong>
                                    <span class="text-primary fw-semibold">
                                        <?= $user['account_number'] ?? 'Not Assigned'; ?>
                                    </span>
                                </p>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#fundWalletModal">
                                        Fund Wallet
                                    </button>

                                    <a href="wallet_history.php" class="btn btn-outline-secondary btn-lg">
                                        <i class="bi bi-clock-history"></i> Wallet History
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- EDIT PROFILE TAB -->
        <div class="tab-pane fade" id="edit">
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">

                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">

                                <h4 class="mb-4 text-center">Edit Profile</h4>

                                <form action="../process/update_profile.php" method="POST"
                                    enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <input type="text" name="name" class="form-control form-control-lg"
                                            value="<?= $user['name']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            value="<?= $user['email']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Phone Number</label>
                                        <input type="text" name="phone" class="form-control form-control-lg"
                                            value="<?= $user['phone']; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Address</label>
                                        <textarea name="address" class="form-control form-control-lg"
                                            rows="2"><?= $user['address']; ?></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Change Profile Picture</label>
                                        <input type="file" name="profile_pic" class="form-control">
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" name="save_changes" class="btn btn-primary btn-lg">
                                            Save Changes
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- SECURITY TAB -->
        <div class="tab-pane fade" id="security">
            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
                <h5 class="mb-3 fw-bold"><i class="bi bi-shield-lock-fill text-warning"></i> Security Settings</h5>

                <p class="text-muted">You can change your password here.</p>

                <a href="change_password.php" class="btn btn-warning w-100">
                    <i class="bi bi-lock"></i> Change Password
                </a>
            </div>
        </div>


        <!-- ACTIVITY TAB -->
        <div class="tab-pane fade" id="activity">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="mb-3">Recent Activity</h5>
                <p class="text-muted">You have no recent activity yet.</p>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;

        if (localStorage.getItem("theme") === "dark") {
            body.classList.add("dark-mode");
            themeToggle.innerHTML = `<i class="bi bi-brightness-high"></i>`;
        }

        themeToggle.addEventListener("click", () => {
            body.classList.toggle("dark-mode");

            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("theme", "dark");
                themeToggle.innerHTML = `<i class="bi bi-brightness-high"></i>`;
            } else {
                localStorage.setItem("theme", "light");
                themeToggle.innerHTML = `<i class="bi bi-moon-stars"></i>`;
            }
        });
    </script>

</body>

</html>