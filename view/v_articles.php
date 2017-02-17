<?
mb_internal_encoding("UTF-8");
(isset($_GET['cat'])) ? $cat = htmlspecialchars($mysqli->real_escape_string(trim($_GET['cat']))) : header("Location: index.php");
	$getIDCat = $mysqli->query("SELECT `id_cat`, `name` FROM `categories` WHERE `alias_cat` = '$cat'");
	$getIDCat = $getIDCat->fetch_assoc();
	$nameCat = $getIDCat['name'];
	$getIDCat = $getIDCat['id_cat'];
	$selectCats = $mysqli->query("SELECT * FROM `articles` WHERE `category` = '$getIDCat'");
	/*
	while($rowCat = $selectCats->fetch_assoc()){
		$arrCats['title'][] = $rowCat['title'];
		$arrCats['text'][] = $rowCat['text'];
		$arrCats['author'][] = $rowCat['id_author'];
		$arrCats['time'][] = $rowCat['time'];
		$arrCats['date'][] = $rowCat['date'];
		$arrCats['img'][] = $rowCat['img'];
		$arrCats['stat'][] = $rowCat['stat'];
		$arrCats['likes'][] = $rowCat['count_like'];
	}
	var_dump($arrCats);
	*/
include_once('view/header.php');
?>
<div id="templatemo_main">

	    <div id="templatemo_content">
            <? while ($row=$selectCats->fetch_assoc()):?>
				<div class="post_box">
				
					<h2><a href="article.php?id=<?=$row['id']?>"><?=$row['title']?></a></h2>		
					<div class="news_meta">Опубликовано: <a href="articles.php?cat=<?=$cat?>"><?=$nameCat?></a>, <?=$row['date']?> в <?=mb_substr($row['time'], 0, 5);?> | Теги: <a href="#">Blog</a>, <a href="#">Templates</a>, <a href="#">Design</a>, <a href="#">Free</a></div>
					<div class="image_wrapper"><a href="article.php?id=<?=$row['id']?>"><img src="img/<?=$row['img']?>" alt="<?=$row['title']?>" title="<?=$row['title']?>"/></a></div>
				  <p align="justify"><?=$obj1->getDescription($row['text'])?>
				  <a href="article.php?id=<?=$row['id']?>" class="continue">Продолжить ...</a></p>
				  <div class="cleaner"></div>
				</div>
			<? endwhile;?>
        </div>

	<? include('sidebar.php');?>
 <div style="clear: both;"></div>
</div>

<? 
include_once('view/footer.php');
?>