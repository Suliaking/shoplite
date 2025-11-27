<?php
include("../includes/db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optionally, remove the product image file
    $product = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();
    if ($product && !empty($product['image']) && file_exists("../uploads/".$product['image'])) {
        unlink("../uploads/".$product['image']); // delete image
    }

    // Delete product from DB
    $conn->query("DELETE FROM products WHERE id=$id");
}

header("Location: admin_products.php");
exit();
