<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['name'])) {
    header("Location: ../pages/login.php");
    exit;
}

if (empty($_POST['old_password']) || empty($_POST['new_password'])) {
    header("Location: ../pages/change_password.php?msg=Please fill all fields");
    exit;
}

$name = $_SESSION['name'];
$old_pass = $_POST['old_password'];
$new_pass = $_POST['new_password'];

// Get current password
$stmt = $conn->prepare("SELECT password FROM users WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../pages/change_password.php?msg=User not found");
    exit;
}

$currentPassword = $result->fetch_assoc()['password'];
$stmt->close();

// Check old password
if ($old_pass !== $currentPassword) {
    header("Location: ../pages/change_password.php?msg=Old password is incorrect");
    exit;
}

// Update password
$update = $conn->prepare("UPDATE users SET password = ? WHERE name = ?");
$update->bind_param("ss", $new_pass, $name);

if ($update->execute()) {
    header("Location: ../pages/change_password.php?msg=Password updated successfully!");
} else {
    header("Location: ../pages/change_password.php?msg=Failed to update password");
}
?>
