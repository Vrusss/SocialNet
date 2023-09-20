<head>
	<link rel="stylesheet" type="text/css" href="css/reg.css">
</head>
<div id="header">LocalNet</br>Вход <a href=http://localhost/Labs/users/registration.php>Регистрация</a></div>
<body>
<?php
session_start();
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
if(!empty($_POST['pass']) and !empty($_POST['login'])) {
	$login=$_POST['login'];
	$pass=$_POST['pass'];
	$query="SELECT *, statuses.status as status FROM users LEFT JOIN statuses ON users.status_id=statuses.id WHERE login='$login'";
	$result=mysqli_query($link, $query);
	$user=mysqli_fetch_assoc($result);
	if(!empty($user)) {
		$hash=$user['pass'];
		if(password_verify($pass,$hash)) {
			if($user['ban']!=1) {
				$_SESSION['auth']=true;
				$_SESSION['login']=$login;
				$_SESSION['id']=$user['id'];
				$_SESSION['status']=$user['status'];
				header("Location: http://localhost/Labs/users/profile.php?login=$login");
			} else echo 'Этот аккаунт забанен!';
		} else {
			echo 'Неверный логин или пароль';
		}
	} else echo 'Неверный логин или пароль';
}
?>
<form action="" method="POST">
	<input name="login" placeholder="Логин"></br>
	<input name="pass" type="password" placeholder="Пароль"></br>
	<input type="submit" value="Войти">
</form>
</body>
