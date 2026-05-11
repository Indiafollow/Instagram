<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ChatterBox - Login</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="auth-body">
  <div class="auth-card">
    <h1>ChatterBox</h1>
    <form id="loginForm">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Log in</button>
      <p id="loginError" class="error"></p>
    </form>
    <p>No account? <a href="register.php">Sign up</a></p>
  </div>
  <script src="assets/js/auth.js"></script>
</body>
</html>
