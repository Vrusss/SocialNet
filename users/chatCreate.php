<?php
session_start();
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$sender=$_SESSION['login'];
$getter=$_SESSION['getter'];
$chatName="SELECT name FROM chatnames WHERE (user1='$getter' OR user2='$getter') AND (user1='$sender' OR user2='$sender')";
$result=mysqli_query($link, $chatName);
$chatName=mysqli_fetch_assoc($result);
if(empty($chatName)){
	$name=$sender."_".$getter;
	$query="INSERT INTO chatnames (user1, user2, name) VALUES ('$sender','$getter', '$name')";
	mysqli_query($link,$query);
	$query="CREATE TABLE $name(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		user VARCHAR(100) NOT NULL,
		time INT NOT NULL,
		msg VARCHAR(255) NOT NULL
	)";
	mysqli_query($link, $query);
	
} else {
	$name=$chatName['name'];
}
header("Location: http://localhost/Labs/users/chat.php?name=$name&getter=$getter&sender=$sender");
die();
?>