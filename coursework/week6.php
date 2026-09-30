<?php
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
   
    $fname = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $fpassword = $_POST['password'] ?? $_POST['fpassword'] ?? '';
 
    echo "<table>
    <tr>
    <th>Username</th>
    <td>$fname</td>
    </tr>
 
    <tr>
    <th>Email</th>
    <td>$email</td>
    </tr>

    <tr>
    <th>Password</th>
    <td>$fpassword</td>
    </tr>
    </table>";
   
 
} else {
   
    echo "<h2>Error: No data received.</h2>";
 
    echo '<a href="week6Form.html">Return to Form</a>';
}

  // Database connection parameters
$servername = "localhost";
$username = "root";   // default for XAMPP
$password = "";       // default is empty
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fname = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$fpassword = $_POST['password'] ?? $_POST['fpassword'] ?? '';
$sql = "INSERT INTO users (name, email, password) VALUES ('$fname', '$email', '$fpassword')";

// Execute the query and check for successful insertion
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
//close the database connection
$conn->close();


?>