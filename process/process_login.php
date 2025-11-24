<?php
session_start();
include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        die("Both email and password are required!");
    }

    // FIXED: id is now included
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {

            // FIX: user_id will now exist
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];

            header("Location: ../pages/dashboard.php");
            exit();

        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No account found with that email.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>