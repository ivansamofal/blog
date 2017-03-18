<?
//$mysqli = new mysqli('localhost', 'root', '', 'myblog');
class article {
	
	
	public function comments ($mysqli) {
		/*публикуем комментарии*/
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['text_comment'])) {
	
	$text = $mysqli->real_escape_string(htmlspecialchars(mb_convert_encoding($_POST['text_comment'], 'cp1251', mb_detect_encoding($_POST['text_comment']))));
	$author = $mysqli->real_escape_string(htmlspecialchars($_POST['author_comment']));
	$date = date(Y . '-' . m .'-' . d);
	$time = date(G . ':' . i . ':' . s);
	//$mysqli->query("SET names 'cp1251'");
	$result = $mysqli->query("INSERT INTO `comments` VALUES (NULL, '$text', '$author', '$time', '$date', '$id');");  //comments subd
	return $_SESSION['serv'] = $_POST['text_comment'];

	header("Location: article.php?id=$id");
	//die();
			}
/* конец публикации комментов */

	}

}

