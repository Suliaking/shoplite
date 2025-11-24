<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Load cart from DB into session
$_SESSION['cart'] = [];

$sql = "
SELECT c.product_id, c.quantity, p.name, p.price, p.image
FROM cart c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $_SESSION['cart'][$row['product_id']] = [
        'name' => $row['name'],
        'price' => $row['price'],
        'image' => $row['image'],
        'quantity' => $row['quantity']
    ];
}

// ======================
// REMOVE ITEM FROM CART
// ======================
if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);

    // Remove from DB
    $del = $conn->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
    $del->bind_param("ii", $user_id, $product_id);
    $del->execute();

    // Remove from session
    unset($_SESSION['cart'][$product_id]);

    header("Location: ../pages/cart.php");
    exit();
}

// ======================
// UPDATE CART
// ======================
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $qty) {
        $qty = intval($qty);

        if ($qty <= 0) {
            // Delete row from DB
            $del = $conn->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
            $del->bind_param("ii", $user_id, $product_id);
            $del->execute();

            unset($_SESSION['cart'][$product_id]);
        } else {
            // Update DB quantity
            $upd = $conn->prepare("UPDATE cart SET quantity=? WHERE user_id=? AND product_id=?");
            $upd->bind_param("iii", $qty, $user_id, $product_id);
            $upd->execute();

            $_SESSION['cart'][$product_id]['quantity'] = $qty;
        }
    }

    header("Location: ../pages/cart.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Cart - ShopLite</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f7f9fc;
        }

        .cart-wrapper {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
        }

        .product-img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 10px;
        }

        .table thead th {
            background: #212529;
            color: #fff;
        }

        .checkout-bar {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.1);
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        .update-btn, .remove-btn {
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <!-- CART HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">
                <i class="bi bi-cart-check"></i> Shopping Cart
            </h2>

            <a href="../pages/products.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Continue Shopping
            </a>
        </div>

        <!-- EMPTY CART MESSAGE -->
        <?php if (empty($_SESSION['cart'])): ?>
            <div class="alert alert-info text-center p-4">
                <h5>Your cart is currently empty</h5>
                <p class="mb-0">Go back and add some products to your cart.</p>
                <br>
                <a href="../pages/products.php" class="btn btn-primary">
                    <i class="bi bi-shop"></i> Browse Products
                </a>
            </div>

        <?php else: ?>

            <!-- CART TABLE WRAPPER -->
            <form method="POST">
                <div class="cart-wrapper">

                    <div class="table-responsive">
                        <table class="table align-middle text-center">
                            <thead>
                                <tr>
                                    <th class="text-start">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $grandTotal = 0;
                                foreach ($_SESSION['cart'] as $id => $item):
                                    $total = $item['price'] * $item['quantity'];
                                    $grandTotal += $total;
                                ?>

                                    <tr>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                <img src="../uploads/<?= $item['image']; ?>" class="product-img me-3">
                                                <div>
                                                    <strong><?= htmlspecialchars($item['name']); ?></strong>
                                                </div>
                                            </div>
                                        </td>

                                        <td><span class="fw-bold text-success">₦<?= number_format($item['price'], 2); ?></span></td>

                                        <td style="width: 120px;">
                                            <input
                                                type="number"
                                                name="quantities[<?= $id; ?>]"
                                                value="<?= $item['quantity']; ?>"
                                                min="1"
                                                class="form-control text-center"
                                            >
                                        </td>

                                        <td class="fw-bold">₦<?= number_format($total, 2); ?></td>

                                        <td>
                                            <a href="cart.php?remove=<?= $id; ?>" 
                                               class="btn btn-sm btn-danger remove-btn">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- CHECKOUT BAR -->
                <div class="checkout-bar mt-4 d-flex justify-content-between align-items-center">

                    <button type="submit" name="update_cart" class="btn btn-warning update-btn">
                        <i class="bi bi-arrow-repeat"></i> Update Cart
                    </button>

                    <h4 class="mb-0 fw-bold">
                        Total:
                        <span class="text-success">₦<?= number_format($grandTotal, 2); ?></span>
                    </h4>

                    <a href="checkout.php" class="btn btn-success btn-lg">
                        <i class="bi bi-bag-check"></i> Checkout
                    </a>
                </div>

            </form>

        <?php endif; ?>

    </div>

</body>
</html>
