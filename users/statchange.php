<?php
session_start();
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$id=$_GET['id'];
$status=$_SESSION['status'];
$query="UPDATE users SET status_id='$status' WHERE id='$id'";
mysqli_query($link, $query);
if($_SESSION['id']==$id)
	$_SESSION['status_id']=$status;
header("Location: http://localhost/Labs/users/foradmins.php");
?>