<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
$users = read_json(__DIR__ . '/../data/users.json');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
foreach ($users as $u) {
    if (strtolower($u['username']) === strtolower($username) && password_verify($password, $u['password_hash'])) {
        $_SESSION['user_id'] = $u['id'];
        json_response(true, ['user' => ['id' => $u['id'], 'name' => $u['name'], 'username' => $u['username']]]);
    }
}
json_response(false, null, 'Invalid credentials', 401);
