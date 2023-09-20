<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<div id="header">LocalNet</br>Редактировать личные данные</div>
<?php
session_start();
include 'leftcol.php';
?>
<div id="content">
Данные профиля:</br>
<?php
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$user="SELECT *, avatars.ava as avatar FROM users LEFT JOIN statuses ON users.status_id=statuses.id 
LEFT JOIN avatars ON users.ava_id=avatars.id WHERE login='$login'";;