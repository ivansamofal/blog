<?
include_once('config.php');


$obj = new to_db2;
$obj->create_article($mysqli);

include ('view/v_create.php');