<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - ShopLite</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/Logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-box-seam"></i> My Orders</h2>

    <?php if ($orders->num_rows == 0): ?>
        <div class="alert alert-info">You have no orders yet. <a href="products.php">Shop now</a></div>
    <?php else: ?>
        <?php while ($order = $orders->fetch_assoc()): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Order #<?= $order['id']; ?> <span class="badge bg-info"><?= $order['status']; ?></span></h5>
                    <p class="card-text">Placed on: <?= $order['created_at']; ?></p>

                    <ul class="list-group list-group-flush mb-2">
                        <?php
                        $stmt_items = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
                        $stmt_items->bind_param("i", $order['id']);
                        $stmt_items->execute();
                        $items = $stmt_items->get_result();

                        while ($item = $items->fetch_assoc()):
                        ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <?= htmlspecialchars($item['product_name']); ?> x <?= $item['quantity']; ?>
                                <span>₦<?= number_format($item['product_price'] * $item['quantity'],2); ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                    <div class="fw-bold text-end">Total: ₦<?= number_format($order['total_amount'],2); ?></div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
</body>
</html>
