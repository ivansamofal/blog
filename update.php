<?
include_once('config.php');

if (!$_SESSION['id']) {
	header("Location: index.php");
}

if (isset($_GET['id'])) {
	$id = htmlspecialchars($mysqli->real_escape_string($_GET['id']));
}
/* достаем статью для редактирования из базы */
//$result = $mysqli->query("SELECT * FROM `articles` WHERE `id` = $id");

			$resultSelect = $mysqli->prepare("SELECT * FROM `articles` WHERE `id` = ?");
			$resultSelect->bind_param("s", $id);
			$resultSelect->execute();
			$resultSelect = $resultSelect->get_result();
			$row = $resultSelect->fetch_array();
/* конец извлечения статьи */

/* сохранение обновленной статьи*/
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$file_name = 'post_' . $id . '_' . trim(mb_strtolower($_FILES['file']['name']));
	($file_name) ? $isImg = ", `img` = '$file_name'" : $isImg = "";
	$newCategory = $_POST['category']; 
	//$getNumberCategory = $mysqli->query("SELECT `id_cat` FROM `categories` WHERE `name` = '$newCategory'");
	//$getNumberCategory = $getNumberCategory->fetch_assoc();
			//извлекаем название категории
			$getNumberCategory = $mysqli->prepare("SELECT `id_cat` FROM `categories` WHERE `name` = ?");
			$getNumberCategory->bind_param("s", $newCategory);
			$getNumberCategory->execute();
			$getNumberCategory = $getNumberCategory->get_result();
			$getNumberCategory = $getNumberCategory->fetch_assoc();
	
	$getNumberCategory = $getNumberCategory['id_cat'];
	($getNumberCategory) ? $isCat = ", `category` = '$getNumberCategory'" : $isCat = "";
	
	$tags = ($_POST['tags']) ? $mysqli->real_escape_string(htmlspecialchars(trim($_POST['tags']))) : $row['tags'];
	
	$tmp_name = $_FILES['file']['tmp_name'];
	move_uploaded_file($tmp_name, "img/$file_name");
}else {
	$file_name = $row['img'];
}

if ($_POST['title'] != '' && $_POST['text'] != '') {
	$title = $mysqli->real_escape_string(htmlspecialchars($_POST['title']));
	$text = $mysqli->real_escape_string($_POST['text']);
	$id_author = $mysqli->real_escape_string(htmlspecialchars(mb_convert_encoding($_POST['author'], 'cp1251', mb_detect_encoding($_POST['author']))));
	$result = $mysqli->query("UPDATE `articles` SET `title` = '$title', `text` = '$text', `id_author` = '$id_author' $isImg $isCat, `tags` = '$tags' WHERE `id` = $id");
	//$img = $mysqli->query("INSERT INTO `images` VALUES (NULL, '$file_name', '$id');"); 
	
	//add pictures
	$img = $mysqli->prepare("INSERT INTO `images` VALUES (NULL, ?, ?);");
	$img->bind_param("ss", $file_name, $id);
	$img->execute();
		
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

//$getNameCat = $mysqli->query("SELECT `categories`.`name`  FROM `categories` JOIN `articles` ON `articles`.`category` = `categories`.`id_cat` AND `articles`.`id` = '$id'");
//$getNameCat = $getNameCat->fetch_assoc();

	$getNameCat = $mysqli->prepare("SELECT `categories`.`name`  FROM `categories` JOIN `articles` ON `articles`.`category` = `categories`.`id_cat` AND `articles`.`id` = ?");
	$getNameCat->bind_param("s", $id);
	$getNameCat->execute();
	$getNameCat = $getNameCat->get_result();
	$getNameCat = $getNameCat->fetch_assoc();
			
	$getNameCat = $getNameCat['name'];
	$textTags = explode(',', $row['tags']);
	var_dump($textTags);
?>
<?
include_once('view/v_edit.php');
?>