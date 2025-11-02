<?php
include("../includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/Logo.png">
  <title>All Products - ShopLite</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
+  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

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
          <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="../pages/cart.php">Cart</a></li>
          <li class="nav-item"><a class="nav-link" href="../pages/login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="py-5 text-center bg-light">
    <div class="container">
      <h1 class="fw-bold display-5">Our Products</h1>
      <p class="lead text-muted">Browse our latest and most popular items</p>
    </div>
  </header>

  <!-- Products Grid -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <?php
        $sql = "SELECT * FROM products ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $imagePath = "../uploads/" . htmlspecialchars($row['image']);
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 d-flex">
              <div class="card product-card shadow-sm flex-fill">
                <div class="card-img-container">
                  <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>">
                </div>
                <div class="card-body text-center d-flex flex-column justify-content-between">
                  <div>
                    <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                    <p class="text-success fw-bold">₦<?= number_format($row['price'], 2) ?></p>
                  </div>
                  <a href="../pages/product-details.php?id=<?= $row['id'] ?>" class="btn btn-primary mt-2">View</a>
                </div>
              </div>
            </div>
        <?php
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
