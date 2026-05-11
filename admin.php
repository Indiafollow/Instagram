<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/theme.php';
$users = read_json(__DIR__ . '/data/users.json');
$me = null;
foreach ($users as $u) if ($u['id'] === $_SESSION['user_id']) $me = $u;
if (($me['role'] ?? 'user') !== 'admin') { header('Location: home.php'); exit; }
$settings = get_theme_settings();
$messages = read_json(__DIR__ . '/data/messages.json');
?><!doctype html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin - <?= htmlspecialchars($settings['app_name']) ?></title>
<link rel="stylesheet" href="assets/css/style.css" /><style>:root{<?= theme_css_vars($settings['theme']) ?>}</style></head><body>
<div class="admin-wrap"><h1>Admin Panel</h1><p>Manage <?= htmlspecialchars($settings['app_name']) ?> professionally.</p>
<div class="admin-grid">
<div class="card"><h3>Theme</h3><form method="post" action="api/admin_settings.php"><select name="theme"><option>sunset</option><option>ocean</option><option>forest</option></select><button>Save Theme</button></form></div>
<div class="card"><h3>Stats</h3><p>Users: <?= count($users) ?></p><p>Messages: <?= count($messages) ?></p></div>
<div class="card"><h3>Users</h3><ul><?php foreach($users as $u): ?><li><?= htmlspecialchars($u['username']) ?> (<?= htmlspecialchars($u['role'] ?? 'user') ?>)</li><?php endforeach; ?></ul></div>
</div><a class="logout" href="home.php">Back to chat</a></div>
</body></html>
