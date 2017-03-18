<?
include_once('config.php');

/** Получаем наш ID статьи из запроса */
$id = intval($_POST['id']);
$alias = intval($_POST['alias']);
$count = 0;
$message = '';
$error = true;
/** Если нам передали ID то обновляем */
if($id){
	/** Обновляем количество лайков в статье */
	
	//$query = $mysqli->query("UPDATE `articles` SET `count_like` = `count_like`+1  WHERE `id` = '$id'");
	$setAlias = $mysqli->query("UPDATE `articles` SET `alias` = '$alias' WHERE `id` = '$id';");
	//$query3 = $mysqli->query("SELECT `id_art`, `id_usr` FROM `likes` WHERE `id_art` = '$id' AND `id_usr` = '$usr'");
	//$row3 = $query3->fetch_assoc();
	
	$error = false;
}else{
	/** Если ID пуст - возвращаем ошибку */
	
	$error = true;
	$message = 'Статья не найдена';
}


/** Возвращаем ответ скрипту */

// Формируем масив данных для отправки
$out = array(
	'error' => $error,
	'message' => $message,
	'count' => $count,
);

// Устанавливаем заголовот ответа в формате json
header('Content-Type: text/json; charset=utf-8');

// Кодируем данные в формат json и отправляем
echo json_encode($out);

