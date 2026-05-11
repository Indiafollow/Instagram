<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
if (!isset($_SESSION['user_id'])) json_response(false, null, 'Unauthorized', 401);
$to = (int)($_POST['to'] ?? 0);
$text = trim($_POST['text'] ?? '');
if ($to <= 0 || $text === '') json_response(false, null, 'Invalid input', 422);
$path = __DIR__ . '/../data/messages.json';
$messages = read_json($path);
$msg = ['id' => next_id($messages), 'from' => (int)$_SESSION['user_id'], 'to' => $to, 'text' => $text, 'time' => gmdate('c')];
$messages[] = $msg;
write_json($path, $messages);
json_response(true, $msg);
