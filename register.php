<?php
session_start();
require_once __DIR__ . '/includes/theme.php';
$settings = get_theme_settings();
if (isset($_SESSION['user_id'])) { header('Location: home.php'); exit; }
?>
<!doctype html><html lang="en"><head>
<meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= htmlspecialchars($settings['app_name']) ?> - Register</title>
<link rel="stylesheet" href="assets/css/style.css" />
<style>:root{<?= theme_css_vars($settings['theme']) ?>}</style>
</head><body class="auth-body"><div class="auth-card">
<h1>Create Account</h1><form id="registerForm"><input type="text" name="name" placeholder="Full name" required />
<input type="text" name="username" placeholder="Username" required /><input type="password" name="password" placeholder="Password" required minlength="6" />
<button type="submit">Sign up</button><p id="registerError" class="error"></p></form><p>Have an account? <a href="index.php">Log in</a></p>
</div><script src="assets/js/auth.js"></script></body></html>
