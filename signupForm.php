<?php
session_start();

// InfinityFree DB connection (replace with your actual details)
$servername = "sql300.infinityfree.com";
$username   = "if0_41972949";   // e.g. if0_41972949
$password   = "vGYNEN6Kuj";   // from InfinityFree panel
$dbname     = "if0_41972949_accounts";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$fname    = $_POST['firstName'];
$lname    = $_POST['lastName'];
$email    = $_POST['email'];
$age      = $_POST['age'];
$mobile   = $_POST['mobile'];
$password = $_POST['password'];
$confirm  = $_POST['confirmPassword'];
$userType = $_POST['userType']; 

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
    echo "Signup successful! <a href='assignmentRegistration.html'>Login here</a>";
} else {
    echo "Error: " . $conn->error;
}

// Optionally, you can log the user in immediately after signup
if ($conn->query($sql) === TRUE) {
    // Store the first name in session
    $_SESSION['userName'] = $fname;

    // Redirect to homepage
    header("Location: index.html"); 
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
