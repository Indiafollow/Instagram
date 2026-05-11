<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';
if (!isset($_SESSION['user_id'])) json_response(false, null, 'Unauthorized', 401);
$uid=(int)$_SESSION['user_id'];$other=(int)($_GET['other']??0);if($other<=0) json_response(false,null,'Invalid user',422);
$upd=db()->prepare('UPDATE messages SET seen=1 WHERE sender_id=? AND receiver_id=? AND seen=0');$upd->execute([$other,$uid]);
$st=db()->prepare('SELECT id,sender_id `from`,receiver_id `to`,body `text`,created_at `time`,seen FROM messages WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?) ORDER BY id ASC');
$st->execute([$uid,$other,$other,$uid]);
json_response(true,$st->fetchAll());
