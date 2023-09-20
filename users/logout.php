<?php
session_start();
$_SESSION['auth']=null;
$_SESSION['login']=null;
header("Location: http://localhost/Labs/users/login.php");
die();
?>