<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/theme.php';
$settings = get_theme_settings();
$st=db()->prepare('SELECT id,name,username,avatar,role FROM users WHERE id=?');$st->execute([$_SESSION['user_id']]);$me=$st->fetch();
?>
<!doctype html><html lang="en"><head><meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= htmlspecialchars($settings['app_name']) ?> Messages</title><link rel="stylesheet" href="assets/css/style.css" /><style>:root{<?= theme_css_vars($settings['theme']) ?>}</style></head><body>
<div class="app-shell"><aside class="sidebar"><div class="brand"><?= htmlspecialchars($settings['app_name']) ?></div>
<div class="me-row"><img class="avatar" src="<?= htmlspecialchars($me['avatar']) ?>" alt="avatar" /><div><strong><?= htmlspecialchars($me['name']) ?></strong><small>@<?= htmlspecialchars($me['username']) ?></small></div></div>
<div class="search-wrap"><input id="searchUsers" placeholder="Search messages" /></div><ul id="usersList" class="users"></ul>
<?php if (($me['role'] ?? 'user') === 'admin'): ?><a class="logout" href="admin/index.php">Admin Panel</a><?php endif; ?><a class="logout" href="logout.php">Log out</a></aside>
<main class="chat-pane"><header class="chat-header" id="chatHeader">Select a conversation</header><section id="messages" class="messages"></section>
<form id="sendForm" class="composer"><input id="messageInput" maxlength="1000" placeholder="Message..." required /><button type="submit">Send</button></form></main></div>
<script>window.ME_ID = <?= (int)$_SESSION['user_id'] ?>;</script><script src="assets/js/chat.js"></script></body></html>
