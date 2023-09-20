<?php
session_start();
if(!empty($_SESSION['login']))
	echo "Приветствую: ".$_SESSION['login'];
else
	echo "Залогинтесь, чтобы увидеть больше";
echo "</br>(Текст для всех)";
if (isset($_SESSION['auth']))
echo "</br>(И текст для зарегистрированных)";
?>
</br><a href=http://localhost/Labs/users/login.php>Вернуться</a>