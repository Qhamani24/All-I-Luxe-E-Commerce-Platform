<?php
session_start();

$servername = "sql300.infinityfree.com";
$username   = "if0_41972949";
$password   = "vGYNEN6Kuj";
$dbname     = "if0_41972949_accounts";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email    = $_POST['email'];
$password = $_POST['password'];

// Check if seller exists
$sql = "SELECT * FROM sellers WHERE email='$email'";
$result = $conn->query($sql);

// Verify password and log in
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['seller'] = $row['firstName'];
        header("Location: uploadFurniture.html"); // redirect after login
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No seller account found with that email.";
}

$conn->close();
?>
