<?php
session_start();
include 'db.php'; // Include DB connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All I Luxe | Seller Signup</title>
  <link rel="stylesheet" href="signupPage.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lora&family=Playfair+Display:wght@600;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Navigation -->
  <header class="navbar">
    <a href="index.php" class="logo">All I Luxe</a>
    <nav>
      <ul>
        <li><a href="aboutUsPage.html">About Us</a></li>
        <li><a href="sellToUsPage.html">Sell To Us</a></li>
        <li><a href="contactUs.html">Contact Us</a></li>
        <li><a href="assignmentRegistration.html">Login</a></li>
        <li><a href="sellersSignUp.php">Signup</a></li>
      </ul>
    </nav>

    <!-- Right: Icons -->
    <ul class="nav-icons right">
      <li><a href="#"><i class="fas fa-search"></i></a></li>
      <li><a href="#"><i class="fas fa-heart"></i><span class="badge">0</span></a></li>
      <li><a href="#"><i class="fas fa-shopping-cart"></i><span class="badge">0</span></a></li>
      <li>
        <?php if(isset($_SESSION['userName'])): ?>
          <a href="#"><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['userName']); ?></a>
        <?php else: ?>
          <a href="assignmentRegistration.html"><i class="fas fa-user"></i></a>
        <?php endif; ?>
      </li>
    </ul>
  </header>

  <!-- Registration Form -->
  <section class="form-container">
    <h1>Start Selling Furniture</h1>
    <form id="sellerSignupForm" action="signupSeller.php" method="post">
      
      <div class="input-box">
        <span class="icon"><i class="fas fa-user"></i></span>
        <input type="text" name="firstName" placeholder="Enter First Name" required>
      </div>

      <div class="input-box">
        <span class="icon"><i class="fas fa-user"></i></span>
        <input type="text" name="lastName" placeholder="Enter Last Name" required>
        <input type="hidden" name="userType" value="seller">
      </div>  

      <div class="input-box">
        <span class="icon"><i class="fas fa-envelope"></i></span>
        <input type="email" name="email" placeholder="Enter Email" required>
      </div>

      <div class="input-box">
        <span class="icon"><i class="fas fa-calendar"></i></span>
        <input type="number" name="age" placeholder="Enter Age" min="18" required>
      </div>

      <div class="input-box">
        <label for="mobile">Mobile Number</label>
        <div class="phone-input">
          <span class="country-code">+27 (ZA)</span>
          <input type="tel" name="mobile" placeholder="0821234567" pattern="[0-9]{10}" maxlength="10" required>
        </div>
      </div>

      <div class="input-box">
        <span class="icon"><i class="fas fa-lock"></i></span>
        <input type="password" name="password" placeholder="Enter Password" required>
      </div>

      <div class="input-box">
        <span class="icon"><i class="fas fa-lock"></i></span>
        <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
      </div>

      <button type="submit" class="btn">Sign Up</button>
      <p>Already have an account? <a href="assignmentRegistration.html">Login</a></p>
    </form>
  </section>

</body>
</html>
