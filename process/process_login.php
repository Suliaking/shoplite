<?php
session_start();
include("../includes/db.php"); // adjust the path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and clean user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate required fields
    if (empty($email) || empty($password)) {
        die("Both email and password are required!");
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            // Store session data
            $_SESSION['name'] = $user['name'];
            header("Location: ../pages/dashboard.php"); // redirect after successful login
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
