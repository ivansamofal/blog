<?
session_start();
//header('Content-Type: text/html; charset=utf-8');
mysql_set_charset('utf8');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding("UTF-8");
$mysqli = new mysqli('localhost', 'root', '', 'myblog');
//$mysqli->query("SET names 'utf8'"); 
//$mysqli->query("SET names 'cp1251'");
//$mysqli->query("mysql_set_charset 'utf8'");
//$mysqli->query("SET CHARACTER SET 'utf8'");
//$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");
//автозагрузка классов
function __autoload( $className ) {
  $className = str_replace( "..", "", $className );
  require_once( "classes/$className.php" );
}
/*
if(isset($_GET['id']) && $_GET['id'] != $_SESSION['id']){
	header("Location: {$_SERVER['HTTP_REFERER']}");
}
*/
//title for site default
$title = 'myBlog';
$titleSite = 'Блог на PHP своими руками';
$keywords = 'Блог, апельсиновый блог';
$description = 'Удобный блог для чтения интересных постов';



//for sidebar
$obj1 = new to_db2;
$years = new years($num);

    if (isset($_POST['out'])) {
	$obj1->logout();
}
$obj1->authorization($mysqli);