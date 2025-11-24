<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Load cart from session
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<div class='container mt-5'><div class='alert alert-info'>Your cart is empty. <a href='products.php'>Shop now</a></div></div>";
    exit();
}

// Calculate total
$grandTotal = 0;
foreach ($cart as $item) {
    $grandTotal += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - ShopLite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f7f9fc; }
        .checkout-wrapper { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 18px rgba(0,0,0,0.08);}
        .cart-summary { background: #f1f3f6; padding: 20px; border-radius: 12px; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="checkout-wrapper row g-4">
        <!-- Billing / Shipping Form -->
        <div class="col-md-6">
            <h4 class="mb-3"><i class="bi bi-person-badge"></i> Shipping Details</h4>
            <form method="POST" action="../process/process_checkout.php">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3" required></textarea>
                </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-md-6">
            <h4 class="mb-3"><i class="bi bi-cart-check"></i> Order Summary</h4>
            <div class="cart-summary mb-3">
                <?php foreach ($cart as $item): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <div><?= htmlspecialchars($item['name']); ?> x <?= $item['quantity']; ?></div>
                        <div>₦<?= number_format($item['price'] * $item['quantity'], 2); ?></div>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <div>Total:</div>
                    <div>₦<?= number_format($grandTotal, 2); ?></div>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100"><i class="bi bi-bag-check"></i> Place Order</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
