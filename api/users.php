<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';
if (!isset($_SESSION['user_id'])) json_response(false, null, 'Unauthorized', 401);
$uid=(int)$_SESSION['user_id'];
$sql="SELECT u.id,u.name,u.username,u.avatar,
(SELECT m.body FROM messages m WHERE (m.sender_id=u.id AND m.receiver_id=?) OR (m.sender_id=? AND m.receiver_id=u.id) ORDER BY m.id DESC LIMIT 1) last_text,
(SELECT m.created_at FROM messages m WHERE (m.sender_id=u.id AND m.receiver_id=?) OR (m.sender_id=? AND m.receiver_id=u.id) ORDER BY m.id DESC LIMIT 1) last_time,
(SELECT COUNT(*) FROM messages m WHERE m.sender_id=u.id AND m.receiver_id=? AND m.seen=0) unread
FROM users u WHERE u.id<>? AND u.status='active' ORDER BY last_time DESC";
$st=db()->prepare($sql);$st->execute([$uid,$uid,$uid,$uid,$uid,$uid]);
json_response(true,$st->fetchAll());
