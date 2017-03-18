<?
include_once('config.php');

if (!empty($_GET['id'])) {
		header("Location: index.php");
	}
$messageDelete = ($_GET['param'] == 'del') ?  'статья успешно удалена' : '';

    if (isset($_POST['out'])) {
	$obj1->logout();
}
 //вывод всех постов на главной с пагинацией
$arr = $obj1->pagination1($mysqli);

include ('view/v_index.php');