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

$fname    = $_POST['firstName'];
$lname    = $_POST['lastName'];
$email    = $_POST['email'];
$age      = $_POST['age'];
$mobile   = $_POST['mobile'];
$password = $_POST['password'];
$confirm  = $_POST['confirmPassword'];
$userType = $_POST['userType'];

if ($password !== $confirm) {
    die("Passwords do not match.");
}
if ($age < 18) {
    die("You must be at least 18 years old to sign up.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO sellers (firstName, lastName, email, age, mobile, password, userType) 
        VALUES ('$fname', '$lname', '$email', '$age', '$mobile', '$hashedPassword', '$userType')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['userName'] = $fname;
    header("Location: uploadFurniture.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
