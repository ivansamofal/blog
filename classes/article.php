<?
//$mysqli = new mysqli('localhost', 'root', '', 'myblog');
class article {
	
	
	public function comments ($db) {
		/*публикуем комментарии*/
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['text_comment'])) {
	
	$text = htmlspecialchars(mb_convert_encoding($_POST['text_comment'], 'cp1251', mb_detect_encoding($_POST['text_comment'])));
	$author = htmlspecialchars($_POST['author_comment']);
	$date = date(Y . '-' . m .'-' . d);
	$time = date(G . ':' . i . ':' . s);
	//$mysqli->query("SET names 'cp1251'");
	$result = $db->prepare("INSERT INTO `comments` VALUES (NULL, ?, ?, ?, ?, ?);");  //comments subd
	$result->execute(array($text, $author, $time, $date, $id));
	return $_SESSION['serv'] = $_POST['text_comment'];

	header("Location: article.php?id=$id");
	//die();
			}
/* конец публикации комментов */

	}

}

