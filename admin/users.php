<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/db.php';
$me = db()->prepare('SELECT role FROM users WHERE id=?'); $me->execute([$_SESSION['user_id']]); $me=$me->fetch();
if (($me['role'] ?? 'user') !== 'admin') { header('Location: ../home.php'); exit; }
$id=(int)($_POST['user_id']??0);$action=$_POST['action']??'';
if($id>0){
if($action==='promote') db()->prepare("UPDATE users SET role='moderator' WHERE id=?")->execute([$id]);
if($action==='demote') db()->prepare("UPDATE users SET role='user' WHERE id=?")->execute([$id]);
if($action==='suspend') db()->prepare("UPDATE users SET status='suspended' WHERE id=?")->execute([$id]);
if($action==='activate') db()->prepare("UPDATE users SET status='active' WHERE id=?")->execute([$id]);
}
header('Location: index.php');
