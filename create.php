<?
include_once('config.php');


$obj = new to_db2;
$obj->create_article($db);

include ('view/v_create.php');