<?
include_once('config.php');

mb_internal_encoding("UTF-8");
//для статей конкретной категории
$cat = (isset($_GET['cat'])) ? htmlspecialchars($mysqli->real_escape_string(trim($_GET['cat']))) : "";
if($_GET['cat']){
	$getIDCat = $mysqli->query("SELECT `id_cat`, `name` FROM `categories` WHERE `alias_cat` = '$cat'");
	$getIDCat = $getIDCat->fetch_assoc();
	$nameCat = $getIDCat['name'];
	$getIDCat = $getIDCat['id_cat'];
	$selectCats = $mysqli->query("SELECT * FROM `articles` WHERE `category` = '$getIDCat'");
}
//для результатов поиска: если есть поисковый запрос - ищем, если нет - отображаем категорию
if($_GET['query']){
		$searchQuery = ($_GET['query']) ? '%' . $mysqli->real_escape_string(trim($_GET['query'])) . '%' : '';
		$getSearch = $mysqli->prepare("SELECT * FROM `articles` WHERE `title` LIKE ? OR `text` LIKE ? OR `tags` LIKE ?");
		$getSearch->bind_param("sss", $searchQuery, $searchQuery, $searchQuery);
		$getSearch->execute();
		$getSearch = $getSearch->get_result();
		//$selectCats = $getSearch;
		$arr['res']  = $getSearch;
}else{
	$arr = $obj1->paginationCategory($mysqli, $cat);
}

include_once('view/v_articles.php');