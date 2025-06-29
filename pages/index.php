<?php
// Optionally start session if needed later
// session_start();
include("../includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopLite - Home</title>

  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Optional: Custom CSS -->
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">ShopLite</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <header class="bg-light py-5 text-center">
    <div class="container">
      <h1 class="display-4 fw-bold">Welcome to ShopLite</h1>
      <p class="lead">Your one-stop shop for the best online deals.</p>
      <a href="products.php" class="btn btn-primary btn-lg mt-3">Shop Now</a>
    </div>
  </header>

  <!-- Featured Products (Static Example) -->
  <section class="py-5 bg-white">
    <div class="container">
      <h2 class="text-center mb-4">Featured Products</h2>
      <div class="row g-4">
        <!-- Product Card -->
        <div class="col-md-4">
          <div class="card h-100">
            <img src="../assets/images/product1.jpg" class="card-img-top" alt="Product 1">
            <div class="card-body">
              <h5 class="card-title">Product Name</h5>
              <p class="card-text">₦10,000</p>
              <a href="product-details.php?id=1" class="btn btn-outline-primary">View</a>
            </div>
          </div>
        </div>
        <!-- Repeat cards as needed -->
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <small>&copy; <?= date("Y"); ?> ShopLite. All rights reserved.</small>
  </footer>

  <!-- Bootstrap JS CDN (Required for Navbar toggling) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
