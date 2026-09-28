<?php
session_start();
if (!isset($_SESSION['userName'])) {
    header("Location: sellersSignUp.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All I Luxe | Upload Furniture</title>
  <link rel="stylesheet" href="uploadFurniture.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lora&family=Playfair+Display:wght@600;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Navigation -->
  <header class="navbar">
    <a href="index.html" class="logo">All I Luxe</a>
    <nav>
      <ul>
        <li><a href="aboutUsPage.html">About Us</a></li>
        <li><a href="sellToUsPage.html">Sell To Us</a></li>
        <li><a href="contactUs.html">Contact Us</a></li>
        <li><a href="assignmentRegistration.html">Login</a></li>
        <!-- Show logged-in user's name -->
        <li>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?>!</li>
      </ul>
    </nav>

    <ul class="nav-icons right">
      <li><a href="#"><i class="fas fa-search"></i></a></li>
      <li><a href="#"><i class="fas fa-heart"></i><span class="badge">0</span></a></li>
      <li><a href="#"><i class="fas fa-shopping-cart"></i><span class="badge">0</span></a></li>
      <li><a href="#"><i class="fas fa-user"></i></a></li>
    </ul>
  </header>

  <!-- Upload Form -->
  <section class="form-container">
    <h1>Upload Your Furniture</h1>
    <p>Please provide clear photos and details of your luxury furniture.</p>

    <!-- ↓ action now points to PHP handler -->
    <form id="uploadForm" action="saveFurniture.php" method="POST" enctype="multipart/form-data">

      <!-- Photos -->
      <div class="input-box">
        <label for="photos">Upload Photos</label>
        <input type="file" id="photos" name="photos[]" multiple required>
      </div>

      <!-- Item Name -->
      <div class="input-box">
        <label for="itemName">Item Name</label>
        <input type="text" id="itemName" name="itemName" placeholder="e.g. 3-Seater Leather Sofa" required>
      </div>

      <!-- Brand -->
      <div class="input-box">
        <label for="brand">Brand</label>
        <select id="brand" name="brand" required>
          <option value="">Select Brand</option>
          <option value="coricraft">Coricraft</option>
          <option value="waylandts">Waylandts</option>
          <option value="winstonsahd">Winston Sahd</option>
          <option value="other">@Home</option>
        </select>
      </div>

      <!-- Material -->
      <div class="input-box">
        <label for="material">Material</label>
        <input type="text" id="material" name="material" placeholder="e.g. Leather, Wood, Fabric" required>
      </div>

      <!-- Condition -->
      <div class="input-box">
        <label for="condition">Condition</label>
        <select id="condition" name="condition" required>
          <option value="">Select Condition</option>
          <option value="excellent">Excellent</option>
          <option value="good">Good</option>
          <option value="fair">Fair</option>
        </select>
      </div>

      <!-- Description -->
      <div class="input-box">
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Describe your furniture..." required></textarea>
      </div>

      <!-- Price -->
      <div class="input-box">
        <label for="price">Asking Price (R)</label>
        <input type="number" id="price" name="price" placeholder="e.g. 5000" required>
      </div>

      <button type="submit" class="btn">Submit for Evaluation</button>
    </form>
  </section>

</body>
</html>