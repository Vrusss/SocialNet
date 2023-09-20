<?php
  function can_upload($file){
    if($file['name'] == '')
		return 'Вы не выбрали файл.';
	if($file['size'] == 0)
		return 'Файл слишком большой.';
	$getMime = explode('.', $file['name']);
	$mime = strtolower(end($getMime));
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
	return true;
  }
  
  function make_upload($file){	
	$photo = mt_rand(0, 10000) . $file['name'];
	copy($file['tmp_name'], 'C:/xampp/htdocs/Labs/users/avatars/' . $photo);
	
	return $photo;
  }
?>