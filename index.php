<?php
session_start();
require_once __DIR__ . '/includes/theme.php';
$settings = get_theme_settings();
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}
?>
<!doctype html><html lang="en"><head>
<meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= htmlspecialchars($settings['app_name']) ?> - Login</title>
<link rel="stylesheet" href="assets/css/style.css" />
<style>:root{<?= theme_css_vars($settings['theme']) ?>}</style>
</head><body class="auth-body">
<div class="auth-card"><h1><?= htmlspecialchars($settings['app_name']) ?></h1>
<form id="loginForm"><input type="text" name="username" placeholder="Username" required /><input type="password" name="password" placeholder="Password" required /><button type="submit">Log in</button><p id="loginError" class="error"></p></form>
<p>No account? <a href="register.php">Sign up</a></p></div>
<script src="assets/js/auth.js"></script></body></html>
