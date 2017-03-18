<?
include_once('config.php');
$id = ($_GET['id']) ? htmlspecialchars(trim($_GET['id'])) : '';

$userObj = new userClass;
$getUser = $userObj->getUsers($mysqli, $id);

include_once('view/v_user.php');