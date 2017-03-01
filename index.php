<?
include_once('model/model.php');

if (!empty($_GET['id'])) {
		header("Location: index.php");
	}

if ($_GET['param'] == 'del') {
	$messageDelete = 'статья успешно удалена';
}

$obj1 = new to_db2;
$years = new years($num);

    if (isset($_POST['out'])) {
	$obj1->logout();
}

/*autorization */
$obj1->authorization($mysqli);
 /* end autorization */
 //вывод всех постов на главной с пагинацией
$arr = $obj1->pagination1($mysqli);

include ('view/v_index.php');