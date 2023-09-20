<?php
session_start();
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$sender=$_GET['sender'];
$getter=$_GET['getter'];
$query="DELETE FROM freq WHERE sender='$sender' AND getter='$getter'";
mysqli_query($link,$query);
header("Location: {$_SERVER['HTTP_REFERER']}");
die();
?>