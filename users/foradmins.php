<head>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<style type="text/css">
#content{
	background-color: white;
}
td {
    border: 1px solid #333;
}

thead,
tfoot {
    background-color: #663399;
    color: #fff;
}
</style>
<div id="header">LocalNet</br>Профиль</div>
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
$users="SELECT *, statuses.status as status FROM users LEFT JOIN statuses ON users.status_id=statuses.id";
$result=mysqli_query($link, $users) or die (mysqli_error($link));
for ($users=array();$row=mysqli_fetch_assoc($result); $users[]=$row);
if(!empty($_SESSION['auth']) and !empty($_SESSION['status'])) {
?>
<table>
    <thead>
		<tr> 
		<th colspan="7">Пользователи сайта</th> 
		</tr>
        <tr>
            <th>Логин</th>
			<th>Статус</th>
			<th>Удаление</th>
			<th>Изменение статуса</th>
			<th>Забанить/разбанить</th>
        </tr>
    </thead>
    <tbody>
	<?php 
	foreach ($users as $user) {
	?>
	<style type="text/css">
	h<?php echo $user['id']; ?> {
		background-color: 
		<?php 
			if($user['status']=='admin') 
				echo 'red'; 
			else echo 'green'; 
		?>;
	}
	</style>
	<h<?php echo $user['id']; ?>>
        <tr>
            <td><?php echo $user['login']; ?></td>
            <td><?php echo $user['status']; ?></td>
			<td> <a href=http://localhost/Labs/users/admindel.php?id=<?php echo $user['id'] ?>>Удалить</a> </th>
			<?php if($user['status']=='user') { ?>
			<td> <a href=http://localhost/Labs/users/statchange.php?id=<?php echo $user['id'] ?>>Сделать админом</a> </th>
			<?php 
					$_SESSION['statchange']=2; 
				} else {
			?>
			<td> <a href=http://localhost/Labs/users/statchange.php?id=<?php echo $user['id'] ?>>Сделать юзером</a> </th>
			<?php 
					$_SESSION['statchange']=1; 
				}
			if($user['ban']==0) { ?>
			<td> <a href=http://localhost/Labs/users/banhammer.php?id=<?php echo $user['id'] ?>>Забанить</a> </th>
			<?php 
					$_SESSION['ban']=1; 
				} else {
			?>
			<td> <a href=http://localhost/Labs/users/banhammer.php?id=<?php echo $user['id'] ?>>Разбанить</a> </th>
			<?php 
					$_SESSION['ban']=0; 
				}
			?>
        </tr>
	</h<?php echo $user['id']; ?>>
<?php
	}
}
?>
    </tbody>
</table>
</body>