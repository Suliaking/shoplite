<?php
session_start();

// If user is not logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Css -->
    <link rel="stylesheet" href="../assets/css/change_password.css">

</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- Back Button -->
    <a href="profile.php" class="text-decoration-none mb-3 d-inline-block">
        <i class="bi bi-arrow-left-circle fs-4"></i>
    </a>

    <div class="form-card">
        <h4 class="mb-3 fw-bold"><i class="bi bi-lock-fill"></i> Change Password</h4>

        <!-- Toast Message -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <form action="../process/change_password_process.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Old Password</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <button class="btn btn-warning w-100">Update Password</button>

        </form>
    </div>
</div>

</body>
</html>
