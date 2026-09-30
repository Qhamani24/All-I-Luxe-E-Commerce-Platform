<?php
session_start();
include 'db.php'; // Include DB connection

// Redirect if not logged in
if (!isset($_SESSION['userName'])) {
    header("Location: sellersSignUp.html");
    exit();
}

if (isset($_POST['upload'])) {
    $target_dir = "uploads/";
    
    // Create uploads folder if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Only allow image files
    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];
    if (!in_array($imageFileType, $allowed)) {
        die("Error: Only image files are allowed.");
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Get seller's ID using their session name
        $name = $_SESSION['userName'];
        $stmt = $conn->prepare("SELECT id FROM sellers WHERE firstName = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $seller = $result->fetch_assoc();
        $seller_id = $seller['id'];

        // Save image path to DB
        $sql = "INSERT INTO images (user_id, image_path) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $seller_id, $target_file);
        $stmt->execute();
        echo "Image uploaded successfully!";
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Images - All I Luxe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?>!</h1>
<h2>Upload Furniture Image</h2>

<form action="uploadImages.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*" required>
    <button type="submit" name="upload">Upload</button>
</form>

<h3>Your Uploaded Images</h3>
<?php
// Display this seller's images
$name = $_SESSION['userName'];
$stmt = $conn->prepare("SELECT id FROM sellers WHERE firstName = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$seller_id = $res['id'];

$stmt2 = $conn->prepare("SELECT image_path FROM images WHERE user_id = ?");
$stmt2->bind_param("i", $seller_id);
$stmt2->execute();
$images = $stmt2->get_result();

while ($row = $images->fetch_assoc()) {
    echo '<img src="' . htmlspecialchars($row['image_path']) . '" width="200"><br>';
}
?>

</body>
</html>