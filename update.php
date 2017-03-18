<?
include_once('config.php');

if (!$_SESSION['id']) {
	header("Location: index.php");
}

if (isset($_GET['id'])) {
	$id = intval(htmlspecialchars($_GET['id']));
}
/* достаем статью для редактирования из базы */
			
			$resultSelect = $db->prepare("SELECT * FROM `articles` WHERE `id` = ?");
			$resultSelect->execute(array($id));
			$row = $resultSelect->fetch();
/* конец извлечения статьи */

/* сохранение обновленной статьи*/
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
	if($_FILES['file']['name'] && mb_strlen($_FILES['file']['name']) > 3){
		$file_name = 'post_' . $id . '_' . trim(mb_strtolower($_FILES['file']['name']));
		$isImg = ", `img` = '$file_name'";
	}else{
		$file_name = $row['img'];
		$isImg = "";
	}
	$newCategory = $_POST['category']; 
			//извлекаем название категории
			$getNumberCategory = $db->prepare("SELECT `id_cat` FROM `categories` WHERE `name` = ?");
			$getNumberCategory->execute(array($newCategory));
			$getNumberCategory = $getNumberCategory->fetch();
	
	$getNumberCategory = $getNumberCategory['id_cat'];
	($getNumberCategory) ? $isCat = ", `category` = '$getNumberCategory'" : $isCat = "";
	
	$tags = ($_POST['tags']) ? htmlspecialchars(trim($_POST['tags'])) : $row['tags'];
	
	$tmp_name = $_FILES['file']['tmp_name'];
	move_uploaded_file($tmp_name, "img/$file_name");
}else {
	$file_name = $row['img'];
}

if ($_POST['title'] != '' && $_POST['text'] != '') {
	$title = htmlspecialchars($_POST['title']);
	$text = $_POST['text'];
	$id_author = htmlspecialchars(mb_convert_encoding($_POST['author'], 'cp1251', mb_detect_encoding($_POST['author'])));
	$result = $db->prepare("
	UPDATE `articles` SET `title` = ?, `text` = ?, `id_author` = ? $isImg $isCat, `tags` = ?
	WHERE `id` = ?");
	$result->execute(array($title, $text, $id_author, $tags, $id));
	
	//add pictures
	$img = $db->prepare("INSERT INTO `images` VALUES (NULL, ?, ?);");
	$img->execute(array($file_name, $id));
		
	header("Location: update.php?id=$id");
}
/* конец сохранения */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$title_con = $_POST['title'];
	$text_con = $_POST['text'];
	$author_con = $_POST['author'];
	$img = $_POST['img'];
	
}else {
	$title_con = $row['title'];
	$text_con = $row['text'];
	$author_con = $row['id_author'];
	$img = $row['img'];
}

	$getNameCat = $db->prepare("
	SELECT `categories`.`name`  FROM `categories` 
	JOIN `articles` ON `articles`.`category` = `categories`.`id_cat` 
	AND `articles`.`id` = ?");
	$getNameCat->execute(array($id));
	$getNameCat = $getNameCat->fetch();
			
	$getNameCat = $getNameCat['name'];
	$textTags = explode(',', $row['tags']);

include_once('view/v_edit.php');