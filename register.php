<?
include_once('config.php');
/*
function saltGenerator(){
	$salt = '';
	$strlenSalt = rand(3, 6);
	
	for($i = 0; $i < $strlenSalt; $i++){
		$salt .= 5; //получить случайный символж
	}
	return $salt;
}
		
	$salt = saltGenerator();
	*/
	
if (!empty($_POST['login']) && !empty($_POST['email']) && !empty($_FILES['file']['name'])) {
		($_POST['login']) ? $login = htmlspecialchars(trim($_POST['login'])) : '';
		($_POST['name']) ? $name = htmlspecialchars(trim($_POST['name'])) : '';
		($_POST['surname']) ? $surname = htmlspecialchars(trim($_POST['surname'])) : '';
		($_POST['age']) ? $age = intval(htmlspecialchars(trim($_POST['age']))) : '';
		($_POST['email']) ? $email = htmlspecialchars(trim($_POST['email'])) : '';
		($_POST['password']) ? $password = htmlspecialchars(trim($_POST['password'])) : '';
		
		$password = md5( $password . $login );
		
		$file = $_FILES['file']['name'];
		$tmp_name = $_FILES['file']['tmp_name'];
		($_POST['about']) ? $about = htmlspecialchars(trim($_POST['about'])) : '';
		//создаем ID для нового юзера, берем ID последнего и прибавляем 1
		$getIdUser = $db->query("SELECT `id` FROM `users` ORDER BY `id` DESC LIMIT 1");
		$getIdUser = $getIdUser->fetch();
		$getIdUser = intval($getIdUser['id']) + 1;
		$dir_user = "img/avatars/$getIdUser";
		if(!is_dir($dir_user)){
			mkdir($dir_user);
		}
		move_uploaded_file($tmp_name, "$dir_user/$file"); //перемещаем картинку в директорию пользователя
		$loginStmt = $db->prepare("INSERT INTO `users` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)");		 // добавляем данные о пользователе в БД
		$loginStmt->execute(array($login, $name, $surname, $age, $email, $password, $file, $about));
		
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