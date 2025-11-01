<?php
include("includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShopLite - Home</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="assets/images/logo.png" alt="ShopLite Logo" height="40" class="me-2">
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

  <!-- Hero Section -->
  <header class="py-5 text-center">
    <div class="container">
      <img src="assets/images/logo.png" alt="ShopLite Logo" height="100" class="mb-3">
      <h1 class="display-4 fw-bold">Welcome to ShopLite</h1>
      <p class="lead">Your one-stop shop for the best online deals.</p>
      <a href="products.php" class="btn btn-primary btn-lg mt-3">Shop Now</a>
    </div>
  </header>

  <!-- Featured Products -->
  <section class="py-5">
    <div class="container">
      <h2 class="text-center mb-4 fw-bold">Featured Products</h2>
      <div class="row g-4">
        <?php
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 6";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $imagePath = "uploads/" . htmlspecialchars($row['image']);
            echo "
              <div class='col-md-4'>
                <div class='card h-100 shadow-sm'>
                  <img src='$imagePath' class='card-img-top' alt='" . htmlspecialchars($row['name']) . "'>
                  <div class='card-body text-center'>
                    <h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>
                    <p class='text-success fw-bold'>₦" . number_format($row['price'], 2) . "</p>
                    <a href='pages/product-details.php?id=" . $row['id'] . "' class='btn btn-primary'>View</a>
                  </div>
                </div>
              </div>
            ";
          }
        } else {
          echo "<p class='text-center text-muted'>No products available right now.</p>";
        }

        $conn->close();
        ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-3">
    <small>&copy; <?= date("Y"); ?> ShopLite. All rights reserved.</small>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
