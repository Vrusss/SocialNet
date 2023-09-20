<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/freq.css">
</head>
<div id="header">LocalNet</br>Сообщения</div>
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
$msg="SELECT * FROM chatnames WHERE user1='$curUser' OR user2='$curUser'";
$result=mysqli_query($link, $msg) or die (mysqli_error($link));
for ($msg=array();$row=mysqli_fetch_assoc($result); $msg[]=$row);
if(!empty($msg)) {
	echo "Активные переписки";
	foreach($msg as $elem) {
		if($elem['user1']!=$curUser) {
			$sender=$elem['user1'];
		} else $sender=$elem['user2'];
		$users="SELECT * FROM users WHERE login='$sender'";
		$result=mysqli_query($link, $users);
		$users=mysqli_fetch_assoc($result);
		$ava=$users['ava'];
		$name=$users['name']." ".$users['surname'];
		echo "<div id=users><img src=avatars/$ava width=50 height=50 class=round>
		<a href=http://localhost/Labs/users/profile.php?login=$sender>$name</a> |
		<a href=http://localhost/Labs/users/chat.php?name=$elem[name]&getter=$sender&sender=$curUser>Перейти к переписке</a></div>";
		
	}
} else {
	echo "Сообщений пока нет :(</br><a href=http://localhost/Labs/users/users.php>Найти друзей</a>";
}