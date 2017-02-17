<?
include_once('config.php');

/** Получаем наш ID статьи из запроса */
$id = intval($_POST['id']);
$usr = intval($_POST['usr']);
$count = 0;
$message = '';
$error = true;
/** Если нам передали ID то обновляем */
if($id){
	/** Обновляем количество лайков в статье */
	
	//$query = $mysqli->query("UPDATE `articles` SET `count_like` = `count_like`+1  WHERE `id` = '$id'");
	$query4 = $mysqli->query("UPDATE `articles` SET `count_like` = WHERE `id_art` = '$id' AND `id_usr` = '$usr';");
	$query3 = $mysqli->query("SELECT `id_art`, `id_usr` FROM `likes` WHERE `id_art` = '$id' AND `id_usr` = '$usr'");
	$row3 = $query3->fetch_assoc();

	if ($row3) {
		$query2 = $mysqli->query("DELETE FROM `likes` WHERE `id_art` = '$id' AND `id_usr` = '$usr';");
	}else {
		$query2 = $mysqli->query("INSERT INTO `likes` VALUES (NULL, '$id','$usr', '');");
		
		//$query5 = $mysqli->query("SELECT count(`id`) FROM `likes` WHERE `id_art` = '$id' AND `id_usr` = '$usr';");
	}
		$query = $mysqli->query("SELECT count(`id`) FROM `likes` WHERE `id_art` = '$id' AND `id_usr` = '$usr';");
		$result = $query->fetch_assoc();
	
	
	/** Выбираем количество лайков в статье */
	//$query = $mysqli->query("SELECT `count_like` FROM `articles` WHERE id = '$id'");
	$query = $mysqli->query("SELECT DISTINCT count(`id`) FROM `likes` WHERE `id_art` = '$id'");
	$result = $query->fetch_assoc();
	$query6 = $mysqli->query("UPDATE `articles` SET `count_like` = '{$result["count(`id`)"]}' WHERE `id` = '$id';");
	$getMyLike = $mysqli->query("SELECT count(`id`) as num FROM `likes` WHERE `id_art` = '$id' AND `id_usr` = '$usr'");
	$getMyLike = $getMyLike->fetch_assoc();
	$getMyLike = $getMyLike['num'];
	($getMyLike) ? $isActive = true : $isActive = false;
	$count = isset($result["count(`id`)"]) ? $result["count(`id`)"]  : 0;
	
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
	'isActive' => $isActive
);

// Устанавливаем заголовот ответа в формате json
header('Content-Type: text/json; charset=utf-8');

// Кодируем данные в формат json и отправляем
echo json_encode($out);

