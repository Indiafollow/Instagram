<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
if (!isset($_SESSION['user_id'])) json_response(false, null, 'Unauthorized', 401);
$other = (int)($_GET['other'] ?? 0);
if ($other <= 0) json_response(false, null, 'Invalid user', 422);

$uid = (int)$_SESSION['user_id'];
$path = __DIR__ . '/../data/messages.json';
$messages = read_json($path);
$chat = [];
$changed = false;

foreach ($messages as &$m) {
    $isChat = ($m['from'] === $uid && $m['to'] === $other) || ($m['from'] === $other && $m['to'] === $uid);
    if (!$isChat) continue;
    if (!isset($m['seen'])) $m['seen'] = false;
    if ($m['to'] === $uid && $m['from'] === $other && !$m['seen']) {
        $m['seen'] = true;
        $changed = true;
    }
    $chat[] = $m;
}
unset($m);

if ($changed) write_json($path, $messages);
json_response(true, $chat);
