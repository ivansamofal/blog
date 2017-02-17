<? 
include_once('model/model.php');

if ($_POST['login'] != '' && $_POST['pswd'] != '' ) {
    $login = trim(mysql_real_escape_string($_POST['login']));
    $pswd = trim(mysql_real_escape_string($_POST['pswd']));
    $mysqli->query("SET names 'cp1251'");
    $result = $mysqli->query("SELECT * FROM `users` WHERE `email` = '$login';"); 
    $res2 = $result->fetch_assoc();

    if ($login === $res2['email'] && $pswd === $res2['password']) {
        $_SESSION['id'] = $res2['id'];
        $_SESSION['name'] = $res2['name'];
        header("Location: index.php");
    }else {
        $mssg = 'Введите корректные данные';
    }
}

?>
<head>
<link rel="stylesheet" href="css/style.css">
<title><?=$row['title']?></title>
<meta charset="utf-8">
<!-- скрипты для увеличения фоток на странице отелей -->
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery.shadow.js"></script>
<script type="text/javascript" src="js/jquery.ifixpng.js"></script>
<script type="text/javascript" src="js/jquery.fancyzoom.min.js"></script>
<script type="text/javascript">
    jQuery(function() {
        jQuery('#fancy a').fancyzoom();
    });
</script>
</head>
<body>
<div class="logo"><a href="index.php"><div></div></a>
    <p><a href="index.php">Главная</a></p>
    <?if(isset($_SESSION['id'])):?>
	<p><a href="create.php">Создать статью</a></p>
	<p><a href="update.php?id=<?=$id?>">Редактировать</a></p>
	<p><a href="delete.php?id=<?=$id?>">Удалить</a></p>
    <?else:?>
<p><a href="register.php">Регистрация</a></p>
<p><a href="login.php">Войти</a></p>
<?endif;?>

	</div>


<?if (isset($_SESSION['id'])):?>
<div class="article">
<?
$mssg = 'Вы уже авторизованы!';
$mssg2 = '<a href="index.php">Перейти на главную</a>';
?>
    <p><?if(isset($mssg))echo $mssg;?></p>
    <p><?if(isset($mssg2))echo $mssg2;?></p>
</div>
<?else:?>

<div class="article">
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
</div>

<?endif;?>

</body>