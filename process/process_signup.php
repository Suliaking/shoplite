<?php
session_start();
include("../includes/db.php"); // adjust the path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data safely
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input fields
    if (empty($name) || empty($email) || empty($password)) {
        die("All fields are required!");
    }

    // Check if the email already exists in the database
    $checkQuery = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkQuery->bind_param("s", $email);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows > 0) {
        die("Email already registered. Please log in instead.");
    }

    // 🔹 Set default profile picture
    $default_pic = 'default.png';

    // Insert user details into the database, including the default picture
    $insertQuery = $conn->prepare("
        INSERT INTO users (name, email, password, profile_pic, created_at)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $insertQuery->bind_param("ssss", $name, $email, $password, $default_pic);

    if ($insertQuery->execute()) {
        // Set session and redirect to dashboard
        $_SESSION['name'] = $name;
        header("Location: ../pages/dashboard.php");
        exit();
    } else {
        echo "Error creating account. Please try again.";
    }

    // Close connections
    $insertQuery->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>