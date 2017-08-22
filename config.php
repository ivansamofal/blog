<?
session_start();
ini_set('default_charset', 'UTF-8');
mb_internal_encoding("UTF-8");

define("HOST", "localhost");
define("DBNAME", "myblog2");
define("DBUSER", "root");
define("DBPASSWORD", "");

//подключение через PDO
try {
    $db = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, DBUSER, DBPASSWORD,
	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

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
$obj1->authorization($db);
 /* end autorization */