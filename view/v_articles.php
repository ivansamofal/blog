<?
include_once('view/header.php');
?>
<div id="templatemo_main">
	    <div id="templatemo_content">
            <? while ($row=$arr['res']->fetch()):?>
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
					<span>автор: <a href="user.php?id=<?=$row['id_user']?>"><?=$row['name'] . ' ' . $row['surname']?></a></span>
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
 <?if ($arr['num_pages'] > 1):?>
 <div class="pagination">
			<?
			for($i=1;$i<=$arr['num_pages'];$i++) {
			  if ($i-1 == $arr['page']) {
				echo '<span>' . $i. ' </span>';
			  } else {
				echo '<a href="'.$_SERVER["REQUEST_URI"].'&page='.$i.'">'.$i."</a> ";
			  }
			}
			?>
</div>
<? endif;?>	
</div>

<? 
include_once('view/footer.php');
?>