<?
include_once('header.php');
?>
<div id="templatemo_main">
    	
        <div id="templatemo_content">
			<?if($messageDelete):?>
			<div class="messageDel">
				<span><?=$messageDelete?></span>
			</div>
			<script>
				jQuery('.messageDel').fadeOut(5500);
			</script>
			<? $messageDelete = null;
				unset($_GET['param']);
			?>
			<?endif;?>
            <? while ($row=$arr['res']->fetch_array()):?>
				<div class="post_box">
					<? $textTags = explode(',', $row['tags']);?>
					<? $imagePost = ($row['img']) ? $row['img'] : 'no-photo.jpg'; ?>
					<h2><a href="article.php?id=<?=$row['id']?>"><?=$row['title']?></a></h2>		
					<div class="news_meta">Опубликовано: <a href="articles.php?cat=<?=$row['alias_cat']?>"><?=$row['name']?></a>, <?=$row['date']?> в <?=mb_substr($row['time'], 0, 5);?> 
					
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

		<?if ($arr['num_pages'] > 1):?>
 <div class="pagination">
			<?
			for($i=1;$i<=$arr['num_pages'];$i++) {
			  if ($i-1 == $arr['page']) {
				echo '<span>' . $i. ' </span>';
			  } else {
				echo '<a href="'.$_SERVER["PHP_SELF"].'?page='.$i.'">'.$i."</a> ";
			  }
			}
			?>
</div>
<? endif;?>	
    
    	<div class="cleaner"></div>
    </div>
	
<? 
include_once('footer.php');
?>