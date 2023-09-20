<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<div id="header">LocalNet</br>Профиль</div>
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
$login=$_GET['login'];
$user="SELECT *, statuses.status as status FROM users LEFT JOIN statuses ON users.status_id=statuses.id WHERE login='$login'";
$result=mysqli_query($link, $user);
$user=mysqli_fetch_assoc($result);
$login=$user['login'];
$status=$user['status'];
$name=$user['name'];
$surname=$user['surname'];
$patro=$user['patro'];
$age=time() - strtotime($user['bDay']);
$age=round($age/(60*60*24*365));
$reg_time=$user['reg_time'];
$country=$user['country'];
$photo=$user['ava'];
echo "<div id=photo><img src=avatars/$photo width=200 height=230>";

if($_SESSION['login']==$user['login']) {
	echo "<a href=http://localhost/Labs/users/personalArea.php>Изменить аватарку</a>";
?>
</div>
<?php
} else{
	$_SESSION['getter']=$login;
	echo "</br><div id=msg><a href=http://localhost/Labs/users/chatCreate.php>Написать сообщение</a></div>";
	$sender=$_SESSION['login'];
	$getter=$user['login'];
	$request="SELECT * FROM freq WHERE sender='$sender' AND getter='$getter'";
	$result=mysqli_query($link, $request);
	$request=mysqli_fetch_assoc($result);
	$request2="SELECT * FROM freq WHERE sender='$getter' AND getter='$sender'";
	$result=mysqli_query($link, $request2) or die(mysqli_error($link));
	$request2=mysqli_fetch_assoc($result);
	if(empty($request2)) {
		if(!empty($request)) {
			if($request['friends']==1) {
				echo "<p><a href=http://localhost/Labs/users/fUnReq.php?sender=$sender&getter=$getter>Удалить из друзей</a></p></div>";
			} else {
				echo "<p><a href=http://localhost/Labs/users/fUnReq.php?sender=$sender&getter=$getter>Отменить запрос</a></p></div>";
			}
		} else {
			echo "<p><a href=http://localhost/Labs/users/fReqwest.php?sender=$sender&getter=$getter>Добавить в друзья</a></p></div>";
			}
	} elseif($request2['friends']==1) { 
			echo "<p><a href=http://localhost/Labs/users/fUnReq.php?getter=$sender&sender=$getter>Удалить из друзей</a></p></div>";
	} elseif($request2['ignor']==1) {
			echo "<p>(В игноре)</br><a href=http://localhost/Labs/users/fUnReq.php?getter=$sender&sender=$getter>Отклонить запрос</a></p>
			<p><a href=http://localhost/Labs/users/accIgn.php?getter=$sender&sender=$getter&action=add>Принять запрос</a></p></div>";
	} else {
			echo "<p><a href=http://localhost/Labs/users/accIgn.php?getter=$sender&sender=$getter&action=add>Принять запрос</a></p>
			<p><a href=http://localhost/Labs/users/fUnReq.php?getter=$sender&sender=$getter>Отклонить запрос</a></p>
			<p><a href=http://localhost/Labs/users/accIgn.php?getter=$sender&sender=$getter&action=ignor>Игнор</a></p></div>";
	}
}

echo "Статус: $status</br>Логин: $login</br>ФИО: $surname $name $patro</br>Возраст: $age</br>
Страна: $country</br>Дата регистрации: $reg_time</br>";

if($_SESSION['login']==$user['login']) {
?>
<a href=http://localhost/Labs/users/personalArea.php>Редактировать персональные данные</a></br>
<a href=http://localhost/Labs/users/changePass.php>Изменить пароль</a></br>
<a href=http://localhost/Labs/users/delete.php>Удалить аккаунт</a></br>
<?php
}
?>
</div id="content">
