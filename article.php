<?
include_once('config.php');
include_once('model/model.php');
$years = new years($num);
$article = new Article($mysqli);
if (isset($_GET['id'])) {
	$id = htmlspecialchars(mysql_real_escape_string($_GET['id']));
}
$usr = $_SESSION['id'];


//$article->comments($mysqli);

/*публикуем комментарии*/
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['text_comment'])) {
	
	$text = $mysqli->real_escape_string(htmlspecialchars(mb_convert_encoding($_POST['text_comment'], 'cp1251', mb_detect_encoding($_POST['text_comment']))));
	$author = $mysqli->real_escape_string(htmlspecialchars($_POST['author_comment']));
	$date = date(Y . '-' . m .'-' . d);
	$time = date(G . ':' . i . ':' . s);
	$mysqli->query("SET names 'cp1251'");
	$result = $mysqli->query("INSERT INTO `comments` VALUES (NULL, '$text', '$author', '$time', '$date', '$id');");  //comments subd
	$_SESSION['serv'] = $_POST['text_comment'];

	header("Location: article.php?id=$id");
	die();
}
/* конец публикации комментов */

/* подсчет посещаемости страницы*/

$stat = $mysqli->query("UPDATE `articles` SET `stat` = `stat` + 1 WHERE `id` = '$id';");
$metr = $mysqli->query("SELECT `stat` FROM `articles` WHERE `id` = '$id';");
$metr2 = $metr->fetch_assoc();
/* конец подсчет посещаемости страницы*/

/* извлекаем одну запись для отображения*/
$result = $mysqli->query("SELECT * FROM `articles` JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` AND `articles`.`id` = $id");
$row = $result->fetch_array();
/* конец извлекаем одну запись для отображения*/

/* извлекаем автора поста*/ 
$result5 = $mysqli->query("SELECT `name`, `surname`, `age`, `avatar` FROM `users` WHERE `id` = '{$row['id_author']}'");
$res2 = $result5->fetch_assoc();

/* конец извлекаем автора поста*/ 

$result2 = $mysqli->query("SELECT * FROM `comments` WHERE `id_article` = $id ORDER BY `id` DESC");
while ($row2 = $result2->fetch_assoc())  {
	
	$comm['text_comm'][] = mb_convert_encoding($row2['text_comm'], 'utf-8', mb_detect_encoding($row2['text_comm']));
	$comm['time_comm'][] = mb_convert_encoding($row2['time_comm'], 'utf-8', mb_detect_encoding($row2['time_comm']));
	$comm['date_comm'][] = mb_convert_encoding($row2['date_comm'], 'utf-8', mb_detect_encoding($row2['date_comm']));
	$comm['author'][] = mb_convert_encoding($row2['author'], 'utf-8', mb_detect_encoding($row2['author']));
	
}

for ($k = 0; $k < count ($comm['text_comm']); $k++) {
$result2 = $mysqli->query("SELECT `id`, `name`, `surname`, `age`, `avatar` FROM `users` WHERE `id` = {$comm['author'][$k]}");
$row3 = $result2->fetch_assoc();
$authors['name'][] = $row3['name'];
$authors['surname'][] = $row3['surname'];
$authors['age'][] = $row3['age'];
$authors['avatar'][] = $row3['avatar'];
$authors['id'][] = $row3['id'];
}

/* вывод фоток к посту*/
$foto = $mysqli->query("SELECT * FROM `images` WHERE `id_article` = $id");
while ($foto2 = $foto->fetch_assoc()) {
	$url['foto'][] = $foto2['title_img'];
}
/* конец вывод фоток к посту*/
	//проверка, ставил ли лайк юзер этой статье. если ставил - то сердечко закрашенное
	$getMyLike = $mysqli->query("SELECT count(`id`) as num FROM `likes` WHERE `id_art` = '$id' AND `id_usr` = '$usr'");
	$getMyLike = $getMyLike->fetch_assoc();
	$getMyLike = $getMyLike['num'];
	($getMyLike) ? $isActive = true : $isActive = false;

include ('view/v_article.php');