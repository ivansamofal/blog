<?
include_once('config.php');

if (isset($_GET['id'])) {
	$id = htmlspecialchars($mysqli->real_escape_string($_GET['id']));
}else{
	header("location: index.php");
}
	$deleteLikes = $mysqli->query("DELETE FROM `likes` WHERE `id_art` = '$id'");
	$deleteComments = $mysqli->query("DELETE FROM `comments` WHERE `id_article` = '$id'");
	$deleteImages = $mysqli->query("DELETE FROM `images` WHERE `id_article` = '$id'");
	$result = $mysqli->query("DELETE FROM `articles` WHERE `id` = $id");
	
	if ($result) {
		//echo 'статья успешно удалена';
		header("location: index.php?param=del");
	}
	