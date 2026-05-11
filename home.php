<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
$users = read_json(__DIR__ . '/data/users.json');
$me = null;
foreach ($users as $u) { if ($u['id'] === $_SESSION['user_id']) $me = $u; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Instagram Chat</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
<header class="topbar">
  <h2>Instagram Chat</h2>
  <div><?= htmlspecialchars($me['username']) ?> · <a href="logout.php">Logout</a></div>
</header>
<main class="chat-layout">
  <aside>
    <h3>Users</h3>
    <ul id="usersList"></ul>
  </aside>
  <section>
    <div id="chatHeader">Select a user</div>
    <div id="messages"></div>
    <form id="sendForm" class="send-form">
      <input id="messageInput" required placeholder="Message..." />
      <button>Send</button>
    </form>
  </section>
</main>
<script>window.ME_ID = <?= (int)$_SESSION['user_id'] ?>;</script>
<script src="assets/js/chat.js"></script>
</body>
</html>
