<?
include_once('/view/header.php');
?>
<div id="templatemo_main">
    <div id="templatemo_content">
	<div class="userProfile">
		<h2>Профиль пользователя <?=$getUser['name'] . ' ' . $getUser['surname']?></h2>
			<img src="img/avatars/<?=$id?>/<?=$getUser['avatar']?>" class="userImg" alt="<?=$getUser['name'] . ' ' . $getUser['surname']?>">
			<h3><?=$getUser['name'] . ' ' . $getUser['surname']?>, <?=$getUser['age']?></h3>
			<div><h4>Немного о себе: </h4><p><?=$getUser['about']?></p></div>
		</div>
		 
	</div>
<? include('view/sidebar.php');?>
<div class="cleaner"></div>
</div>
<?
include_once('/view/footer.php');