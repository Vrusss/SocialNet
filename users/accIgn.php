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
$action=$_GET['action'];
if($action=='ignor') {
	$query="UPDATE freq SET ignor=1 WHERE sender='$sender' AND getter='$getter'";
	mysqli_query($link,$query);
} else {
	$query="UPDATE freq SET ignor=0, friends=1 WHERE sender='$sender' AND getter='$getter'";
	mysqli_query($link,$query);
}
header("Location: {$_SERVER['HTTP_REFERER']}");
die();
?>