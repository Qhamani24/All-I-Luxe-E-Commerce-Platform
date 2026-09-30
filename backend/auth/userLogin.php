<?php
session_start();

require_once __DIR__ . '/../config/db.php';

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? 'user'; // "user" or "seller"

$sql = "SELECT * FROM sellers WHERE email='$email' AND userType='$role'
        UNION
        SELECT * FROM users WHERE email='$email' AND userType='$role'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['name'] = $row['firstName'];
        $_SESSION['role'] = $row['userType'];

        if ($row['userType'] === "seller") {
            header("Location: ../../sellersdashboard.html");
        } else {
            header("Location: ../../index.html");
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
