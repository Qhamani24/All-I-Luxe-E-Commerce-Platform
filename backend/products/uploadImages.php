<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Redirect if not logged in
if (!isset($_SESSION['userName'])) {
    header("Location: sellersSignUpPage.php");
    exit();
}

$message = "";

if (isset($_POST['upload'])) {
    $target_dir = "../../assets/images/uploads/";
    
    // Create uploads folder if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Only allow image files
    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];
    if (!in_array($imageFileType, $allowed)) {
        $message = "Error: Only image files are allowed.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Get seller's ID using their session name
            $name = $_SESSION['userName'];
            $stmt = $conn->prepare("SELECT id FROM sellers WHERE firstName = ?");
            if ($stmt) {
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $result = $stmt->get_result();
                $seller = $result->fetch_assoc();
                $seller_id = $seller['id'] ?? 0;

                // Save image path to DB
                $sql = "INSERT INTO images (user_id, image_path) VALUES (?, ?)";
                $stmt2 = $conn->prepare($sql);
                if ($stmt2) {
                    $stmt2->bind_param("is", $seller_id, $target_file);
                    $stmt2->execute();
                }
            }
            $message = "Image uploaded successfully!";
        } else {
            $message = "Error uploading image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Images - All I Luxe</title>
    <link rel="stylesheet" href="../../assets/css/uploadFurniture.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lora&family=Playfair+Display:wght@600;700&display=swap">
</head>
<body>

<header class="navbar">
    <a href="../../index.html" class="logo">All I Luxe</a>
    <nav>
      <ul>
        <li><a href="../../aboutUsPage.html">About Us</a></li>
        <li><a href="../../sellToUsPage.html">Sell To Us</a></li>
        <li><a href="../../sellersdashboard.html">Dashboard</a></li>
      </ul>
    </nav>
</header>

<section class="form-container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?>!</h1>
    <p>Upload Furniture Image</p>

    <?php if ($message): ?>
        <p style="color: #bfa14a; font-weight: bold;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="uploadImages.php" method="POST" enctype="multipart/form-data">
        <div class="input-box">
            <input type="file" name="image" accept="image/*" required>
        </div>
        <button type="submit" name="upload" class="btn">Upload Image</button>
    </form>
</section>

</body>
</html>