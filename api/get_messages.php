<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
if (!isset($_SESSION['user_id'])) json_response(false, null, 'Unauthorized', 401);
$other = (int)($_GET['other'] ?? 0);
$messages = read_json(__DIR__ . '/../data/messages.json');
$uid = (int)$_SESSION['user_id'];
$chat = array_values(array_filter($messages, fn($m) => ($m['from']===$uid && $m['to']===$other) || ($m['from']===$other && $m['to']===$uid)));
json_response(true, $chat);
