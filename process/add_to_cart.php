<?php
session_start();

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if form data was sent
if (isset($_POST['add_to_cart'])) {
    
    // ✅ Check if user is logged in
    if (!isset($_SESSION['name'])) {
        // Redirect to login if not logged in
        header("Location: ../pages/login.php");
        exit();
    }

    // Get product data from form
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = (float) $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Check if product already in cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image,
            'quantity' => 1
        ];
    }

    // Redirect to cart page
    header("Location: ../pages/cart.php");
    exit();
    
} else {
    // Invalid request, redirect back to products
    header("Location: ../pages/products.php");
    exit();
}
?>
