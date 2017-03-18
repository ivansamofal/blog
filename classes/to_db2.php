<?
class to_db2 {

    public function five_authors ($db) {
                   // $mysqli->query("SET names 'cp1251'");
                    //$mysqli->query("SET NAMES 'utf8'"); 
                    //mysql_set_charset( 'utf8' );
                   // $mysqli->query("SET CHARACTER SET 'utf8'");
                   // $mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");
                   /* $authors = $mysqli->query("SELECT count(`articles`.`id_author`), `articles`.`id_author`,  
						`users`.`name`, `users`.`surname`, `users`.`age` FROM `articles` JOIN `users` 
					ON `articles`.`id_author` = `users`.`id` GROUP BY `id_author` 
					ORDER BY count(`id_author`) DESC LIMIT 5;");*/
					$authors = $db->query("SELECT count(`articles`.`id_author`), `articles`.`id_author`,  
						`users`.`name`, `users`.`surname`, `users`.`age` FROM `articles` JOIN `users` 
					ON `articles`.`id_author` = `users`.`id` GROUP BY `articles`.`id_author` 
					ORDER BY count(`id_author`) DESC LIMIT 5;");
					

                    while($authors2 = $authors->fetch()) {
                        $auts['count'][] = $authors2['count(`articles`.`id_author`)'];
                        $auts['id'][] = $authors2['id_author'];
                        $auts['name'][] = $authors2['name'];
                        $auts['surname'][] = $authors2['surname'];
                        $auts['age'][] = $this->getYears($authors2['age']);
                    }
                return $auts;
    }

        public function most_read ($db) {
                 $result4 = $db->query("SELECT * FROM `articles` ORDER BY  `stat` DESC LIMIT 5");
                
                while ($row4 = $result4->fetch()) {
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

        public function comments ($db){
           
                $result_comm = $db->query("SELECT * FROM `comments` ORDER BY `id` DESC LIMIT 5");
                    while ($row5 = $result_comm->fetch()) {
                     ($row5['title'] . ' ' . $row5['text']) . '<br>';
                    $art3['text_comm'][] = $this->getDescriptionComment($row5['text_comm']);
                    $art3['time_comm'][] = $row5['time_comm'];
                    $art3['date_comm'][] = $row5['date_comm'];
                 }
                 return $art3;
        }

        public function pagination1 ($db) { //вывод всех новостей на главной 
                // количество записей, выводимых на странице
				//$stmt = $db->prepare('SELECT * FROM `articles` WHERE `id` = ? AND `count_like` = ?');
				//$stmt->execute(array(50, 0));
				//$rows = $stmt->fetchAll();
				//var_dump($rows);
                $per_page=10;
                // получаем номер страницы
                if (isset($_GET['page'])) $arr['page']=($_GET['page']-1); else $page=0;
                // вычисляем первый оператор для LIMIT
                $start=abs($arr['page']*$per_page);
                // составляем запрос и выводим записи
                // переменную $start используем, как нумератор записей.
                //$res = $mysqli->query("SELECT count(*) FROM `articles` JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` ");
				$res = $db->prepare('SELECT count(*) FROM `articles` JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` ');
				$res->execute();
                //$row2=$res->fetch_row();
				$row2 = $res->fetch();
				$total_rows=$row2[0];
				
                /*$arr['res'] = $mysqli->query("
				SELECT `articles`.`id`, `articles`.`title`, `articles`.`text`, `articles`.`time`, `articles`.`id_author`, 
					`articles`.`date`, `articles`.`img`, `articles`.`stat`, `articles`.`count_like`, `articles`.`category`, 
					`categories`.`alias_cat`, `articles`.`tags`, `categories`.`id_cat`, `users`.`name`, `users`.`surname`, 
					`categories`.`alias_cat`, `users`.`age`, `users`.`avatar`, `users`.`id` as `id_user` FROM `articles` 
				JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` 
				JOIN `users` ON `articles`.`id_author` = `users`.`id` 
				ORDER BY `articles`.`id` DESC LIMIT $start,$per_page");*/
				$arr['res'] = $db->query("SELECT `articles`.`id` as `idArt`, `articles`.`title`, `articles`.`text`, `articles`.`time`, `articles`.`id_author`, 
					`articles`.`date`, `articles`.`img`, `articles`.`stat`, `articles`.`count_like`, `articles`.`category`, 
					`categories`.`alias_cat`, `articles`.`tags`, `categories`.`id_cat`, `users`.`name`, `users`.`surname`, 
					`categories`.`alias_cat`, `users`.`age`, `users`.`avatar`, `users`.`id` as `id_user` FROM `articles` 
				JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` 
				JOIN `users` ON `articles`.`id_author` = `users`.`id` 
				ORDER BY `articles`.`id` DESC LIMIT $start, $per_page");
					//$stmt->bindParam(':start', $start);
					//$stmt->bindParam(':per_page', $per_page);
					//$stmt->execute(array('start' => $start, 'per_page' => $per_page));
				/*`articles`.`id`, `articles`.`title`, `articles`.`text`, `articles`.`time`, `articles`.`id_author`, 
					`articles`.`date`, `articles`.`img`, `articles`.`stat`, `articles`.`count_like`, `articles`.`category`, 
					`categories`.`alias_cat`, `articles`.`tags`, `categories`.`id_cat`, `users`.`name`, `users`.`surname`, 
					`categories`.`alias_cat`, `users`.`age`, `users`.`avatar`, `users`.`id` as `id_user` FROM `articles` 
				JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` 
				JOIN `users` ON `articles`.`id_author` = `users`.`id` 
				ORDER BY `articles`.`id` DESC LIMIT :start, :per_page*/

				//	$stmt->execute(array(0, 10));
				
				//	$arr['res']->execute(array());
				//var_dump($stmt);
				//var_dump($stmt->fetchAll());
				
				//var_dump($are);
				//
                $arr['num_pages'] = ceil($total_rows/$per_page);
				//var_dump($arr);
				
                return $arr;
        }
		
		public function paginationCategory($db, $cat) { //вывод всех новостей в категориях
                // количество записей, выводимых на странице
                $per_page=10;
                // получаем номер страницы
                if (isset($_GET['page'])) $arr['page']=($_GET['page']-1); else $page=0;
                // вычисляем первый оператор для LIMIT
                $start=abs($arr['page']*$per_page);
                // составляем запрос и выводим записи
                // переменную $start используем, как нумератор записей.
                $res = $db->prepare("SELECT count(*) FROM `articles` JOIN `categories` 
				ON `articles`.`category` = `categories`.`id_cat` AND `categories`.`alias_cat` = ?");
				$res->execute(array($cat));
                $row2=$res->fetch();
                $total_rows=$row2[0];
                $arr['res'] = $db->query("SELECT *, `users`.`id` as `id_user` FROM `articles` 
				JOIN `categories` ON `articles`.`category` = `categories`.`id_cat` 
				AND `categories`.`alias_cat` = '$cat' 
				JOIN `users` ON `articles`.`id_author` = `users`.`id` 
				ORDER BY `articles`.`id` DESC LIMIT $start,$per_page");
                $arr['num_pages'] = ceil($total_rows/$per_page);
                return $arr;
        }

        public function authorization ($db) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['login']) && !empty($_POST['password'])) {
			$enterLogin = htmlspecialchars(trim($_POST['login']));	
			$login = $db->prepare("SELECT * FROM `users` WHERE `email` = ?");
			$login->execute(array($enterLogin));
			$res = $login->fetch();
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



    public function create_article ($db) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['title']) && !empty($_POST['text'])) {
	$id = $_SESSION['id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $text = trim($_POST['text']);
    $author = intval(htmlspecialchars(trim($_POST['author'])));
    $date = date(Y . '-' . m .'-' . d);
    $time = date(G . ':' . i . ':' . s);
    
    
	$alias = htmlspecialchars(trim($_POST['alias']));
	$getCategs = $db->prepare("SELECT * FROM `categories`");
	$getCategs->execute();
	$tags = ($_POST['tags']) ? htmlspecialchars(trim($_POST['tags'])) : '';
	while($getRow = $getCategs->fetch()){
	if ($getRow['name'] === $_POST['category']){
		$idCat = intval($getRow['id_cat']);
	}
	}
	$category = $_POST['category'];
	
	
	if($_FILES['file']['name'] && mb_strlen($_FILES['file']['name']) > 3){
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
        //$mysqli->query("SET NAMES 'utf8'"); 
        //$mysqli->query("SET CHARACTER SET 'utf8'");
        //$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");
			$createArticle = $db->prepare("INSERT INTO `articles` VALUES (NULL, ?, ?, ?, ?, ?, ?, 0, 0, ?, ?, ?)");
			$createArticle->execute(array($title, $text, $author, $time, $date, $name_file, $alias, $idCat, $tags));
			
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