<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
$usersPath = __DIR__ . '/../data/users.json';
$users = read_json($usersPath);
$name = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
if ($name === '' || $username === '' || strlen($password) < 6) json_response(false, null, 'Invalid input', 422);
foreach ($users as $u) {
    if (strtolower($u['username']) === strtolower($username)) json_response(false, null, 'Username already exists', 409);
}
$user = [
    'id' => next_id($users),
    'name' => $name,
    'username' => $username,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($name)
];
$users[] = $user;
write_json($usersPath, $users);
$_SESSION['user_id'] = $user['id'];
json_response(true, ['user' => ['id' => $user['id'], 'name' => $user['name'], 'username' => $user['username']]]);
