<?php
session_start();
include("../includes/db.php");

// Check if user is logged in
$isLoggedIn = isset($_SESSION['name']);
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
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="../index.php">
        <img src="../assets/images/logo.png" alt="ShopLite Logo" height="40" class="me-2">
        <span class="fw-bold">ShopLite</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto align-items-center">
          <?php if (!$isLoggedIn): ?>
            <!-- Show Home link only for guests -->
            <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
          <li class="nav-item">
            <a class="nav-link position-relative" href="cart.php">
              🛒 Cart
              <!-- Optional badge to show item count -->
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
              </span>
            </a>
          </li>
          <?php if ($isLoggedIn): ?>
            <!-- Dropdown menu for logged in user -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($_SESSION['name']); ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="../pages/profile.php"><i class="bi bi-person me-2"></i> Profile</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="../process/logout.php"><i
                      class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="../pages/login.php">Login</a></li>
          <?php endif; ?>
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

                  <!-- Product Actions -->
                  <div class="d-grid gap-2 mt-3">
                    <!-- View Details button -->
                    <a href="../includes/product-details.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary">
                      View Details
                    </a>
                    <?php if ($isLoggedIn): ?>
                      <!-- Add to Cart form -->
                      <form method="POST" action="../process/add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['name']); ?>">
                        <input type="hidden" name="product_price" value="<?= $row['price']; ?>">
                        <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['image']); ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-success">
                          <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                      </form>
                    <?php else: ?>
                      <a href="../pages/login.php" class="btn btn-warning">Login to Add to Cart</a>
                    <?php endif; ?>
                  </div>
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