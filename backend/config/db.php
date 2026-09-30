<?php
// This runs on the server before sending HTML to the browser

// Example: connect to your InfinityFree MySQL database
$servername = "sqlXXX.infinityfree.com"; // replace with your DB host
$username   = "if0_41972949";        // from InfinityFree panel
$password   = "vGYNEN6Kuj";        // from InfinityFree panel
$dbname     = "if0_41972949_accounts";            // from InfinityFree panel

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example query (optional)
$result = $conn->query("SELECT 'Hello from PHP!' AS message");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>All I Luxe</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Welcome to All I Luxe</h1>
  <p><?php echo $row['message']; ?></p>
</body>
</html>
