<?php
include("../includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/Logo.png">
    <title>Login / Sign Up - ShopLite</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg border-bottom py-3">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <img src="../assets/images/logo.png" alt="ShopLite Logo" height="50" class="me-2">
                <span class="fw-bold fs-4">ShopLite</span>
            </a>
        </div>
    </nav>

    <!-- Auth Section -->
    <section class="auth-section d-flex justify-content-center align-items-center vh-100">
        <div class="auth-box shadow-lg p-4 rounded-4 bg-white" style="max-width: 400px; width: 100%;">

            <!-- Login Form -->
            <div id="loginForm">
                <h2 class="text-center mb-3">Login</h2>
                <form action="../process/process_login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <p class="text-center mt-3">
                    Don’t have an account?
                    <span class="toggle-link text-primary fw-semibold" onclick="showSignup()"
                        style="cursor:pointer;">Sign up</span>
                </p>
            </div>

            <!-- Sign Up Form -->
            <div id="signupForm" style="display:none;">
                <h2 class="text-center mb-3">Create Account</h2>
                <form action="../process/process_signup.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="signupEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="signupEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="signupPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="signupPassword" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>
                <p class="text-center mt-3">
                    Already have an account?
                    <span class="toggle-link text-primary fw-semibold" onclick="showLogin()"
                        style="cursor:pointer;">Login</span>
                </p>
            </div>

        </div>
    </section>

    <!-- JS -->
    <script>
        function showSignup() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('signupForm').style.display = 'block';
        }

        function showLogin() {
            document.getElementById('signupForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>