<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';

$name = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
if ($name === '' || $username === '' || strlen($password) < 6) json_response(false, null, 'Invalid input', 422);

$pdo = db();
$exists = $pdo->prepare('SELECT id FROM users WHERE username=?');
$exists->execute([$username]);
if ($exists->fetch()) json_response(false, null, 'Username already exists', 409);
$count = (int)$pdo->query('SELECT COUNT(*) c FROM users')->fetch()['c'];
$role = $count === 0 ? 'admin' : 'user';
$avatar = 'https://ui-avatars.com/api/?name=' . urlencode($name);
$ins = $pdo->prepare('INSERT INTO users(name, username, password_hash, avatar, role) VALUES(?,?,?,?,?)');
$ins->execute([$name, $username, password_hash($password, PASSWORD_DEFAULT), $avatar, $role]);
$id = (int)$pdo->lastInsertId();
$_SESSION['user_id'] = $id;
json_response(true, ['user' => ['id' => $id, 'name' => $name, 'username' => $username, 'role' => $role]]);
