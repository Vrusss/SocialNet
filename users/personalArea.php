<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/freq.css">
</head>
<div id="header">LocalNet</br>Редактировать персональные данные</div>
<?php
session_start();
include_once 'func.php';
include 'leftcol.php';
?>
<div id="content">
Изменение аватарки</br>
<?php
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$name_rule=null;
$email_rule=null;
$bday_rule=null;
$login=$_SESSION['login'];
$user="SELECT * FROM users WHERE login='$login'";
$result=mysqli_query($link, $user);
$user=mysqli_fetch_assoc($result);
if(!empty($_POST['name']) and !empty($_POST['surname']) and !empty($_POST['patro']) and !empty($_POST['bDay']) 
	and !empty($_POST['email'])) {
	$name=$_POST['name'];
	$surname=$_POST['surname'];
	$patro=$_POST['patro'];
	$bDay=$_POST['bDay'];
	$email=$_POST['email'];
	$country=$_POST['country'];
	if(empty($name))
		$name_rule="Поле \'Имя\' не должно быть пустым";
	if(preg_replace('#\w+@[a-z]+\.[a-z]{2,3}#','!',$email)!='!')
		$email_rule="Ваш email некорректен </br>";
	if(preg_replace('#\d{2}\.\d{2}\.\d{4}#','!',$bDay)!='!')
		$bday_rule="Дата рождения указана в неправильном формате </br>";
	if(empty($email_rule) and empty($bday_rule) and empty($name_rule)) {
		$user="UPDATE users SET name='$name', surname='$surname', patro='$patro',
		bDay='$bDay', email='$email', country='$country' WHERE id='$id'";
		mysqli_query($link, $user);
		echo 'Редактирование удалось!';
	} else {
		echo 'Редактирование не удалось';
	}
}	else {
	$name=$user['name'];
	$surname=$user['surname'];
	$patro=$user['patro'];
	$bDay=$user['bDay'];
	$email=$user['email'];
	$country=$user['country'];
}
$photo=$user['ava'];
if(!empty($_FILES['photo'])) {
      $check = can_upload($_FILES['photo']);
      if($check === true){
		unlink('avatars/' . $photo);
        $photo=make_upload($_FILES['photo']);
		$query="UPDATE users SET ava='$photo' WHERE login='$login'";
		mysqli_query($link, $query);
		header("refresh: 0");
      }
      else{
        echo "<strong>$check</strong>";  
      }
}

?>
<form enctype="multipart/form-data" method="POST"> 
<img src="avatars/<?php echo $photo;?>" width=50 height=50 class="round">
<input name="photo" type="file"></br>
<input type="submit" value="Загрузить">
</form></br>
Данные профиля:</br>
<form action="" method="POST">
	<?php echo $name_rule; ?>
	Имя</br>
	<input name="name" placeholder="Имя" <?php echo 'value='.$name; ?>></br>
	Фамилия</br>
	<input name="surname" placeholder="Фамилия" <?php echo 'value='.$surname; ?>></br>
	Отчество</br>
	<input name="patro" placeholder="Отчество" <?php echo 'value='.$patro; ?>></br>
	Дата рождения</br>
	<?php echo $bday_rule;?>
	<input name="bDay" placeholder="ДД.ММ.ГГГГ" <?php echo 'value='.$bDay; ?>></br>
	<?php echo $email_rule;?>
	E-mail</br>
	<input name="email" placeholder="e-mail" <?php echo 'value='.$email; ?>></br>
	Ваша страна</br>
	<select name="country">
		<option >Не указывать</option>
	  <option value="Россия" <?php if($country=='Россия') echo 'selected'; ?>>Россия</option>
	  <option value="Казахстан"<?php if($country=='Казахстан') echo 'selected'; ?>>Казахстан</option>
	  <option value="Япония"<?php if($country=='Япония') echo 'selected'; ?>>Япония</option>
	  <option value="Америка"<?php if($country=='Америка') echo 'selected'; ?>>Америка</option>
	  <option value="Китай"<?php if($country=='Китай') echo 'selected'; ?>>Китай</option>
	</select></br>
	
	<input type="submit" value="Сохранить">
	
</form>
</div id="content">