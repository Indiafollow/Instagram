<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/theme.php';
$me = db()->prepare('SELECT * FROM users WHERE id=?'); $me->execute([$_SESSION['user_id']]); $me=$me->fetch();
if (($me['role'] ?? 'user') !== 'admin') { header('Location: ../home.php'); exit; }
$settings=get_theme_settings();
$users=db()->query('SELECT id,name,username,role,status,created_at FROM users ORDER BY id DESC')->fetchAll();
$messages=(int)db()->query('SELECT COUNT(*) c FROM messages')->fetch()['c'];
$recent=db()->query("SELECT m.id,m.body,m.created_at,s.username sender,r.username receiver FROM messages m JOIN users s ON s.id=m.sender_id JOIN users r ON r.id=m.receiver_id ORDER BY m.id DESC LIMIT 50")->fetchAll();
?><!doctype html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin - socialTeam</title><link rel="stylesheet" href="../assets/css/style.css"><style>:root{<?=theme_css_vars($settings['theme'])?>}</style></head><body>
<header class="topbar"><div class="left"><h2>Admin Dashboard</h2></div><div class="right"><a class="mini-btn" href="../home.php">User Panel</a><a class="mini-btn danger" href="../logout.php">Logout</a></div></header>
<div class="admin-wrap"><div class="admin-grid">
<div class="card"><h3>Theme Control</h3><form method="post" action="theme.php"><select name="theme"><option>sunset</option><option>ocean</option><option>forest</option></select><button>Save Theme</button></form></div>
<div class="card"><h3>Platform Stats</h3><p>Total users: <?=count($users)?></p><p>Total messages: <?=$messages?></p></div>
<div class="card"><h3>User Controls</h3><form method="post" action="users.php"><input name="user_id" placeholder="User ID" required><select name="action"><option value="promote">Promote to moderator</option><option value="demote">Demote to user</option><option value="suspend">Suspend</option><option value="activate">Activate</option></select><button>Apply</button></form></div>
</div>
<div class="card"><h3>Users</h3><ul><?php foreach($users as $u):?><li>#<?=$u['id']?> <?=htmlspecialchars($u['username'])?> | <?=$u['role']?> | <?=$u['status']?></li><?php endforeach;?></ul></div>
<div class="card"><h3>Recent Messages (Who sent what to whom)</h3><div class="table-wrap"><table><thead><tr><th>ID</th><th>From</th><th>To</th><th>Message</th><th>Time</th></tr></thead><tbody><?php foreach($recent as $m):?><tr><td><?=$m['id']?></td><td><?=htmlspecialchars($m['sender'])?></td><td><?=htmlspecialchars($m['receiver'])?></td><td><?=htmlspecialchars($m['body'])?></td><td><?=$m['created_at']?></td></tr><?php endforeach;?></tbody></table></div></div>
</div>
<footer class="app-footer">App developed by <strong>Luv</strong> &amp; <strong>Manveer</strong></footer>
</body></html>
