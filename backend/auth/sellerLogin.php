<?php
session_start();

require_once __DIR__ . '/../config/db.php';

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Check if seller exists
$sql = "SELECT * FROM sellers WHERE email='$email'";
$result = $conn->query($sql);

// Verify password and log in
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['seller'] = $row['firstName'];
        header("Location: ../../sellersdashboard.html"); // redirect after login
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No seller account found with that email.";
}

$conn->close();
?>
