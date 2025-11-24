<?php
session_start();
include("../includes/db.php");

// Must be logged in to add to cart
if (!isset($_SESSION['name']) || !isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get product from POST
if (isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);

    // 1️⃣ Fetch product from DB instead of trusting hidden inputs
    $stmt = $conn->prepare("SELECT name, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product) {
        die("Product not found!");
    }

    // ==============================
    // 2️⃣ SAVE / UPDATE CART IN DATABASE
    // ==============================
    $check = $conn->prepare("SELECT quantity FROM cart WHERE user_id=? AND product_id=?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $exists = $check->get_result();

    if ($exists->num_rows > 0) {
        // Increase quantity
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id=? AND product_id=?");
        $update->bind_param("ii", $user_id, $product_id);
        $update->execute();
    } else {
        // Insert new row
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $insert->bind_param("ii", $user_id, $product_id);
        $insert->execute();
    }

    // ==============================
    // 3️⃣ UPDATE SESSION CART
    // ==============================
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1
        ];
    } else {
        $_SESSION['cart'][$product_id]['quantity']++;
    }

    header("Location: ../pages/cart.php");
    exit();
}
?>