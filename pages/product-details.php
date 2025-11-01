<?php
include("../includes/db.php");

if (!isset($_GET['id'])) {
  die("No product selected.");
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM products WHERE id = $id");

if ($result && $result->num_rows > 0) {
  $product = $result->fetch_assoc();
} else {
  die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($product['name']) ?> - ShopLite</title>

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
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="../assets/images/logo.png" alt="ShopLite Logo" height="40" class="me-2">
        <span class="fw-bold">ShopLite</span>
      </a>

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

<!-- Product Details Section -->
<div class="container py-5 product-details">

  <!-- Back Button -->
  <div class="mb-4">
    <button onclick="history.back()" class="btn btn-outline-brown">
      ← Back
    </button>
  </div>

  <div class="row align-items-center g-5">
    <div class="col-md-6 text-center">
      <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" 
           class="img-fluid rounded shadow-sm product-image" 
           alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <div class="col-md-6">
      <h2 class="fw-bold mb-3"><?= htmlspecialchars($product['name']) ?></h2>
      <p class="lead text-success fw-bold fs-4 mb-4">₦<?= number_format($product['price'], 2) ?></p>
      <p class="text-secondary mb-4"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      <button class="btn btn-primary btn-lg px-4">Add to Cart</button>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="text-center py-3 footer">
  <small>&copy; <?= date("Y"); ?> ShopLite. All rights reserved.</small>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
