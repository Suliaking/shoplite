<?php
session_start();
include '../includes/db.php';

// Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    die("Unauthorized access");
}
$user_id = intval($_SESSION["user_id"]);

// Check if form was submitted
if (isset($_POST["save_changes"])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $profile_pic = null;

    // --- IMAGE UPLOAD HANDLING ---
    if (isset($_FILES['profile_pic']) && !empty($_FILES['profile_pic']['name'])) {

        $uploadDir = "../profile_image_upload/";

        // Generate a unique filename
        $imageExtension = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'jfif'];

        if (in_array($imageExtension, $allowedExt)) {
            $newFilename = time() . "_" . $user_id . "." . $imageExtension;
            $targetFile = $uploadDir . $newFilename;

            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
                $profile_pic = $newFilename;
            } else {
                die("Image upload failed.");
            }
        } else {
            die("Invalid file type. Only JPG, JPEG, PNG, JFIF allowed.");
        }
    }

    // --- UPDATE DATABASE ---
    if ($profile_pic) {
        // Update with picture
        $stmt = $conn->prepare(
            "UPDATE users SET name = ?, email = ?, phone = ?, address = ?, profile_pic = ? WHERE id = ?"
        );
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $profile_pic, $user_id);


    } else {
        // Update without picture
        $stmt = $conn->prepare(
            "UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?"
        );
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: ../pages/profile.php?updated=1");
        exit;
    } else {
        die("Database update failed: " . $stmt->error);
    }
}
?>