<?php
session_start();
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$id=$_GET['id'];
$query="DELETE FROM users WHERE id='$id'";
mysqli_query($link, $query);
header("Location: http://localhost/Labs/users/foradmins.php");
die();
?>