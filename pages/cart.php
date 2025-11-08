<?php
session_start();
include("../includes/db.php");

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // If product already exists, increase quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        // Add new product to cart
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => 1
        ];
    }

    header("Location: cart.php");
    exit();
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit();
}

// Update quantities
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        if ($qty > 0) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Cart - ShopLite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-cart-check"></i> Your Shopping Cart</h2>
            <a href="../pages/products.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to
                Products</a>
        </div>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="alert alert-info text-center">Your cart is empty. <a href="../pages/products.php">Continue
                    shopping</a>.</div>
        <?php else: ?>
            <form method="POST">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            foreach ($_SESSION['cart'] as $id => $item):
                                $total = (float) $_SESSION['cart'][$id]['price'] * (int) $_SESSION['cart'][$id]['quantity'];
                                $grandTotal += $total;
                                ?>
                                <tr>
                                    <td>
                                        <img src="../uploads/<?= htmlspecialchars($item['image']); ?>" width="60" height="60"
                                            class="rounded me-2">
                                        <?= htmlspecialchars($item['name']); ?>
                                    </td>
                                    <td>₦<?= number_format($item['price'], 2); ?></td>
                                    <td style="width: 120px;">
                                        <input type="number" name="quantities[<?= $id; ?>]" value="<?= $item['quantity']; ?>"
                                            min="1" class="form-control text-center">
                                    </td>
                                    <td>₦<?= number_format($total, 2); ?></td>
                                    <td>
                                        <a href="cart.php?remove=<?= $id; ?>" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Remove
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button type="submit" name="update_cart" class="btn btn-warning">
                        <i class="bi bi-arrow-repeat"></i> Update Cart
                    </button>

                    <h4>Total: <span class="text-success">₦<?= number_format($grandTotal, 2); ?></span></h4>
                </div>

                <div class="text-end mt-4">
                    <a href="#" class="btn btn-success btn-lg"><i class="bi bi-bag-check"></i> Proceed to Checkout</a>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>