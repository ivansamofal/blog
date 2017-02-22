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
	$file_name = $_FILES['file']['name'];
	($file_name) ? $isImg = ", `img` = '$file_name'" : $isImg = "";
	$newCategory = $_POST['category']; 
	$getNumberCategory = $mysqli->query("SELECT `id_cat` FROM `categories` WHERE `name` = '$newCategory'");
	$getNumberCategory = $getNumberCategory->fetch_assoc();
	$getNumberCategory = $getNumberCategory['id_cat'];
	($getNumberCategory) ? $isCat = ", `category` = '$getNumberCategory'" : $isCat = "";
	$tmp_name = $_FILES['file']['tmp_name'];
	move_uploaded_file($tmp_name, "img/$file_name");
}else {
	$file_name = $row['img'];
}

if ($_POST['title'] != '' && $_POST['text'] != '') {
	$title = $mysqli->real_escape_string(htmlspecialchars(mb_convert_encoding($_POST['title'], 'cp1251', mb_detect_encoding($_POST['title']))));
	//echo $title;
	
	$text = $mysqli->real_escape_string(mb_convert_encoding($_POST['text'], 'cp1251', mb_detect_encoding($_POST['text'])));
	$id_author = $mysqli->real_escape_string(htmlspecialchars(mb_convert_encoding($_POST['author'], 'cp1251', mb_detect_encoding($_POST['author']))));

	$mysqli->query("SET names 'cp1251'");
	//$mysqli->query("SET NAMES 'utf8'"); 
		//$mysqli->query("SET CHARACTER SET 'utf8'");
		//$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");
	$result = $mysqli->query("UPDATE `articles` SET `title` = '$title', `text` = '$text', `id_author` = '$id_author' $isImg $isCat WHERE `id` = $id");
	$img = $mysqli->query("INSERT INTO `images` VALUES (NULL, '$file_name', '$id');"); //add pictures
	
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

$getNameCat = $mysqli->query("SELECT `categories`.`name`  FROM `categories` JOIN `articles` ON `articles`.`category` = `categories`.`id_cat` AND `articles`.`id` = '$id'");
$getNameCat = $getNameCat->fetch_assoc();
$getNameCat = $getNameCat['name'];
?>
<?
include_once('view/v_edit.php');
?>