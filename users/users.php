<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/freq.css">
</head>
<div id="header">LocalNet</br>Пользователи</div>
<?php
session_start();
include 'leftcol.php';
?>
<div id="content">

<?php
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$curUser=$_SESSION['login'];
$freq="SELECT * FROM freq WHERE getter='$curUser' AND friends=0 AND ignor=0";
$result=mysqli_query($link, $freq) or die (mysqli_error($link));
for ($freq=array();$row=mysqli_fetch_assoc($result); $freq[]=$row);
if(!empty($freq)) {
	foreach($freq as $elem) {
		$sender=$elem['sender'];
		$users="SELECT * FROM users WHERE login='$sender'";
		$result=mysqli_query($link, $users);
		$users=mysqli_fetch_assoc($result);
		$ava=$users['ava'];
		$name=$users['name']." ".$users['surname'];
		echo "Запросы в друзья
		<div id=users><img src=avatars/$ava width=50 height=50 class=round>
		<a href=http://localhost/Labs/users/profile.php?login=$sender>$name</a></br>
		<a href=http://localhost/Labs/users/accIgn.php?getter=$curUser&sender=$sender&action=add>Принять запрос</a> |
		<a href=http://localhost/Labs/users/fUnReq.php?getter=$curUser&sender=$sender>Отклонить запрос</a> |
		<a href=http://localhost/Labs/users/accIgn.php?getter=$curUser&sender=$sender&action=ignor>Игнор</a></div>";
		
	}
}
$freq="SELECT * FROM freq WHERE (getter='$curUser' OR sender='$curUser') AND friends=1";
$result=mysqli_query($link, $freq) or die (mysqli_error($link));
for ($freq=array();$row=mysqli_fetch_assoc($result); $freq[]=$row);
if(!empty($freq)) {
	foreach($freq as $elem) {
		if($elem['sender']!=$curUser)
			$friend=$elem['sender'];
		else $friend=$elem['getter'];
		$users="SELECT * FROM users WHERE login='$friend'";
		$result=mysqli_query($link, $users);
		$users=mysqli_fetch_assoc($result);
		$ava=$users['ava'];
		$name=$users['name']." ".$users['surname'];
		$sender=$elem['sender'];
		$getter=$elem['getter'];
		echo "Друзья
		<div id=users><img src=avatars/$ava width=50 height=50 class=round>
		<a href=http://localhost/Labs/users/profile.php?login=$friend>$name</a></br>
		<a href=http://localhost/Labs/users/fUnReq.php?sender=$sender&getter=$getter>Удалить из друзей</a></div>";
		
	}
}
$users="SELECT * FROM users";
$result=mysqli_query($link, $users) or die (mysqli_error($link));
for ($users=array();$row=mysqli_fetch_assoc($result); $users[]=$row);
echo "Все пользователи LocalNet:</br>";
foreach ($users as $user) {
	$ava=$user['ava'];
	$name=$user['name']." ".$user['surname'];
	$login=$user['login'];
	echo "<div id=users><img src=avatars/$ava width=50 height=50 class=round>
		<a href=http://localhost/Labs/users/profile.php?login=$login>$name</a></div></br>";
}
?>
</div>