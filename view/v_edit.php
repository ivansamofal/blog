<?
include_once('header.php');
$getCategs = $mysqli->query("SELECT * FROM `categories`");
?>

<div id="templatemo_main">

	    <div id="templatemo_content">
<? if ($author_con == $_SESSION['id']): ?>
<div class="block">
<h1><?=$_SESSION['name']?>, Вы автор статьи и можете редактировать ее в блоге</h1>
<form enctype="multipart/form-data" method="post" action="#" class="create-form update-form">
<input class="title-create" type="text" placeholder="enter title" name="title" value="<?=$title_con?>">
<select name="category">
	<? $arrCat = array();?>
	<?while($getRow = $getCategs->fetch_assoc()):?>
	<?if($getNameCat == $getRow['name']):?>
	<option><?=$getRow['name']?></option>
	<?else:?>
	<? array_push($arrCat, $getRow['name']);?>
	<?endif;?>
	<?endwhile;?>
	<?foreach($arrCat as $key => $value):?>
		<option><?=$value?></option>
	<?endforeach;?>
</select>

<textarea class="text-create" class="edit" placeholder="enter text" name="text"><?=$text_con?></textarea>
<input type="hidden" placeholder="enter author" name="author" value="<?=$author_con?>">

<input type="file" name="file">
<input type="submit" value="Сохранить" class="create-submit">
</form>
<p>Картинка к посту:</p>
<img class="img-edit" src="img/<?=$img?>" alt="">
<a href="article.php?id=<?=$id?>">Просмотр</a>
</div>

<?else:?>
<h2><?=$_SESSION['name']?>, Вы не являетесь автором статьи и не можете ее редактировать(</h2>
<h1><?=$title_con?></h1>
<p><?=$text_con?></p>

<? endif;?>
</div>
<? include('sidebar.php');?>

 <div style="clear: both;"></div>
</div>

<? 
include_once('footer.php');
?>