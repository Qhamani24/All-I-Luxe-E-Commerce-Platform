<?php
// ========================================================
// Database Configuration Template
// Copy this file to db.php and update with your local or production database credentials.
// ========================================================

$servername = "localhost";        // or sqlXXX.infinityfree.com
$username   = "root";             // your MySQL username
$password   = "";                 // your MySQL password
$dbname     = "all_i_luxe_db";    // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
