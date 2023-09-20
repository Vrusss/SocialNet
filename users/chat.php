<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/chat.css">
</head>
<div id="header">LocalNet</br>Чат</div>

<?php
session_start();
include 'leftcol.php';
$host='localhost';
$user='root';
$password='';
$db_name='KT2_2';
$link=mysqli_connect($host, $user, $password, $db_name);
mysqli_query($link, "SET NAMES 'utf8'");
$u1=$_GET['sender'];
$u2=$_GET['getter'];
$name=strtolower($_GET['name']);
$chat="SELECT * FROM $name";
$result=mysqli_query($link, $chat) or die (mysqli_error($link));
for ($chat=array();$row=mysqli_fetch_assoc($result); $chat[]=$row);
$login="SELECT name, ava FROM users WHERE login='$u1'";
$result=mysqli_query($link, $login);
$login=mysqli_fetch_assoc($result);
$nameLog=$login['name'];
$avaLog=$login['ava'];
$getter="SELECT name, ava FROM users WHERE login='$u2'";
$result=mysqli_query($link, $getter);
$getter=mysqli_fetch_assoc($result);
$nameGet=$getter['name'];
$avaGet=$getter['ava'];
if(!empty($_POST['msg'])) {
$time=time();
$msg=$_POST['msg'];
$msg=htmlspecialchars($msg);
$msg=trim($msg);
$msg=addslashes($msg);
$query="INSERT INTO $name (user, time, msg) VALUES ('$u1', '$time', '$msg')";
mysqli_query($link, $query);
header('refresh: 0');
}
?>
<div id="content">
<?php
echo "Переписка с <a href=http://localhost/Labs/users/profile.php?login=$u2>$u2</a>";
?>
<div class='chat'>
	<div class='chat-messages'>
		<div class='chat-messages__content' id='messages'>
			<?php
			if(!empty($chat)) {
					foreach($chat as $elem) {
						if($elem['user']==$u1) {
							echo "<div class='chat__message chat__message_blue'><img src=avatars/$avaLog width=30 height=30 class=round><b>$nameLog:</b> $elem[msg]</div>";
						} else {
							echo "<div class='chat__message'><img src=avatars/$avaGet width=30 height=30 class=round><b>$nameGet:</b> $elem[msg]</div>";
						}
					}
				} else echo "Сообщений пока нет";
			?>
		</div>
	</div>
	<div class='chat-input'>
		<form action="" method='post' id='chat-form'>
			<input type='text' name='msg' class='chat-form__input' placeholder='Введите сообщение' autofocus> <input type='submit' class='chat-form__submit' value='Отправить'>
		</form>
	</div>
</div>
</div>
