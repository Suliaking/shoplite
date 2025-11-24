<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: ../pages/cart.php");
    exit();
}

// Get shipping info from form
$name = $conn->real_escape_string($_POST['name'] ?? '');
$email = $conn->real_escape_string($_POST['email'] ?? '');
$phone = $conn->real_escape_string($_POST['phone'] ?? '');
$address = $conn->real_escape_string($_POST['address'] ?? '');

// Calculate total
$total_amount = 0;
foreach ($cart as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Insert into orders table
$stmt_order = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Pending')");
$stmt_order->bind_param("id", $user_id, $total_amount);
$stmt_order->execute();

$order_id = $stmt_order->insert_id;

// Insert each item into order_items
$stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity) VALUES (?, ?, ?, ?, ?)");
foreach ($cart as $product_id => $item) {
    $stmt_item->bind_param(
        "iisdi",
        $order_id,
        $product_id,
        $item['name'],
        $item['price'],
        $item['quantity']
    );
    $stmt_item->execute();
}

// Clear user's cart in DB
$stmt_del = $conn->prepare("DELETE FROM cart WHERE user_id=?");
$stmt_del->bind_param("i", $user_id);
$stmt_del->execute();

// Clear session cart
unset($_SESSION['cart']);

// Redirect to orders page
header("Location: ../pages/orders.php?success=1");
exit();
?>
