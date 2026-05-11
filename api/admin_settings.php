<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
if (!isset($_SESSION['user_id'])) { header('Location: ../index.php'); exit; }
$users = read_json(__DIR__ . '/../data/users.json');
$me = null; foreach ($users as $u) if ($u['id'] === $_SESSION['user_id']) $me = $u;
if (($me['role'] ?? 'user') !== 'admin') { header('Location: ../home.php'); exit; }
$theme = $_POST['theme'] ?? 'sunset';
$allowed = ['sunset','ocean','forest'];
if (!in_array($theme, $allowed, true)) $theme = 'sunset';
$settings = read_json(__DIR__ . '/../data/settings.json');
$settings['app_name'] = 'socialTeam';
$settings['theme'] = $theme;
write_json(__DIR__ . '/../data/settings.json', $settings);
header('Location: ../admin.php');
