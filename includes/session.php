<?php
session_start();

// Check if the name is set in the session
if (isset($_SESSION['name'])) {
    include "db.php";
    $name = $conn->real_escape_string($_SESSION['name']); // Prevent SQL injection
    $uploadDir = "profile_image_upload/";
    $extensions = ['jpg', 'jpeg', 'png', 'jfif'];
    $profilePic = "default.jpg"; // Default profile picture

    // Check which image file exists for the user

    foreach ($extensions as $ext) {
        $filePath = $uploadDir . $name . "." . $ext;
        if (file_exists($filePath)) {
            $profilePic = $filePath;
            break;
        }
    }

    // Select only the needed details from the database
    $sql_query = "SELECT email, name, password, created_at, phone, address, image, profile_pic, account_number, wallet_balance  FROM users WHERE name = '$name'";
    $result = $conn->query($sql_query);

    if ($result && $result->num_rows === 1) {
        $userDetails = $result->fetch_assoc();
        $email = $userDetails["email"];
        $name = $userDetails["name"];
        $account_number = $userDetails["account_number"];
        $wallet_balance = $userDetails["wallet_balance"];
        $password = $userDetails["password"];
        $created_at = date("F j, Y, g:i a", strtotime($userDetails["created_at"]));
        $phone = $userDetails["phone"];
        $address = $userDetails["address"];
        $image = $userDetails["image"];
        $profile_pic = $userDetails["profile_pic"];
    } else {
        echo "User not found!";
    }
} else {
    echo "Session user not set!";
}
?>