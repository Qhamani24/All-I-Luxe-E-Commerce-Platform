<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Change these to your own credentials
    $admin_username = "admin";
    $admin_password = "Admin@AllILuxe2024"; // strong password

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login – All I Luxe</title>
  <link rel="stylesheet" href="adminLogin.css">
</head>
<body>
  <div class="login-wrap">
    <div class="login-card">
      <div class="brand">
        <div class="lock-icon">&#128274;</div>
        <h1>All I Luxe</h1>
        <p>Admin access only</p>
      </div>

      <?php if ($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
      <?php endif; ?>

      <form method="POST" action="adminLogin.php">
        <div class="field">
          <label>Username</label>
          <input type="text" name="username" required autofocus>
        </div>
        <div class="field">
          <label>Password</label>
          <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Sign in to admin</button>
      </form>
    </div>
  </div>
</body>
</html>