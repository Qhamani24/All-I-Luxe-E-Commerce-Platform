<?php
// ========================================================
// All I Luxe - Centralized Database Connection Configuration
// ========================================================

// Database server credentials (supports environment variables with InfinityFree defaults)
$servername = getenv('DB_HOST') ?: "sql300.infinityfree.com";
$username   = getenv('DB_USER') ?: "if0_41972949";
$password   = getenv('DB_PASS') ?: "vGYNEN6Kuj";
$dbname     = getenv('DB_NAME') ?: "if0_41972949_accounts";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
