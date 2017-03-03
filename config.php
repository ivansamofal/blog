<?
session_start();
ini_set('default_charset', 'UTF-8');
mb_internal_encoding("UTF-8");
$mysqli = new mysqli('localhost', 'root', '', 'myblog');
$mysqli->set_charset('utf8');

//автозагрузка классов
function __autoload( $className ) {
  $className = str_replace( "..", "", $className );
  require_once( "classes/$className.php" );
}

//title for site default
$title = 'myBlog';
$titleSite = 'Блог на PHP своими руками';
$keywords = 'Блог, обучение php с нуля';
$description = 'Удобный блог для чтения интересных постов';



//for sidebar
$obj1 = new to_db2;
$years = new years($num);

    if (isset($_POST['out'])) {
	$obj1->logout();
}
/*autorization */
$obj1->authorization($mysqli);
 /* end autorization */