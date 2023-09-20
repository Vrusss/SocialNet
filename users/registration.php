<head>
	<link rel="stylesheet" type="text/css" href="css/reg.css">
</head>
<body>
<div id="header">LocalNet</br>Регистрация <a href=http://localhost/Labs/users/login.php>Вход</a></div>
<?php
session_start();
if (isset($_GET['logout']))
	$_SESSION['auth']=null;
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$pass_len=null;
$pass_rule=null;
$login_len=null;
$login_rule=null;
$email_rule=null;
$bday_rule=null;
$confirm=null;
if(!empty($_POST['pass']) and !empty($_POST['login']) and !empty($_POST['confirm']) and !empty($_POST['bday']) 
	and !empty($_POST['email']) and !empty($_POST['country'])) {
	$name=$_POST['name'];
	$surname=$_POST['surname'];
	$patro=$_POST['patro'];
	$login=$_POST['login'];
	$conf=$_POST['confirm'];
	$pass=$_POST['pass'];
	$bDay=$_POST['bday'];
	$email=$_POST['email'];
	$country=$_POST['country'];
	if($pass!=$conf)
		$confirm="Пароли не совпадают </br>";
	if(preg_replace('#\w{6,12}#u','!',$pass)!='!')
		$pass_len="Ваш пароль не соответсвутет длинне от 6 до 12 символов </br>";
	if(preg_replace('#\w+#','!',$pass)!='!')
		$pass_rule="Ваш пароль не состоит из латинских букв и цифр </br>";
	if(preg_replace('#\w{4,10}#u','!',$login)!='!')
		$login_len="Ваш логин не соответсвутет длинне от 4 до 10 символов </br>";
	if(preg_replace('#\w+#','!',$login)!='!')
		$login_rule="Ваш логин не состоит из латинских букв или цифр </br>";
	if(preg_replace('#\w+@[a-z]+\.[a-z]{2,3}#','!',$email)!='!')
		$email_rule="Ваш email некорректен </br>";
	if(preg_replace('#\d{2}\.\d{2}\.\d{4}#','!',$bDay)!='!')
		$bday_rule="Дата рождения указана в неправильном формате </br>";
	if(empty($pass_len) and empty($pass_rule) and empty($login_len) and empty($login_rule) 
		and empty($email_rule) and empty($bday_rule) and empty($confirm)) {
		$user="SELECT * FROM users WHERE login='$login'";
		$result=mysqli_query($link, $user);
		$user=mysqli_fetch_assoc($result);
		if(empty($user)) {
			$pass=password_hash($pass, PASSWORD_DEFAULT);
			$reg_time=date('d.m.Y',time());
			$query="INSERT INTO users (name, surname, patro, login, pass, bDay, email, reg_time, country, status_id, ava) VALUES 
			('$name', '$surname', '$patro','$login', '$pass', '$bDay', '$email', '$reg_time', '$country', 1, 'stock.jpg')";
			mysqli_query($link, $query);
			$_SESSION['auth']=true;
			$id=mysqli_insert_id($link);
			$_SESSION['id']=$id;
			$_SESSION['login']=$login;
			$_SESSION['status']='user';
		} else {
			echo 'Логин занят';
		}
	}

}
if(!empty($_SESSION['auth'])) {
header("Location: http://localhost/Labs/users/profile?login=$login.php");
die();
}
else {
?>
<div>
<form action="" method="POST">
	<?php
	echo $login_len;
	echo $login_rule;
	?>
	<input name="name" placeholder="Имя" <?php if(!empty($_POST['name']))
		echo 'value='.$_POST['name']; ?>></br>
	<input name="surname" placeholder="Фамилия" <?php if(!empty($_POST['surname']))
		echo 'value='.$_POST['surname']; ?>></br>
	<input name="patro" placeholder="Отчество" <?php if(!empty($_POST['patro']))
		echo 'value='.$_POST['patro']; ?>></br>
	<input name="login" placeholder="Логин" <?php if(!empty($_POST['login']))
		echo 'value='.$_POST['login']; ?>></br>
	<?php 
	echo $pass_len;
	echo $pass_rule;
	echo $confirm;
	?>
	<input name="pass" type="password" placeholder="Пароль" <?php if(!empty($_POST['pass']))
		echo 'value='.$_POST['pass']; ?>></br>
	<input name="confirm" type="password" placeholder="Подтверждение" <?php if(!empty($_POST['confirm']))
		echo 'value='.$_POST['confirm']; ?>></br>
	Введите свою дату рождения</br>
	<?php echo $bday_rule;?>
	<input name="bday" placeholder="ДД.ММ.ГГГГ" <?php if(!empty($_POST['bday']))
		echo 'value='.$_POST['bday']; ?>></br>
	<?php echo $email_rule;?>
	<input name="email" placeholder="e-mail" <?php if(!empty($_POST['email']))
		echo 'value='.$_POST['email']; ?>></br>
	Ваша страна</br> 
	<select name="country">
		<option value="Не указывать">Не указывать</option>
		  <option value="Россия">Россия</option>
		  <option value="Казахстан">Казахстан</option>
		  <option value="Япония">Япония</option>
		  <option value="Америка">Америка</option>
		  <option value="Америка">Китай</option>
	</select></br>
	<input type="submit" value="Зарегистрироваться">
</form>
<?php
}
?>
</div>
</body>