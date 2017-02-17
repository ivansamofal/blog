<?
include_once('header.php');
$getCategs = $mysqli->query("SELECT * FROM `categories`");
?>

<div id="templatemo_main">
	    <div id="templatemo_content">
		
<div class="block">
<h1>Добавление новой статьи в блог</h1>
<form enctype="multipart/form-data" method="post" action="#">
<input type="text" placeholder="enter title" name="title" class="titleArt"><span><?=$er?></span>
<input type="text" placeholder="enter alias" name="alias" value="" class="aliasArt"><span></span>
<select name="category">
	<?while($getRow = $getCategs->fetch_assoc()):?>
	<option><?=$getRow['name']?></option>
	<?endwhile;?>
</select>
<textarea placeholder="enter text" name="text"></textarea>
<p><span><?=$er2?></span></p>
<input type="hidden" placeholder="enter author" value="<?=$_SESSION['id']?>" name="author">
<input type="submit" value="enter" class="buttonClick">
<input type="file" name="file">
</form>
</div>

        </div>

	<? include('sidebar.php');?>
 <div style="clear: both;"></div>
</div>

<script>
jQuery( document ).ready(function() {


//var title = 'Первая строка';

function translit(){
	var a = '', word = '';
	var title = jQuery('.titleArt').val();
	console.log(title);
	var titleArr = title.split('');
	console.log(titleArr);
	for(var i = 0; i < titleArr.length; i++){
	switch(titleArr[i].toLowerCase()){
		case 'а': a = 'a';		
		break;
		case 'б': a = 'b';
		break
		case 'в': a = 'v';
		break;
		case 'г': a = 'g';
		break;
		case 'д': a = 'd';
		break;
		case 'е': a = 'e';
		break;
		case 'э': a = 'e';
		break;
		case 'ж': a = 'zh';
		break;
		case 'з': a = 'z';
		break;
		case 'и': a = 'i';
		break;
		case 'й': a = 'y';
		break;
		case 'к': a = 'k';
		break;
		case 'л': a = 'l';
		break;
		case 'м': a = 'm';
		break;
		case 'н': a = 'n';
		break;
		case 'о': a = 'o';
		break;
		case 'п': a = 'p';
		break;
		case 'р': a = 'r';
		break;
		case 'с': a = 's';
		break;
		case 'т': a = 't';
		break;
		case 'у': a = 'u';
		break;
		case 'ф': a = 'f';
		break;
		case 'х': a = 'h';
		break;
		case 'ц': a = 'ts';
		break;
		case 'ч': a = 'ch';
		break;
		case 'ш': a = 'sh';
		break;
		case 'щ': a = 'sch';
		break;
		case 'ю': a = 'u';
		break;
		case 'я': a = 'ya';
		break;
		case 'ь': a = "";
		break;
		case 'ъ': a = "";
		break;
		case 'ё': a = "e";
		break;
		case ' ': a = "_";
		break;
		case 'ы': a = "y";
		break;
	}
	word += a;
}
	console.log(word);
	jQuery('.aliasArt').val('');
	jQuery('.aliasArt').val(word);
	return word;
}

jQuery('.titleArt').change(function(){
	translit();
});
});
</script>

<script>
$(document).ready(function() {
    jQuery('.buttonClick').bind("click", function() {
        var link = $(this);
        var id = <?=$_SESSION['id']?>;
        var alias = jQuery('.aliasArt').val();
        
        jQuery.ajax({
            url: "alias.php",
            type: "POST",
            data: {id:id, alias:alias}, // Передаем ID нашей статьи
            dataType: "json",
            success: function(result) {
                if (!result.error){ //если на сервере не произойло ошибки то обновляем количество лайков на странице
                    //link.addClass('active'); 
                    // помечаем лайк как "понравившийся"
                    //$('.counter',link).html(result.count);
					
                }else{
                    alert(result.message);
                }
            }
        });
    });
});
</script>
<? 
include_once('footer.php');
?>