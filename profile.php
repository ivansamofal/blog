<?
include_once('config.php');

mb_internal_encoding("UTF-8");
(isset($_SESSION['id'])) ? $id = htmlspecialchars($mysqli->real_escape_string($_SESSION['id'])) : header("Location: index.php");

if(isset($_POST['submit'])){
	if (isset($_POST['name'])){
		$name = htmlspecialchars($mysqli->real_escape_string($_POST['name']));
		$_SESSION['name'] = $name;
		//$id = htmlspecialchars($mysqli->real_escape_string($_SESSION['id']));
		$newName = $mysqli->query("UPDATE `users` SET `name` = '$name' WHERE `id` = '$id'");
	}
	if (isset($_POST['surname'])){
		$surname = htmlspecialchars($mysqli->real_escape_string($_POST['surname']));
		//$id = htmlspecialchars($mysqli->real_escape_string($_SESSION['id']));
		$newName = $mysqli->query("UPDATE `users` SET `surname` = '$surname' WHERE `id` = '$id'");
	}
	if (isset($_POST['age'])){
		$age = htmlspecialchars($mysqli->real_escape_string($_POST['age']));
		//$id = htmlspecialchars($mysqli->real_escape_string($_SESSION['id']));
		$newName = $mysqli->query("UPDATE `users` SET `age` = '$age' WHERE `id` = '$id'");
	}
	if (isset($_POST['about'])){
		$about = htmlspecialchars($mysqli->real_escape_string($_POST['about']));
		//$id = htmlspecialchars($mysqli->real_escape_string($_SESSION['id']));
		$newName = $mysqli->query("UPDATE `users` SET `about` = '$about' WHERE `id` = '$id'");
	}
	if (isset($_POST['email'])){
		$email = htmlspecialchars($mysqli->real_escape_string($_POST['email']));
		//$id = htmlspecialchars($mysqli->real_escape_string($_SESSION['id']));
		$newName = $mysqli->query("UPDATE `users` SET `email` = '$email' WHERE `id` = '$id'");
	}
	if (isset($_POST['password'])){
		$password = htmlspecialchars($mysqli->real_escape_string($_POST['password']));
		//$id = htmlspecialchars($mysqli->real_escape_string($_SESSION['id']));
		$newName = $mysqli->query("UPDATE `users` SET `password` = '$password' WHERE `id` = '$id'");
	}
	if (isset($_FILES['file']['name']) && mb_strlen($_FILES['file']['name']) > 4 ){
		//$id = htmlspecialchars($mysqli->real_escape_string($_SESSION['id']));
		$file_name = $_FILES['file']['name'];
		if (mb_substr_count($file_name, ' ') > 0){ //если в названии файла имеются пробелы, меняем на '_'
			$file_name = explode(' ', $file_name);
			$file_name = implode('_', $file_name);
		}
		$tmp_name = $_FILES['file']['tmp_name'];
		if (!is_dir("img/avatars/$id")){
			mkdir("img/avatars/$id");
		}
		move_uploaded_file($tmp_name, "img/avatars/$id/$file_name");
		$newName = $mysqli->query("UPDATE `users` SET `avatar` = '$file_name' WHERE `id` = '$id'");
	}
	header("Location: profile.php");
}

include_once('view/header.php');
//достаем данные юзера
$getMyProfile = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$id'");
$resultMyProfile = $getMyProfile->fetch_assoc();

//достаем список статей юзера
$getMyProfile = $mysqli->query("SELECT * FROM `articles` WHERE `id_author` = '$id'");
while($resultProfile = $getMyProfile->fetch_assoc()){
	$arrArticles['id'][] = $resultProfile['id'];
	$arrArticles['title'][] = $resultProfile['title'];
	$arrArticles['text'][] = $resultProfile['text'];
	$arrArticles['time'][] = $resultProfile['time'];
	$arrArticles['date'][] = $resultProfile['date'];
	$arrArticles['img'][] = $resultProfile['img'];
	$arrArticles['stat'][] = $resultProfile['stat'];
	$arrArticles['like'][] = $resultProfile['count_like'];
	$arrArticles['avatar'][] = $resultProfile['avatar'];
}
//var_dump($arrArticles);

$getMyArticles = $mysqli->query("SELECT * FROM `articles` WHERE `id_author` = '$id'");
$resultArticles = $getMyArticles->fetch_assoc();
//var_dump($resultArticles);

$getMyComments = $mysqli->query("SELECT * FROM `comments`  JOIN `articles`  ON `comments`.`id_article` = `articles`.`id` AND `articles`.`id_author` = '$id'");

while($rowComment = $getMyComments->fetch_assoc()){
	$Comments['text'][] = $rowComment['text_comm'];
	$Comments['date'][] = $rowComment['date_comm'];
	$Comments['time'][] = $rowComment['time_comm'];
	$Comments['time'][] = $rowComment['time_comm'];
	$Comments['title'][] = $rowComment['title'];
	$Comments['id_article'][] = $rowComment['id_article'];
}
//var_dump($Comments);


/*
function translit($prev){
	for($i = 0; $i < mb_strlen($prev); $i++){
	switch(mb_strtolower(mb_substr($prev, $i, 1))){
		case 'а': $a = 'a';		
		break;
		case 'б': $a = 'b';
		break;
		case 'в': $a = 'v';
		break;
		case 'г': $a = 'g';
		break;
		case 'д': $a = 'd';
		break;
		case 'е': $a = 'e';
		break;
		case 'э': $a = 'e';
		break;
		case 'ж': $a = 'zh';
		break;
		case 'з': $a = 'z';
		break;
		case 'и': $a = 'i';
		break;
		case 'й': $a = 'y';
		break;
		case 'к': $a = 'k';
		break;
		case 'л': $a = 'l';
		break;
		case 'м': $a = 'm';
		break;
		case 'н': $a = 'n';
		break;
		case 'о': $a = 'o';
		break;
		case 'п': $a = 'p';
		break;
		case 'р': $a = 'r';
		break;
		case 'с': $a = 's';
		break;
		case 'т': $a = 't';
		break;
		case 'у': $a = 'u';
		break;
		case 'ф': $a = 'f';
		break;
		case 'х': $a = 'h';
		break;
		case 'ц': $a = 'ts';
		break;
		case 'ч': $a = 'ch';
		break;
		case 'ш': $a = 'sh';
		break;
		case 'щ': $a = 'sch';
		break;
		case 'ю': $a = 'u';
		break;
		case 'я': $a = 'ya';
		break;
		case 'ь': $a = "";
		break;
		case 'ъ': $a = "";
		break;
		case 'ё': $a = "e";
		break;
		case ' ': $a = "_";
		break;
		case 'ы': $a = "y";
		break;
	}
	$word .= $a;
	}
	return $word;
}
$b = 'это новая статья';
*/

?>
<div id="templatemo_main">
	<div class="article" id="lcnt">
<? //echo "я вижу вас, {$_SESSION['name']}";
?>
<div class="block oneProfile">
<h1>Профиль пользователя <?=$_SESSION['name']?></h1>
<form enctype="multipart/form-data" method="post" action="#">
<input type="text" name="login" disabled="disabled" value="<?=$resultMyProfile['login']?>">
<input type="text" placeholder="enter email" name="email" value="<?=$resultMyProfile['email']?>">
<input type="text" placeholder="enter password" name="password" value="<?=$resultMyProfile['password']?>">
<input type="text" placeholder="enter name" name="name" value="<?=$resultMyProfile['name']?>">
<input type="text" placeholder="enter surname" name="surname" value="<?=$resultMyProfile['surname']?>">
<input type="text" placeholder="enter age" name="age" value="<?=$resultMyProfile['age']?>">

<textarea placeholder="about me" name="about"><?=$resultMyProfile['about']?></textarea>
<p><span><?=$er2?></span></p>
<input type="hidden" placeholder="enter author" value="<?=$_SESSION['id']?>" name="author">
<input type="file" name="file">
<input type="submit" name="submit" value="Отправить">
</form>
<?if($resultMyProfile['avatar']):?>
<h2>Ваш аватар:</h2>
<img src="img/avatars/<?=$resultMyProfile['id']?>/<?=$resultMyProfile['avatar']?>" alt="<?=$resultMyProfile['login']?>" width="500px">
<?endif;?>
</div>
<div class="mainProfile">
	<div class="articlesProfile">
	<? if(count($arrArticles['title']) > 0):?>
		<h2>Вы являетесь автором <?=count($arrArticles['title'])?> статей.</h2>
		<ul>
		<? for($i = 0; $i < count($arrArticles['title']); $i++):?>
			<li class="oneArticleList"><a href="article.php?id=<?=$arrArticles['id'][$i]?>"><?=$arrArticles['title'][$i]?></a></li>
		<?endfor;?>
		</ul>
	<?else:?>
		<h2>У вас пока нет постов. Вы можете создать свой первый пост на <a href="create.php">странице создания статьи</a>.</h2>
	<?endif;?>
	</div>
	<div class="commentsProfile">
		<? if(count($Comments['text']) > 0):?>
			<h2>Вы написали <?=count($Comments['text'])?> комментариев</h2>
				<ul>
				<? for($i = 0; $i < count($Comments['text']); $i++):?>
					<li class="oneCommentProfile"><?=$Comments['text'][$i]?> <span><?=$Comments['date'][$i]?></span> в <span><?=mb_substr($Comments['time'][$i], 0, 5)?></span>
					к статье <a href="article.php?id=<?=$Comments['id_article'][$i]?>"><?=$Comments['title'][$i]?></a></li>
				<?endfor;?>
				</ul>
		<?else:?>
			<h2>Вы пока не оставляли комментарии:(</h2>
		<?endif;?>
	</div>
</div>
</div>
	<? include('view/sidebar.php');?>
<div style="clear: both;"></div>
</div>

<? 
include_once('view/footer.php');
?>