<? 
include_once('config.php');

if ($_POST['login'] != '' && $_POST['pswd'] != '' ) {
    $login = trim($_POST['login']);
    $pswd = trim($_POST['pswd']);
	
			$result = $db->prepare("SELECT * FROM `users` WHERE `email` = ?");
			$result->execute(array($login));
			$res2 = $result->fetch();

    if ($login === $res2['email'] && $pswd === $res2['password']) {
        $_SESSION['id'] = $res2['id'];
        $_SESSION['name'] = $res2['name'];
        header("Location: index.php");
    }else {
        $mssg = 'Введите корректные данные';
    }
}
include_once('view/header.php');
?>

<div id="templatemo_main">
<div id="templatemo_content">

<?if (isset($_SESSION['id'])):?>
<?
$mssg = 'Вы уже авторизованы!';
$mssg2 = '<a href="index.php">Перейти на главную</a>';
?>
    <p><?if(isset($mssg))echo $mssg;?></p>
    <p><?if(isset($mssg2))echo $mssg2;?></p>

<?else:?>

    <form method="post" class="login">
    <div>
    <input type="text" placeholder="Введите логин" name="login">
    </div>
    <div>
    <input type="password" placeholder="Введите пароль" name="pswd" >
    </div>
    <div>
    <input type="submit" value="Войти">
    <p><?if(isset($mssg))echo $mssg;?></p>
    <p><?if(isset($mssg2))echo $mssg2;?></p>
    </div>
    </form>

<?endif;?>

</div>

<? include('/view/sidebar.php');?>
 <div style="clear: both;"></div>
</div>

<? 
include_once('view/footer.php');
?>