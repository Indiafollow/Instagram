<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/theme.php';
$settings = get_theme_settings();
$st=db()->prepare('SELECT id,name,username,avatar,role FROM users WHERE id=?');$st->execute([$_SESSION['user_id']]);$me=$st->fetch();
?>
<!doctype html><html lang="en"><head>
<meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= htmlspecialchars($settings['app_name']) ?> Messages</title>
<link rel="stylesheet" href="assets/css/style.css" />
<style>:root{<?= theme_css_vars($settings['theme']) ?>}</style>
</head><body>
<header class="topbar">
  <div class="left"><button class="icon-btn">☰</button><h2><?= htmlspecialchars($me['username']) ?></h2></div>
  <div class="right">
    <?php if (($me['role'] ?? 'user') === 'admin'): ?><a class="mini-btn" href="admin/index.php">Admin</a><?php endif; ?>
    <a class="mini-btn danger" href="logout.php">Logout</a>
  </div>
</header>

<div class="mobile-app clean-top">
  <section class="inbox-panel" id="inboxPanel">
    <div class="search-box"><input id="searchUsers" placeholder="Search chats" /></div>
    <div class="chips"><button class="chip active">Primary</button><button class="chip">Requests</button><button class="chip">General</button></div>
    <ul id="usersList" class="thread-list"></ul>
  </section>

  <section class="chat-panel" id="chatPanel">
    <header class="chat-top" id="chatHeader">Select a conversation</header>
    <div id="messages" class="messages"></div>
    <form id="sendForm" class="composer">
      <button type="button" class="icon-btn">📷</button>
      <input id="messageInput" maxlength="1000" placeholder="Message..." required />
      <button type="submit" class="send-btn">Send</button>
    </form>
  </section>
</div>

<footer class="app-footer">App developed by <strong>Luv</strong> &amp; <strong>Manveer</strong></footer>
<script>window.ME_ID = <?= (int)$_SESSION['user_id'] ?>;</script>
<script src="assets/js/chat.js"></script>
</body></html>
