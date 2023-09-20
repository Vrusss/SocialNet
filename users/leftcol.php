<div id="leftcol">
<?php
if(!empty($_SESSION['auth'])) {
	echo "Приветствую ".$_SESSION['login']."</br>Ваш статус: ".$_SESSION['status'];
?>
</br><a href=http://localhost/Labs/users/profile.php<?php echo '?login='.$_SESSION['login'] ?>>Мой профиль</a>
</br><a href=http://localhost/Labs/users/messagges.php>Сообщения</a>
</br><a href=http://localhost/Labs/users/users.php>Список пользователей</a>
</br><a href=http://localhost/Labs/users/logout.php>Разлогиниться</a>
</br><a href=http://localhost/Labs/users/registration.php?logout=true?>Регистрация</a>
<?php if($_SESSION['status']=='admin') { ?>
</br><a href=http://localhost/Labs/users/foradmins.php>Администраторская</a>
<?php
	}
} else 
	header("Location: http://localhost/Labs/users/login.php");
?>
</div>