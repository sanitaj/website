<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Page</title>
  <link rel="stylesheet" href="../css/login_style.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <form action="log.php" method="post">
      <h1>Login</h1>

      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required />
        <i class='bx bxs-user'></i>
      </div>

      <div class="input-box">
        <input type="password" name="password" id="password" placeholder="Password" required />
        <i class='bx bxs-lock-alt'></i>
        <i class='bx bx-show' id="togglePassword"></i>
      </div>

      <div class="remember-forgot">
        <label><input type="checkbox" name="remember" />Remember me</label>
        <a href="forgot_pass.php">Forgot password?</a>
      </div>

      <button type="submit" class="btn">Login</button>

      <div class="register-link">
        <p>Don't have an account? <a href="reg.php">Register</a></p>
      </div>

      <div class="register-link">
        <p><a href="index.php">Return to menu</a></p>
      </div>
    </form>
  </div>
  <script src="../js/script.js"></script>
</body>
</html>
