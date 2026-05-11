<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$st = db()->prepare('SELECT * FROM users WHERE username=? AND status="active" LIMIT 1');
$st->execute([$username]);
$u = $st->fetch();
if ($u && password_verify($password, $u['password_hash'])) {
    $_SESSION['user_id'] = (int)$u['id'];
    json_response(true, ['user' => ['id' => (int)$u['id'], 'name' => $u['name'], 'username' => $u['username'], 'role' => $u['role']]]);
}
json_response(false, null, 'Invalid credentials', 401);
