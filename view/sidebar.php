<?
   /* \sidebar */
$art2 = $obj1->most_read($mysqli);
//вывод комментариев
    $art3 = $obj1->comments($mysqli);
/*ВЫВОД 5 самых активных авторов */
 $aut = $obj1->five_authors($mysqli);
/*/ВЫВОД 5 самых активных авторов */

    /* end of sidebar */
?>

<div id="templatemo_sidebar">
        
        	<!--<div id="aboutus">
            	<h3>About Design Blog</h3>
                <div class="image_fl"><img src="images/templatemo_about.jpg" alt="about this blog" /></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras volutpat aliquet risus, a ornare orci scelerisque et. <a href="#" class="continue">more...</a></p>
          </div>-->
            
            <div class="cleaner_h20"></div>
            
            <div class="sidebar_box profileBlock">
                
                <? if (!isset($_SESSION['id'])): ?>
					<div class="autor">
						<h3><span>Введите свои данные или <a href="register.php">зарегистрируйтесь</a></span></h3>
						<!--<p style="color: red;"><?=$_SESSION['msg']?></p>-->
						<form method="post" action="#">
							<input type="text" placeholder="enter login" name="login">
							<input type="password" placeholder="enter password" name="password">
							<input type="submit" placeholder="enter">
						</form>
					</div>
				<? endif;?>
				<? if (isset($_SESSION['id'])): ?>
					<div class="out">
						<?if($_SESSION['name']):?>
						<h3><span>Привет, <?=$_SESSION['name']?></span></h3>
						<?else:?>
						<h3>Привет, Друг!</h3>
						<?endif;?>
						<ul>
							<li><a href="create.php">Создать статью</a></li>
							<li><a href="profile.php">Профиль</a></li>
						</ul>
						<form action="#" method="post">
							<input type="submit" value="Выйти" name="out">
						</form>
					</div>
				<? endif;?>
                
            </div>
            
		<div class="bestPosts">
		<h3>Популярные посты:</h3>
			<?	for ($k = 0; $k <count($art2['titles']); $k++):?>

            <div class="sidebar_box">
            	<a href="article.php?id=<?=$art2['id'][$k]?>"><h3><?=$art2['titles'][$k]?></h3></a>
                
                <p><a href="article.php?id=<?=$art2['id'][$k]?>"><img class="art-img" src="img/<?=$art2['img'][$k]?>" alt=""></a> <?=$art2['text'][$k]?><a href="article.php?id=<?=$art2['id'][$k]?>"><?=$art2['readmore']?></a></p>
				<h5><?=$art2['time'][$k]?> <?=$art2['date'][$k]?></h5>
				<p><?=$art2['stat'][$k] . ' ' .$years->count_views($art2['stat'][$k])?></p>
                
          </div>
		  
		  <? endfor;?>
        </div>    
        <div class="commentsAll">  
            <div class="sidebar_box">
            	<h3>Комментарии:</h3>
                <? for ($s = 0; $s <count($art3['text_comm']); $s++): ?>
					<div class="comment-side">
						<p><?=$art3['text_comm'][$s]?></p>
						<h5><?=$art3['time_comm'][$s]?> <?=$art3['date_comm'][$s]?></h5>
					</div>
				<? endfor; ?>
                
                <div class="cleaner"></div>
            </div>
		</div>
            
          	<div class="sidebar_box">
            <h3>Активные юзеры:</h3>
            	<? for($p=0; $p <count( $aut['id']); $p++):?>

						<h3 class="list-h3"><?=$aut['name'][$p] . ' ' . $aut['surname'][$p] . ', ' . $aut['age'][$p] . ' - ' . $aut['count'][$p];?> статей</h3>

				<?endfor;?>
            </div>
        
</div>