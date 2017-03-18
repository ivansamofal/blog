<?php
include_once('config.php');

/** Получаем наш ID статьи из запроса */
$id = intval($_POST['id']);
$usr = intval($_POST['usr']);
$msg = $_POST['msg'];
unset($_SESSION['serv']);
$count = 0;
$message = '';
$timeCom = date('G-i-s');
$dateCom = date('Y-m-d');

$error = true;
/** Если нам передали ID то обновляем */

if($id && $usr && $msg){
	/** Обновляем количество лайков в статье */
	
	if ($msg != '') {
		$mysqli->query("SET names 'utf-8'");
		$query9 = $mysqli->query("INSERT INTO `comments` VALUES (NULL, '$msg', '$usr', '$timeCom', '$dateCom', '$id');");
	}
	
//SELECT * FROM `comments` JOIN `users` ON `comments`.`author` = `users`.`id` ORDER BY `comments`.`id` DESC LIMIT 1
	$query10 = $mysqli->query("SELECT * FROM `comments` JOIN `users` ON `comments`.`author` = `users`.`id` ORDER BY `comments`.`id` DESC LIMIT 1");
	while ($row5 = $query10->fetch_assoc()) {
		$some['text'] = $row5['text_comm'];
		$some['time'] = $row5['time_comm'];
		$some['date'] = $row5['date_comm'];
		$some['author'] = $row5['author'];
		$some['name'] = $row5['name'];
		$some['surname'] = $row5['surname'];
		$some['age'] = $row5['age'];
		$some['avatar'] = $row5['avatar'];
	}

	
	$error = false;
}else{
	/** Если ID пуст - возвращаем ошибку */
	$msg = 'erqer';
	$error = true;
	$message = 'Статья не найдена';
}


/** Возвращаем ответ скрипту */

// Формируем масив данных для отправки
$out = array(
	'some' => $some,
	'message' => $message,
	'count' => $count,
	//'msg' => $some['text'][2],
	'msg' => $some
);

// Устанавливаем заголовот ответа в формате json
header('Content-Type: text/json; charset=utf-8');

// Кодируем данные в формат json и отправляем
echo json_encode($out);

