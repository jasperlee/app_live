<?php
header("Content-Type: text/html;charset=utf-8");

ini_set("display_errors", "On");
error_reporting(E_ALL|E_STRICT);

$user = $_GET['user'];

if ($user == 'student') {
	require_once 'room.php';
}
elseif ($user == 'teacher') {
	require_once 'manage.php';
}
else {
	$url   = 'http://';
	$url  .= $_SERVER['HTTP_HOST'];
	$url  .= $_SERVER['PHP_SELF'].'?';
	$url  .= 'user=[teacher|student]';
	exit('参数错误; '.'参数格式为'.$url);
}