<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
if (!isset($_SESSION['user_id'])) json_response(false, null, 'Unauthorized', 401);
$users = read_json(__DIR__ . '/../data/users.json');
$filtered = array_values(array_filter($users, fn($u) => $u['id'] !== $_SESSION['user_id']));
foreach ($filtered as &$u) unset($u['password_hash']);
json_response(true, $filtered);
