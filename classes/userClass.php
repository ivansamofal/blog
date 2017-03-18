<?
class userClass{
	public function getUsers($mysqli, $id){
	
	$getUser = $mysqli->prepare("SELECT * FROM `users` WHERE `id` = ?");
	$getUser->bind_param("s", $id);
	$getUser->execute();
	$getUser = $getUser->get_result();
	$getUser = $getUser->fetch_assoc();
	return $getUser;
	}
}