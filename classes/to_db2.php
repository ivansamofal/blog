<?
class to_db2 {

    public function five_authors ($mysqli) {
                    $mysqli->query("SET names 'cp1251'");
                    //$mysqli->query("SET NAMES 'utf8'"); 
                    //mysql_set_charset( 'utf8' );
                    $mysqli->query("SET CHARACTER SET 'utf8'");
                    $mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");
                    $authors = $mysqli->query("SELECT count(`articles`.`id_author`), `articles`.`id_author`,  `users`.`name`, `users`.`surname`, `users`.`age` FROM `articles` JOIN `users` ON `articles`.`id_author` = `users`.`id` GROUP BY `id_author` ORDER BY count(`id_author`) DESC LIMIT 5;");

                    while($authors2 = $authors->fetch_assoc()) {
                        $auts['count'][] = $authors2['count(`articles`.`id_author`)'];
                        $auts['id'][] = $authors2['id_author'];
                        $auts['name'][] = $authors2['name'];
                        $auts['surname'][] = $authors2['surname'];
                        $auts['age'][] = $this->getYears($authors2['age']);
                    }
                return $auts;
    }

        public function most_read ($mysqli) {
                 $result4 = $mysqli->query("SELECT * FROM `articles` ORDER BY  `stat` DESC LIMIT 5");
                
                while ($row4 = $result4->fetch_assoc()) {
                     ($row4['title'] . ' ' . $row4['text']) . '<br>';
                    $art2['titles'][] = $row4['title'];
                    $art2['stat'][] = $row4['stat'];
                    if (strlen($row4['text']) > 160) {
                     $art2['text'][] = mb_substr($row4['text'], 0, strpos(($row4['text']), ' ', 160)) . '... ';
                     strpos(($row4['text']), ' ', 100);
                 }else {
                    $art2['text'][] = $row4['text'];
                 }
                     $art2['img'][] = $row4['img']; 
                     $art2['date'][] = $row4['date'];
                     $art2['time'][] = $row4['time'];
                     $art2['id'][] = $row4['id'];
                }
                $art2['readmore'] = ' Читать далее>>';
                return $art2;
        }

        public function comments ($mysqli){
           
                $result_comm = $mysqli->query("SELECT * FROM `comments` ORDER BY id DESC LIMIT 5");
                    while ($row5 = $result_comm->fetch_assoc()) {
                     ($row5['title'] . ' ' . $row5['text']) . '<br>';
                    $art3['text_comm'][] = $this->getDescriptionComment($row5['text_comm']);
                    $art3['time_comm'][] = $row5['time_comm'];
                    $art3['date_comm'][] = $row5['date_comm'];
                 }
                 return $art3;
        }

        public function pagination1 ($mysqli) { //вывод всех новостей на главной 
                // количество записей, выводимых на странице
                $per_page=10;
                // получаем номер страницы
                if (isset($_GET['page'])) $arr['page']=($_GET['page']-1); else $page=0;
                // вычисляем первый оператор для LIMIT
                $start=abs($arr['page']*$per_page);
                // составляем запрос и выводим записи
                // переменную $start используем, как нумератор записей.
                $res = $mysqli->query("SELECT count(*) FROM `articles` JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` ");
                $row2=$res->fetch_row();
                $total_rows=$row2[0];
                $arr['res'] = $mysqli->query("SELECT `articles`.`id`, `articles`.`title`, `articles`.`text`, `articles`.`time`, `articles`.`id_author`, `articles`.`date`, `articles`.`img`, `articles`.`stat`, `articles`.`count_like`, `articles`.`category`, `categories`.`alias_cat`, `articles`.`tags`, `categories`.`id_cat`, `users`.`name`, `users`.`surname`, `categories`.`alias_cat`, `users`.`age`, `users`.`avatar`, `users`.`id` as `id_user` FROM `articles` JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` JOIN `users` ON `articles`.`id_author` = `users`.`id` ORDER BY `articles`.`id` DESC LIMIT $start,$per_page");
                $arr['num_pages'] = ceil($total_rows/$per_page);
                return $arr;
        }
		
		public function paginationCategory($mysqli, $cat) { //вывод всех новостей в категориях
                // количество записей, выводимых на странице
                $per_page=10;
                // получаем номер страницы
                if (isset($_GET['page'])) $arr['page']=($_GET['page']-1); else $page=0;
                // вычисляем первый оператор для LIMIT
                $start=abs($arr['page']*$per_page);
                // составляем запрос и выводим записи
                // переменную $start используем, как нумератор записей.
                $res = $mysqli->query("SELECT count(*) FROM `articles` JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` AND `categories`.`alias_cat` = '$cat'");
                $row2=$res->fetch_row();
                $total_rows=$row2[0];
                $arr['res'] = $mysqli->query("SELECT *, `users`.`id` as `id_user` FROM `articles` JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` AND `categories`.`alias_cat` = '$cat' JOIN `users` ON `articles`.`id_author` = `users`.`id` ORDER BY `articles`.`id` DESC LIMIT $start,$per_page");
                $arr['num_pages'] = ceil($total_rows/$per_page);
                return $arr;
        }

        public function authorization ($mysqli) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['login']) && !empty($_POST['password'])) {
			$enterLogin = htmlspecialchars(trim($_POST['login']));
            //$login = $mysqli->query("SELECT * FROM `users` WHERE `email` = '{$_POST['login']}';");		
			$login = $mysqli->prepare("SELECT * FROM `users` WHERE `email` = ?");
			$login->bind_param("s", $enterLogin);
			$login->execute();
			$result = $login->get_result();
			$res = $result->fetch_assoc();
			//var_dump($res);
            if ($res['email'] != $_POST['login'] || $res['password'] != $_POST['password']) {
                if ($res['email'] == $_POST['login']) {
                    $_SESSION['msg'] = 'неправильный пароль';
                }elseif ($res['email'] != $_POST['login']) {
                    $_SESSION['msg'] = 'неправильный логин';
                }
                
            }else {
                $_SESSION['msg'] = " вы авторизованы, {$res['name']}!!";
                $_SESSION['name'] = $res['name'];
                $_SESSION['login'] = $res['login'];
                $_SESSION['id'] = $res['id'];
                header("Location: index.php");
            }
            }
    }



    public function create_article ($mysqli) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['title']) && !empty($_POST['text'])) {

    $title = $mysqli->real_escape_string(htmlspecialchars(trim($_POST['title'])));
    $text = $mysqli->real_escape_string(trim($_POST['text']));
    $author = $mysqli->real_escape_string(htmlspecialchars(trim($_POST['author'])));
    $date = date(Y . '-' . m .'-' . d);
    $time = date(G . ':' . i . ':' . s);
    
    
	$alias = $mysqli->real_escape_string(htmlspecialchars(trim($_POST['alias'])));
	$getCategs = $mysqli->query("SELECT * FROM `categories`");
	$tags = ($_POST['tags']) ? $mysqli->real_escape_string(htmlspecialchars(trim($_POST['tags']))) : '';
	while($getRow = $getCategs->fetch_assoc()){
	if ($getRow['name'] === $_POST['category']){
		$idCat = $getRow['id_cat'];
	}
	}
	$category = $_POST['category'];
//header("Location: index.php");
	if($name_file && mb_strlen($name_file) > 3){
	$name_file = 'post_' . $id . '_' . trim(mb_strtolower($_FILES['file']['name']));
	$tmp_name = $_FILES['file']['tmp_name'];
	$image = new SimpleImage();
    move_uploaded_file($tmp_name, "img/$name_file");
	//$image->load("img/$name_file");
	//$image->resize(600, 200);
	//$image->save("img/index_$name_file");
	$image->load("img/$name_file");
	$image->resize(600, 400);
	$image->save("img/original_$name_file");
	$image->load("img/$name_file");
	$image->resize(60, 40);
	$image->save("img/avatars/{$_SESSION['id']}/mini_$name_file");
    }
    if(!empty($_POST['title']) && !empty($_POST['text'])) {
        $mysqli->query("SET NAMES 'utf8'"); 
        $mysqli->query("SET CHARACTER SET 'utf8'");
        $mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");
			$createArticle = $mysqli->prepare("INSERT INTO `articles` VALUES (NULL, ?, ?, ?, ?, ?, ?, 0, 0, ?, ?, ?)");
			$createArticle->bind_param("sssssssss", $title, $text, $author, $time, $date, $name_file, $alias, $idCat, $tags);
			$createArticle->execute();
			$result = $createArticle->get_result();
			
		//$result = $mysqli->query("INSERT INTO `articles` VALUES (NULL, '$title', '$text', '$author', '$time', '$date', '$name_file', '0', '0', '$alias', '$idCat');");
		
        header("Location: index.php");
}
}

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['title'])) {
        $er = 'Введите название для статьи!';
    }elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST['text'])) {
        $er2 = 'Введите текст для статьи!';
    }

    if (!empty($_GET['id'])) {
        header("Location: create.php");
    }
    }

    public function logout() {
        session_destroy();
        unset($_SESSION);
    }
	
	public function getDescription($text){
		return mb_substr($text, 0, 250);
	}
	public function getDescriptionComment($text){
		if (mb_strlen($text) > 250){
			return mb_substr($text, 0, 250) . '...';
		}else{
			return $text;
		}
	}
	public function getYears($year){
		if($year[count($year)-1] > 4 && $year[mb_strlen($year)-1] < 10 || $year[mb_strlen($year)-1] == 0){
			return $year . ' лет';
		}elseif($year[mb_strlen($year)-1] == 1){
			return $year . ' год';
		}else{
			return $year . ' года';
		}
	}
	
		public function getCommentsNames($comment){
			$lastSymbol = mb_substr($comment, -1); 
		if($lastSymbol > 4 && $lastSymbol < 10 || $lastSymbol == 0 || $comment == 11 || $comment == 12 || $comment == 13 || $comment == 14){
			return $comment . ' комментариев';
		}elseif($lastSymbol == 1){
			return $comment . ' комментарий';
		}else{
			return $comment . ' комментария';
		}
	}

}