<?php

$servername = "localhost";
$username = "sulaimon";
$password = "123456";
$dbname = "shoplite_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}

?>