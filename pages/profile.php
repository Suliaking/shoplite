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
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #4b2c20;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-white" href="../index.php">
                <img src="../assets/images/logo.png" alt="ShopLite Logo" height="40" class="me-2">
                <span class="fw-bold">ShopLite</span>
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link text-white mx-3" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-warning mx-3 fw-semibold"
                            href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link text-white mx-3" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link text-white mx-3" href="cart.php">🛒 Cart</a></li>

                    <li class="nav-item">
                        <a href="../process/logout.php" class="btn btn-danger btn-sm ms-3 px-3 fw-semibold">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="container py-5">

        <!-- Profile Header -->
        <div class="profile-header mb-4">
            <img src="../profile_image_upload/<?= !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : 'default.jpg'; ?>"
                alt="Profile Image">
            <h3 class="mt-3"><?= htmlspecialchars($user['name']); ?></h3>
            <p class="text-muted"><?= htmlspecialchars($user['email']); ?></p>
        </div>

        <!-- Profile Tabs -->
        <ul class="nav nav-tabs justify-content-center mb-4 profile-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#overview">
                    <i class="bi bi-person-lines-fill me-1"></i> Overview
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

            <!-- Overview -->
            <div class="tab-pane fade show active" id="overview">
                <div class="form-card">

                    <h5 class="mb-3">Account Information</h5>

                    <p><b>Name:</b> <?= htmlspecialchars($user['name']); ?></p>
                    <p><b>Email:</b> <?= htmlspecialchars($user['email']); ?></p>
                    <p><b>Phone:</b> <?= htmlspecialchars($user['phone'] ?? 'Not added'); ?></p>
                    <p><b>Address:</b> <?= htmlspecialchars($user['address'] ?? 'No address'); ?></p>

                </div>
            </div>

            <!-- Edit Profile -->
            <div class="tab-pane fade" id="edit">
                <div class="form-card">

                    <h5 class="mb-3">Edit Profile</h5>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="label-title">Name</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="label-title">Phone</label>
                            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? ''); ?>"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="label-title">Address</label>
                            <textarea name="address"
                                class="form-control"><?= htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="label-title">Change Profile Picture</label>
                            <input type="file" name="profile_pic" class="form-control">
                        </div>

                        <button type="submit" name="update_profile" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Save Changes
                        </button>

                    </form>

                </div>
            </div>

            <!-- Security -->
            <div class="tab-pane fade" id="security">
                <div class="form-card">
                    <h5 class="mb-3">Security Settings</h5>

                    <p>You can change your password using the button below.</p>

                    <a href="change_password.php" class="btn btn-warning w-100">
                        <i class="bi bi-lock"></i> Change Password
                    </a>
                </div>
            </div>

            <!-- Activity -->
            <div class="tab-pane fade" id="activity">
                <div class="form-card">
                    <h5 class="mb-3">Recent Activity</h5>

                    <p class="text-muted">You have no recent activity yet.</p>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;

        // Load saved theme
        if (localStorage.getItem("theme") === "dark") {
            body.classList.add("dark-mode");
            themeToggle.innerHTML = `<i class="bi bi-brightness-high"></i>`;
        }

        // Toggle dark/light mode
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