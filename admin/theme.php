<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/db.php';
$me = db()->prepare('SELECT role FROM users WHERE id=?'); $me->execute([$_SESSION['user_id']]); $me=$me->fetch();
if (($me['role'] ?? 'user') !== 'admin') { header('Location: ../home.php'); exit; }
$theme=$_POST['theme']??'sunset'; if(!in_array($theme,['sunset','ocean','forest'],true)) $theme='sunset';
$st=db()->prepare('UPDATE settings SET theme=? WHERE id=1'); $st->execute([$theme]);
header('Location: index.php');
