<?php
session_start();

$servername = "sql300.infinityfree.com";
$username   = "if0_41972949 ";
$password   = "vGYNEN6Kuj";
$dbname     = "if0_41972949_accounts";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email    = $_POST['email'];
$password = $_POST['password'];
$role     = $_POST['role']; // "user" or "seller"

// Check if user exists in either table
if ($role === "user") {
    // Check user table
} elseif ($role === "seller") {
    // Check seller table
}

$sql = "SELECT * FROM sellers WHERE email='$email' AND userType='$role'
        UNION
        SELECT * FROM users WHERE email='$email' AND userType='$role'";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['name'] = $row['firstName'];
        $_SESSION['role'] = $row['userType'];

        if ($row['userType'] === "seller") {
            header("Location: uploadFurniture.html");
        } else {
            header("Location: index.html");
        }
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No account found.";
}

$conn->close();
?>
