<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<div id="header">LocalNet</br>Смена пароля</div>
<?php
session_start();
include 'leftcol.php';
?>
<div id="content">
<?php
$pass_len=null;
$pass_rule=null;
$confirm=null;
if(!empty($_POST)){
	$pass=$_POST['new_pass'];
	$conf=$_POST['conf'];
	if($pass!=$conf)
		$confirm="Новые пароли не совпадают </br>";
	if(preg_replace('#\w{6,12}#u','!',$_POST['new_pass'])!='!')
		$pass_len="Ваш пароль не соответсвутет длинне от 6 до 12 символов </br>";
	if(preg_replace('#\w+#','!',$_POST['new_pass'])!='!')
		$pass_rule="Ваш пароль не состоит из латинских букв и цифр </br>";
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
	if(empty($pass_rule) and empty($pass_len) and empty($confirm))
	if(password_verify($_POST['old_pass'], $hash)) {
		$newPassHash=password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
		$query="UPDATE users SET pass='$newPassHash' WHERE id ='$id'";
		mysqli_query($link,$query);
		echo "Пароль успешно сменен!";
	} else echo "Старый пароль введен неверно</br>";
}
?>
<form action="" method="POST">
	<input name="old_pass" type="password" placeholder="Старый пароль"<?php if(!empty($_POST['old_pass']))
		echo 'value='.$_POST['old_pass']; ?>></br>
	<?php echo "$confirm"."$pass_len"."$pass_rule"?>
	<input name="new_pass" type="password" placeholder="Новый пароль"<?php if(!empty($_POST['new_pass']))
		echo 'value='.$_POST['new_pass']; ?>></br>
	<input name="conf" type="password" placeholder="Подтвежд. нового пароля"<?php if(!empty($_POST['conf']))
		echo 'value='.$_POST['conf']; ?>></br>
	<input type="submit" value="Изменить"></br>
</form>
</div id="content">