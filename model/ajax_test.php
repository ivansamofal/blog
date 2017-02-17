<?php
// подключение к бд
session_start();
mb_internal_encoding("UTF-8");
$mysqli = new mysqli('localhost', 'root', '', 'myblog');

// контейнер для ошибок 
$error = false;
// получение данных
$userId = (int) $_POST['id_user'];
$newsId = (int) $_POST['id_news'];
$type = $_POST['type'];

// проверяем, голосовал ранее пользователь за эту новость или нет
$sql = $mysqli->query("
	SELECT count(*) FROM `votes_news2user` WHERE `id_user` = $userId AND `id_news` = $newsId
") or die(mysql_error()); 
$result = $sql->fetch_assoc();
// если что-то пришло из запроса, значит уже голосовал
//var_dump($result);exit;
if($result[0] > 0){
	$error = 'Вы уже голосовали';
}else{ // если пользователь не голосовал, проголосуем
	// получем поле для голосования - лайк или дизлайк
	if($type == 'like') $fieldName = 'count_like'; 
	if($type == 'dislike') $fieldName = 'count_dislike';
	// делаем запись о том, что пользователь проголосовал
	mysql_query("
		INSERT INTO `votes_news2user` (`id_user`, `id_news`) VALUES ($userId, $newsId)
	") or die(mysql_error()); 
	// делаем запись для новости - увеличиваем количесво голосов(лайк или дизлайк)
	mysql_query("
		UPDATE `test_db`.`news` SET `$fieldName`= `$fieldName` + 1 WHERE  `id` = $newsId
	") or die(mysql_error());
}
	
// делаем ответ для клиента
if($error){
	// если есть ошибки то отправляем ошибку и ее текст
	echo json_encode(array('result' => 'error', 'msg' => $error));
}else{
	// если нет ошибок сообщаем об успехе
	echo json_encode(array('result' => 'success'));
}
