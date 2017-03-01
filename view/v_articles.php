<?
mb_internal_encoding("UTF-8");
//для статей конкретной категории
(isset($_GET['cat'])) ? $cat = htmlspecialchars($mysqli->real_escape_string(trim($_GET['cat']))) : "";
if($_GET['cat']){
	$getIDCat = $mysqli->query("SELECT `id_cat`, `name` FROM `categories` WHERE `alias_cat` = '$cat'");
	$getIDCat = $getIDCat->fetch_assoc();
	$nameCat = $getIDCat['name'];
	$getIDCat = $getIDCat['id_cat'];
	$selectCats = $mysqli->query("SELECT * FROM `articles` WHERE `category` = '$getIDCat'");
}
//для результатов поиска
if($_GET['query']){
		$searchQuery = ($_GET['query']) ? '%' . $mysqli->real_escape_string(trim($_GET['query'])) . '%' : '';
		$getSearch = $mysqli->prepare("SELECT * FROM `articles` WHERE `title` LIKE ? OR `text` LIKE ?");
		$getSearch->bind_param("ss", $searchQuery, $searchQuery);
		$getSearch->execute();
		$getSearch = $getSearch->get_result();
		$selectCats = $getSearch;
		}
include_once('view/header.php');
?>
<div id="templatemo_main">

	    <div id="templatemo_content">
            <? while ($row=$selectCats->fetch_assoc()):?>
			<? $textTags = explode(',', $row['tags']);?>
				<div class="post_box">
					<? $imagePost = ($row['img']) ? $row['img'] : 'no-photo.jpg'; ?>
					<h2><a href="article.php?id=<?=$row['id']?>"><?=$row['title']?></a></h2>		
					<div class="news_meta">Опубликовано: <a href="articles.php?cat=<?=$cat?>"><?=$nameCat?></a>, <?=$row['date']?> в <?=mb_substr($row['time'], 0, 5);?> 
					<?if(count($textTags) > 1):?>
					| Теги: 
					<? foreach($textTags as $tag):?>
					<a href="articles.php?query=<?=trim($tag)?>"><?=trim($tag)?></a>
					<?endforeach;?>
					<?else:?>
					| Нет тегов к данной статье:(
					<?endif;?>
					</div>
					<div class="image_wrapper"><a href="article.php?id=<?=$row['id']?>"><img src="img/<?=$imagePost?>" alt="<?=$row['title']?>" title="<?=$row['title']?>"/></a></div>
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