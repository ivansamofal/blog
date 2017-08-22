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
	$query4 = $db->prepare("UPDATE `articles` SET `count_like` = WHERE `id_art` = ? AND `id_usr` = ?;");
	$query4->execute(array($id, $usr));
	$query3 = $db->prepare("SELECT `id_art`, `id_usr` FROM `likes` WHERE `id_art` = ? AND `id_usr` = ?");
	$query3->execute(array($id, $usr));
	$row3 = $query3->fetch();

	if ($row3) {
		$query2 = $db->prepare("DELETE FROM `likes` WHERE `id_art` = ? AND `id_usr` = ?;");
		$query2->execute(array($id, $usr));
	}else {
		$query2 = $db->prepare("INSERT INTO `likes` VALUES (NULL, ?,?, '');");
		$query2->execute(array($id, $usr));
		
		//$query5 = $mysqli->query("SELECT count(`id`) FROM `likes` WHERE `id_art` = '$id' AND `id_usr` = '$usr';");
	}
		$query = $db->prepare("SELECT count(`id`) FROM `likes` WHERE `id_art` = ? AND `id_usr` = ?;");
		$query->execute(array($id, $usr));
		$result = $query->fetch();
	
	
	/** Выбираем количество лайков в статье */
	//$query = $mysqli->query("SELECT `count_like` FROM `articles` WHERE id = '$id'");
	$query = $db->prepare("SELECT DISTINCT count(`id`) FROM `likes` WHERE `id_art` = ?");
	$query->execute(array($id));
	$result = $query->fetch();
	$query6 = $db->prepare("UPDATE `articles` SET `count_like` = ? WHERE `id` = ?;");
	$query6->execute(array($result["count(`id`)"], $id));
	$getMyLike = $db->prepare("SELECT count(`id`) as num FROM `likes` WHERE `id_art` = ? AND `id_usr` = ?");
	$getMyLike->execute(array($id, $usr));
	$getMyLike = $getMyLike->fetch();
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

