<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<div id="header">LocalNet</br>Удаление аккаунта</div>
<?php
session_start();
include 'leftcol.php';
?>
<div id="content">
Удаление аккаунта</br>
<?php
if(!empty($_POST)){
	$host='localhost';
	$user='root';
	$password='';
	$db_name='KT2_2';
	$link=mysqli_connect($host, $user, $password, $db_name);
	mysqli_query($link, "SET NAMES 'utf8'");
	$id=$_SESSION['id'];
	$user="SELECT * FROM users WHERE id='$id'";
	$result=mysqli_query($link, $user);
	$user=mysqli_fetch_assoc($result);
	$hash=$user['pass'];
	if(password_verify($_POST['old_pass'], $hash)) {
		$query="DELETE FROM users WHERE id ='$id'";
		mysqli_query($link,$query);
		$_SESSION['auth']=null;
		echo "Аккаунт удален";
	} else echo "Пароль введен неверно</br>";
}
if(!empty($_SESSION['auth'])) {
?>
<form action="" method="POST">
	<input name="old_pass" type="password" placeholder="Пароль"<?php if(!empty($_POST['old_pass']))
		echo 'value='.$_POST['old_pass']; ?>></br>
	<input type="submit" value="Удалить"></br>
</form>
<?php
} 
?>