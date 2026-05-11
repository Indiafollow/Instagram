<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
if (!isset($_SESSION['user_id'])) json_response(false, null, 'Unauthorized', 401);

$uid = (int)$_SESSION['user_id'];
$users = read_json(__DIR__ . '/../data/users.json');
$messages = read_json(__DIR__ . '/../data/messages.json');

$map = [];
foreach ($users as $u) {
    if ($u['id'] === $uid) continue;
    $map[$u['id']] = [
        'id' => $u['id'],
        'name' => $u['name'],
        'username' => $u['username'],
        'avatar' => $u['avatar'],
        'last_text' => '',
        'last_time' => null,
        'unread' => 0
    ];
}

foreach ($messages as $m) {
    $peer = null;
    if ($m['from'] === $uid) $peer = $m['to'];
    if ($m['to'] === $uid) $peer = $m['from'];
    if (!$peer || !isset($map[$peer])) continue;

    if ($map[$peer]['last_time'] === null || strtotime($m['time']) > strtotime($map[$peer]['last_time'])) {
        $map[$peer]['last_text'] = $m['text'];
        $map[$peer]['last_time'] = $m['time'];
    }

    if ($m['to'] === $uid && empty($m['seen'])) $map[$peer]['unread']++;
}

$list = array_values($map);
usort($list, function ($a, $b) {
    if ($a['last_time'] === $b['last_time']) return strcmp($a['name'], $b['name']);
    if ($a['last_time'] === null) return 1;
    if ($b['last_time'] === null) return -1;
    return strtotime($b['last_time']) - strtotime($a['last_time']);
});

json_response(true, $list);
