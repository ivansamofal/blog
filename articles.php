<?
include_once('config.php');

mb_internal_encoding("UTF-8");
//для статей конкретной категории
$cat = (isset($_GET['cat'])) ? htmlspecialchars(trim($_GET['cat'])) : "";
if($_GET['cat']){
	$getIDCat = $db->prepare("SELECT `id_cat`, `name` FROM `categories` WHERE `alias_cat` = ?");
	$getIDCat->execute(array($cat));
	$getIDCat = $getIDCat->fetch();
	$nameCat = $getIDCat['name'];
	$getIDCat = intval($getIDCat['id_cat']);
	$selectCats = $db->prepare("SELECT * FROM `articles` WHERE `category` = ?");
	$selectCats->execute(array($getIDCat));
}
//для результатов поиска: если есть поисковый запрос - ищем, если нет - отображаем категорию
if($_GET['query']){
		$searchQuery = ($_GET['query']) ? '%' . htmlspecialchars(trim($_GET['query'])) . '%' : '';
		$getSearch = $db->prepare("SELECT * FROM `articles` WHERE `title` LIKE ? OR `text` LIKE ? OR `tags` LIKE ?");
		$getSearch->execute(array($searchQuery, $searchQuery, $searchQuery));
		$arr['res']  = $getSearch;
}else{
	$arr = $obj1->paginationCategory($db, $cat);
}

include_once('view/v_articles.php');