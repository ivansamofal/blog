<?
class userClass{
	public function getUsers($db, $id){
	
	$getUser = $db->prepare("SELECT * FROM `users` WHERE `id` = ?");
	$getUser->execute(array($id));
	$getUser = $getUser->fetch();
	return $getUser;
	}
}