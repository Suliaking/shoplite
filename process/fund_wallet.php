<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['name'])) {
    die("You are not logged in.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_SESSION['name'];
    $amount = intval($_POST['amount']);

    if ($amount < 100) {
        die("Minimum funding amount is ₦100");
    }

    // 1. Get USER ID
    $getUser = $conn->prepare("SELECT id FROM users WHERE name = ?");
    $getUser->bind_param("s", $name);
    $getUser->execute();
    $result = $getUser->get_result();

    if ($result->num_rows !== 1) {
        die("User not found.");
    }

    $user = $result->fetch_assoc();
    $user_id = $user['id'];  // NOW it is NOT NULL

    // 2. Update wallet balance
    $update = $conn->prepare("UPDATE users SET wallet_balance = wallet_balance + ? WHERE id = ?");
    $update->bind_param("ii", $amount, $user_id);

    // 3. Add record to wallet_history
    $history = $conn->prepare("
        INSERT INTO wallet_history (user_id, amount, type, description)
        VALUES (?, ?, 'credit', 'Wallet Funding')
    ");
    $history->bind_param("id", $user_id, $amount);

    // Execute queries
    $history->execute();
    $update->execute();

    // 4. Redirect
    header("Location: ../pages/profile.php?success=1#wallet");
    exit();
}
?>