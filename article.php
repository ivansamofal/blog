<?
include_once('config.php');
$years = new years($num);
$article = new Article($db);
if (isset($_GET['id'])) {
	$id = intval(htmlspecialchars($_GET['id']));
}else{
	header("Location: index.php");
}
$usr = $_SESSION['id'];

/*публикуем комментарии*/
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['text_comment'])) {
	
	$text = htmlspecialchars(mb_convert_encoding($_POST['text_comment'], 'cp1251', mb_detect_encoding($_POST['text_comment'])));
	$author = intval(htmlspecialchars($_POST['author_comment']));
	$date = date(Y . '-' . m .'-' . d);
	$time = date(G . ':' . i . ':' . s);
	
			$result = $db->prepare("INSERT INTO `comments` VALUES (NULL, ?, ?, ?, ?, ?)");
			$result->execute(array($text, $author, $time, $date, $id));
			
	$_SESSION['serv'] = $_POST['text_comment'];

	header("Location: article.php?id=$id");
	die();
}
/* конец публикации комментов */

/* подсчет посещаемости страницы*/

			$stat = $db->prepare("UPDATE `articles` SET `stat` = `stat` + 1 WHERE `id` = ?");
			$stat->execute(array($id));
			$metr = $db->prepare("SELECT `stat` FROM `articles` WHERE `id` = ?");
			$metr->execute(array($id));
			$metr2 = $metr->fetch();
			
/* конец подсчет посещаемости страницы*/

/* извлекаем одну запись для отображения*/

			$getFullArticle = $db->prepare("
			SELECT * FROM `articles` JOIN `categories` 
			ON `articles`.`category` = `categories`.`id_cat` 
			AND `articles`.`id` = :id");
			$getFullArticle->bindParam(':id', $id, PDO::PARAM_INT);
			$getFullArticle->execute(array(':id' => $id));
			$row = $getFullArticle->fetch();
/* конец извлекаем одну запись для отображения*/

/* извлекаем автора поста*/ 

			$result5 = $db->prepare("SELECT `name`, `surname`, `age`, `avatar` FROM `users` WHERE `id` = ?");
			$result5->execute(array($row['id_author']));
			$res2 = $result5->fetch();

/* конец извлекаем автора поста*/ 

			$result2 = $db->prepare("SELECT * FROM `comments` WHERE `id_article` = ? ORDER BY `id` DESC");
			$result2->execute(array($id));
			
while ($row2 = $result2->fetch())  {
	
	$comm['text_comm'][] = mb_convert_encoding($row2['text_comm'], 'utf-8', mb_detect_encoding($row2['text_comm']));
	$comm['time_comm'][] = mb_convert_encoding($row2['time_comm'], 'utf-8', mb_detect_encoding($row2['time_comm']));
	$comm['date_comm'][] = mb_convert_encoding($row2['date_comm'], 'utf-8', mb_detect_encoding($row2['date_comm']));
	$comm['author'][] = mb_convert_encoding($row2['author'], 'utf-8', mb_detect_encoding($row2['author']));
}

for ($k = 0; $k < count ($comm['text_comm']); $k++) {

			$result2 = $db->prepare("SELECT `id`, `name`, `surname`, `age`, `avatar` FROM `users` WHERE `id` = ?");
			$result2->execute(array($comm['author'][$k]));
			$row3 = $result2->fetch();

$authors['name'][] = $row3['name'];
$authors['surname'][] = $row3['surname'];
$authors['age'][] = $row3['age'];
$authors['avatar'][] = $row3['avatar'];
$authors['id'][] = $row3['id'];
}

/* вывод фоток к посту*/

			$foto = $db->prepare("SELECT * FROM `images` WHERE `id_article` = ?");
			$foto->execute(array($id));
			
while ($foto2 = $foto->fetch()) {
	$url['foto'][] = $foto2['title_img'];
}
/* конец вывод фоток к посту*/
	//проверка, ставил ли лайк юзер этой статье. если ставил - то сердечко закрашенное
			$getMyLike = $db->prepare("SELECT count(`id`) as num FROM `likes` WHERE `id_art` = ? AND `id_usr` = ?");
			$getMyLike->execute(array($id, $usr));
			$getMyLike = $getMyLike->fetch();
	$getMyLike = $getMyLike['num'];
	($getMyLike) ? $isActive = true : $isActive = false;

include ('view/v_article.php');