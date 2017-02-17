<?
include_once('config.php');
		

if (!empty($_POST['login']) && !empty($_POST['login']) && !empty($_FILES['file']['name'])) {
		//$login = $_POST['login'];
		($_POST['login']) ? $login = htmlspecialchars($mysqli->real_escape_string(trim($_POST['login']))) : '';
		//$name = $_POST['name'];
		($_POST['name']) ? $name = htmlspecialchars($mysqli->real_escape_string(trim($_POST['name']))) : '';
		//$surname = $_POST['surname'];
		($_POST['surname']) ? $surname = htmlspecialchars($mysqli->real_escape_string(trim($_POST['surname']))) : '';
		//$age = $_POST['age'];
		($_POST['age']) ? $age = htmlspecialchars($mysqli->real_escape_string(trim($_POST['age']))) : '';
		//$email = $_POST['email'];
		($_POST['email']) ? $email = htmlspecialchars($mysqli->real_escape_string(trim($_POST['email']))) : '';
		//$password = $_POST['password'];
		($_POST['password']) ? $password = htmlspecialchars($mysqli->real_escape_string(trim($_POST['password']))) : '';
		$file = $_FILES['file']['name'];
		$tmp_name = $_FILES['file']['tmp_name'];
		($_POST['about']) ? $about = htmlspecialchars($mysqli->real_escape_string(trim($_POST['about']))) : '';
		//создаем ID для нового юзера, берем ID последнего и прибавляем 1
		$getIdUser = $mysqli->query("SELECT `id` FROM `users` ORDER BY `id` DESC LIMIT 1");
		$getIdUser = $getIdUser->fetch_assoc();
		$getIdUser = intval($getIdUser['id']) + 1;
		$dir_user = "img/avatars/$getIdUser";
		if(!is_dir($dir_user)){
			mkdir($dir_user);
		}
		move_uploaded_file($tmp_name, "$dir_user/$file");
		//$mysqli->query("SET names 'cp1251'");
		$mysqli->query("SET NAMES 'utf8'"); 
		$mysqli->query("SET CHARACTER SET 'utf8'");
		$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");
    	$login = $mysqli->query("INSERT INTO `users` VALUES (NULL, '$login', '$name', '$surname', '$age', '$email', '$password', '$file', '$about');");
    	$_SESSION['msg'] = 'вы успешно зарегились';
    	header("Location: index.php");
}

?>


<? include('view/header.php');?>
<div id="templatemo_main">
<div id="templatemo_content">
<?if (isset($_SESSION['id'])):?>
<div>
    <p>Вы уже авторизованы!</p>
    <p><a href="index.php">Перейти на главную</a></p>
    </div>
<?else:?>

<div>
<h3 style="text-align: center;">Регистрация нового пользователя:</h3>
    <form action="#" method="post" class="register" enctype="multipart/form-data">
<input type="text" placeholder="enter login" name="login">
<input type="text" placeholder="enter name" name="name">
<input type="text" placeholder="enter surname" name="surname">
<input type="text" placeholder="enter age" name="age">
<input type="text" placeholder="enter email" name="email">
<input type="password" placeholder="enter password" name="password">
<input type="file" name="file">
<textarea name="about"></textarea>
<input type="submit" placeholder="enter">
</form>
</div>

<?endif;?>
</div>
<? include('view/sidebar.php');?>
 <div style="clear: both;"></div>
</div>
<? include('view/footer.php');?>