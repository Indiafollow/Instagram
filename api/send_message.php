<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/db.php';
if (!isset($_SESSION['user_id'])) json_response(false, null, 'Unauthorized', 401);
$uid=(int)$_SESSION['user_id'];$to=(int)($_POST['to']??0);$text=trim($_POST['text']??'');
if($to<=0||$text==='') json_response(false,null,'Invalid input',422);
$ins=db()->prepare('INSERT INTO messages(sender_id,receiver_id,body,seen) VALUES(?,?,?,0)');
$ins->execute([$uid,$to,mb_substr($text,0,1000)]);
$id=(int)db()->lastInsertId();
$st=db()->prepare('SELECT id,sender_id `from`,receiver_id `to`,body `text`,created_at `time`,seen FROM messages WHERE id=?');$st->execute([$id]);
json_response(true,$st->fetch());
