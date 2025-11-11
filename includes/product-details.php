<?php
session_start();
include("../includes/db.php");

if (!isset($_GET['id'])) {
  die("Product not found.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Product not found.");
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']); ?> - ShopLite</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/product_details.css">
</head>

<body>
  <div class="container py-5">
    <div class="row g-4 align-items-center">
      <!-- Product Image -->
      <div class="col-md-6 text-center">
        <img src="../uploads/<?= htmlspecialchars($product['image']); ?>" class="img-fluid product-image shadow"
          alt="<?= htmlspecialchars($product['name']); ?>">
      </div>

      <!-- Product Info -->
      <div class="col-md-6">
        <h2 class="fw-bold"><?= htmlspecialchars($product['name']); ?></h2>
        <p class="text-success fw-bold fs-3 mb-3">₦<?= number_format($product['price'], 2); ?></p>
        <p class="text-muted"><?= nl2br(htmlspecialchars($product['description'])); ?></p>

        <!-- Add to Cart Form -->
        <form method="POST" action="../process/add_to_cart.php">
          <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
          <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']); ?>">
          <input type="hidden" name="product_price" value="<?= $product['price']; ?>">
          <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['image']); ?>">

          <button type="submit" name="add_to_cart" class="btn btn-success btn-lg">
            <i class="bi bi-cart-plus"></i> Add to Cart
          </button>
        </form>

        <hr class="my-4">

        <a href="../pages/products.php" class="btn btn-outline-secondary btn-sm">← Back to Products</a>
      </div>
    </div>

    <!-- Related Products Section -->
    <div class="mt-5">
      <h4 class="fw-bold mb-3">You may also like</h4>
      <div class="row g-3">
        <?php
        $related = $conn->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 3");
        while ($r = $related->fetch_assoc()):
          ?>
          <div class="col-md-4">
            <div class="card shadow-sm border-0">
              <img src="../uploads/<?= htmlspecialchars($r['image']); ?>" class="card-img-top"
                style="height: 200px; object-fit: cover;">
              <div class="card-body text-center">
                <h6><?= htmlspecialchars($r['name']); ?></h6>
                <p class="text-success fw-bold mb-2">₦<?= number_format($r['price'], 2); ?></p>
                <a href="product-details.php?id=<?= $r['id']; ?>" class="btn btn-sm btn-outline-dark">View</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>