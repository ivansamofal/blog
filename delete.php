<?
include_once('config.php');

if (isset($_GET['id'])) {
	$id = htmlspecialchars($_GET['id']);
}else{
	header("location: index.php");
}
	$db->beginTransaction(); //начинаем транзакцию
	$deleteLikes = $db->prepare("DELETE FROM `likes` WHERE `id_art` = ?");
	$deleteLikes = $deleteLikes->execute(array($id));
	$deleteComments = $db->prepare("DELETE FROM `comments` WHERE `id_article` = ?");
	$deleteComments = $deleteComments->execute(array($id));
	$deleteImages = $db->prepare("DELETE FROM `images` WHERE `id_article` = ?");
	$deleteImages = $deleteImages->execute(array($id));
	$result = $db->prepare("DELETE FROM `articles` WHERE `id` = ?");
	$result = $result->execute(array($id));
	if($deleteLikes && $deleteComments && $deleteImages && $result){
		$db->commit();
		header("location: index.php?param=del");
		die();
	}else{
		$db->rollback();
	}