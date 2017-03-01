<?
include_once('header.php');
?>

<div id="templatemo_main">
<div id="lcnt">

				<div class="post">
					<div class="post_inf">
						<span><?=$row['date']?> в <?=mb_substr($row['time'], 0, 5)?></span><br />
						<span class="posn"><?=$row['name']?></span><br />
						<span class="posc"><?=$obj1->getCommentsNames(count($comm['text_comm']))?></span>

					</div>
					<h1><?=$row['title']?></h1>
					<? $image = ($row['img']) ? $row['img'] : 'no-photo.jpg'; ?>
					<img src="img/<?=$image?>" alt="<?=$row['title']?>" title="<?=$row['title']?>"/>
					<p><?=$row['text']?></p>
					<?
					$idArticle = $mysqli->real_escape_string(trim($_GET['id']));
					//$getUserId = $mysqli->query("SELECT `id_author` FROM `articles` WHERE `id` = '$idArticle'");
					//$getUserId = $getUserId->fetch_assoc();
					
						$getUserId = $mysqli->prepare("SELECT `id_author` FROM `articles` WHERE `id` = ?");
						$getUserId->bind_param("s", $idArticle);
						$getUserId->execute();
						$getUserId = $getUserId->get_result();
						$getUserId = $getUserId->fetch_assoc();
			
					$getUserId = $getUserId['id_author'];
					?>
					<?if($getUserId == $_SESSION['id']):?>
					<p><a href="update.php?id=<?=$id?>">Редактировать</a>    <a href="delete.php?id=<?=$id?>">Удалить</a></p>
					<?endif;?>
					<div class="like <?if($isActive) echo 'active'; ?>" data-id="<?=$id?>" data-usr="<?=$_SESSION['id']?>"><span class="counter"><?=$row['count_like']?></span>  
					</div>
					<div class="hits"><span><?=$row['stat']?></span> просмотров</div>
					<? if (count($url['foto']) > 0 ):?>
					<div class="fotos">
					<div id="fancy">
					<? for($f = 0; $f < count($url['foto']); $f++): ?>
					<?if($url['foto'][$f]):?>
					<a href="img/<?=$url['foto'][$f]?>"><img src="img/<?=$url['foto'][$f]?>" alt="<?=$row['title']?>"></a>
					<?endif;?>
					<? endfor; ?>
					</div>
					<p class="left-right">
					<img  class="left-img" src="img/left.png" alt=""><img class="right-img" src="img/right.png" alt="">
					</p>
					</div>
					<?endif;?>
				</div>
				<? if (count($comm['text_comm']) > 0):?>
				<h2 class="buttonComments" rel="0">
					<?=$obj1->getCommentsNames(count($comm['text_comm']))?>
				</h2>
				
				<div class="comments">
			
					<!-- Comment -->
					<? for ($i = 0; $i < count($comm['text_comm']); $i++):?>
					<div class="comment">
						<div class="comm_hdr">
							<p><?=$i+1?>. <?=$authors['name'][$i] . ' ' . $authors['surname'][$i] . ', ' . $authors['age'][$i] . ' ' . $years->years($authors['age'][$i][1]);?> <span> | <?=$comm['date_comm'][$i]?> в <?=mb_substr($comm['time_comm'][$i], 0, 5)?></span></p>
						</div>

						<div class="avat">
							<img src="img/avatars/<?=$authors['id'][$i]?>/<?=$authors['avatar'][$i]?>" alt="avatar" />
						</div>
					
						<p class="comm_txt">
							<?=$comm['text_comm'][$i]?>
						</p>

					</div>
					<? endfor; ?>
				</div>
				<? endif;?>
				<? if($_SESSION['id']):?>
				<div data-ids="<?=$id?>" data-usrc="<?=$_SESSION['id']?>" data-msg="<?=$_SESSION['serv']?>">
				<h2>Оставьте свой комментарий!</h2>

				<!-- Comment Form -->			
				<form id="cmnt_frm" method="post" action="">
                                        <!--<p><input type="text" name="author_comment" size="22" tabindex="1" id="author"/><label>Имя <span>(обязательно)</span></label></p>-->
										<input type="hidden" placeholder="your name" name="author_comment" value="<?=$_SESSION['id']?>">
                                        <!--<p><input type="text" name="email_comment" size="22" tabindex="2" id="email"/><label>Почта <span>(will not be published) (required)</span></label></p>
                                        <p><input type="text" name="url" size="22" tabindex="3" id="url"/><label>Сайт</label></p>-->
                                        <p>
                                                <textarea name="text_comment" cols="65" rows="10" tabindex="4" id="comment"></textarea>
                                        </p>
                                        <p>
                                                <input type="submit" name="submit" value="Отправить" tabindex="5" id="submit"/>
                                        </p>

				</form>
				</div>
				<? endif;?>
</div>
  <? include('sidebar.php');?>
  <div style="clear: both;"></div>
</div>


<script>
$(document).ready(function() {
    $(".like").bind("click", function() {
        var link = $(this);
        var id = link.data('id');
        var usr = link.data('usr');
        
        $.ajax({
            url: "like.php",
            type: "POST",
            data: {id:id, usr:usr}, // Передаем ID нашей статьи
            dataType: "json",
            success: function(result) {
                if (!result.error){ //если на сервере не произойло ошибки то обновляем количество лайков на странице
					console.log(result);
                    link.addClass('active'); 
					if(result.isActive){
						link.addClass('active'); 
					}else{
						link.removeClass('active'); 
					}
                    // помечаем лайк как "понравившийся"
                    $('.counter',link).html(result.count);
					
                }else{
                    alert(result.message);
                }
            }
        });
    });
});
</script>


<script>
$(document).ready(function() {
    $(".push").bind("click", function() {
        var link = $(this);
        var id = <?=$_GET['id']?>;
        var usr = <?=$_SESSION['id']?>;
		console.log(id);
        var msg = jQuery('.leave-comment textarea').val();
		jQuery('.leave-comment textarea').val('');
        console.log(msg);
        $.ajax({
            url: "comment.php",
            type: "POST",
            data: {id:id, usr:usr, msg:msg}, // Передаем ID нашей статьи
            dataType: "json",
            success: function(result) {
                if (!result.error){
                	console.log(result); //если на сервере не произойло ошибки то обновляем количество лайков на странице
                    link.addClass('active'); // помечаем лайк как "понравившийся"
                    $('.comm',link).html(result.some);
					console.log(result.some);
					console.log(result.some.text);
					jQuery('.comments').prepend('<div class="comment"><div class="comm_hdr">' +  ' Написал: ' + result.some.name + ' ' + result.some.surname + ', ' + result.some.age + ' лет ' + result.some.date + ' в ' + result.some.time + '</div><p class="comm_txt">' + result.some.text + '<img src=img/' + result.some.avatar + ' alt="" width="60px" height="60px"></p></div>');
                }else{
					console.log('error');
                    alert(result.message);
                }
            }
        });
	return false;
    });
});
</script>

<script>
jQuery(document).ready(function(){
    var _step = 180;
    var _index = 0;
    jQuery('.right-img').click(function(){
        _index = _index+1;
        jQuery("#fancy").scrollLeft(_step*_index);
        console.log(_step*_index);
        return false;

    });
})

jQuery(document).ready(function(){
    var _step = 180;
    var _index = 0;
    jQuery('.left-img').click(function(){
        _index = _index-1;
        jQuery("#fancy").scrollLeft(_step*_index);
        console.log(_step*_index);
        return false;

    });
})
</script>

<script type="text/javascript">
					jQuery(document).ready(function() {
					jQuery('.buttonComments').click(function(){
						if(jQuery('.buttonComments').attr('rel') == 0){
							jQuery('.comments').fadeOut(500);
							jQuery('.buttonComments').attr('rel', '1');
						}else{
							jQuery('.comments').fadeIn(500);
							jQuery('.buttonComments').attr('rel', '0');
						}
					});
					});
				</script>
<? 
include_once('footer.php');
?>