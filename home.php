<?php
require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/functions.php';
$users = read_json(__DIR__ . '/data/users.json');
$me = null;
foreach ($users as $u) {
    if ($u['id'] === $_SESSION['user_id']) {
        $me = $u;
        break;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Instagram Messages</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <div class="app-shell">
    <aside class="sidebar">
      <div class="brand">Instagram</div>
      <div class="me-row">
        <img class="avatar" src="<?= htmlspecialchars($me['avatar']) ?>" alt="avatar" />
        <div>
          <strong><?= htmlspecialchars($me['name']) ?></strong>
          <small>@<?= htmlspecialchars($me['username']) ?></small>
        </div>
      </div>
      <div class="search-wrap"><input id="searchUsers" placeholder="Search messages" /></div>
      <ul id="usersList" class="users"></ul>
      <a class="logout" href="logout.php">Log out</a>
    </aside>

    <main class="chat-pane">
      <header class="chat-header" id="chatHeader">Select a conversation</header>
      <section id="messages" class="messages"></section>
      <form id="sendForm" class="composer">
        <input id="messageInput" maxlength="1000" placeholder="Message..." required />
        <button type="submit">Send</button>
      </form>
    </main>
  </div>
  <script>window.ME_ID = <?= (int)$_SESSION['user_id'] ?>;</script>
  <script src="assets/js/chat.js"></script>
</body>
</html>
