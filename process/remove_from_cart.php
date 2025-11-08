<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['name'])) {
    header("Location: ../pages/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $cart_id = intval($_GET['id']);
    $conn->query("DELETE FROM cart WHERE id = $cart_id");
}

header("Location: ../pages/cart.php");
exit();
?>
