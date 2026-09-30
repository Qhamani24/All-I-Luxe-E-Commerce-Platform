<?php
session_start();

require_once __DIR__ . '/../config/db.php';

// Collect form data
$fname    = $_POST['firstName'] ?? '';
$lname    = $_POST['lastName'] ?? '';
$email    = $_POST['email'] ?? '';
$age      = $_POST['age'] ?? 0;
$mobile   = $_POST['mobile'] ?? '';
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirmPassword'] ?? '';
$userType = $_POST['userType'] ?? 'user'; 

// Validate
if ($password !== $confirm) {
    die("Passwords do not match.");
}
if ($age < 18) {
    die("You must be at least 18 years old to sign up.");
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$sql = "INSERT INTO users (firstName, lastName, email, age, mobile, password, userType) 
        VALUES ('$fname', '$lname', '$email', '$age', '$mobile', '$hashedPassword', '$userType')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['userName'] = $fname;
    $_SESSION['role']     = $userType;
    header("Location: ../../index.html"); 
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
