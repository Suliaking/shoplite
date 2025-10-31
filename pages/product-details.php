<?php
include("../includes/db.php");

if (!isset($_GET['id'])) {
    die("Product not found.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-5">
    <div class="row">
      <div class="col-md-6">
        <img src="../uploads/<?= htmlspecialchars($product['image']); ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($product['name']); ?>">
      </div>
      <div class="col-md-6">
        <h2><?= htmlspecialchars($product['name']); ?></h2>
        <p class="text-success fw-bold fs-4">₦<?= number_format($product['price'], 2); ?></p>
        <p><?= htmlspecialchars($product['description']); ?></p>
        <a href="cart.php?id=<?= $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
      </div>
    </div>
  </div>
</body>
</html>
