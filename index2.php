<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="js/jquery-1.8.3.min.js"></script>
<style>
.one_news span {
    border: 1px dotted;
    cursor: pointer;
    display: block;
    margin-bottom: 5px;
    text-align: center;
    width: 85px;
}
.one_news span:hover{
	border: 1px solid;
}
</style>

<script>
$(document).ready(function() {
	$('span#like').click(function(){
		setVote('like', $(this));
	});
	
	$('span#dislike').click(function(){
		setVote('dislike', $(this));
	});
	
});

// type - тип голоса. Лайк или дизлайк
// element - кнопка, по которой кликнули
function setVote(type, element){
	// получение данных из полей
	var id_user = $('#id_user').val();
	var id_news = element.parent().find('#id_news').val();
	
	$.ajax({
		// метод отправки 
		type: "POST",
		// путь до скрипта-обработчика
		url: "ajax_test.php",
		// какие данные будут переданы
		data: {
			'id_user': id_user, 
			'id_news': id_news,
			'type': type
		},
		// тип передачи данных
		dataType: "json",
		// действие, при ответе с сервера
		success: function(data){
			// в случае, когда пришло success. Отработало без ошибок
			if(data.result == 'success'){	
				// Выводим сообщение
				alert('Голос засчитан');
				// увеличим визуальный счетчик
				var count = parseInt(element.find('b').html());
				element.find('b').html(count+1);
			}else{
				// вывод сообщения об ошибке
				alert(data.msg);
			}
		}
	});
}
</script>

<?php
// подключение к бд
include "db_connection.php";

$userId = 1; // id пользователя
// достаем все новости
$sql = mysql_query("
    SELECT * FROM `news`
") or die(mysql_error());    
$news = array();
while($r = mysql_fetch_array($sql, MYSQL_ASSOC)){
    $news[] = $r;
}
?>
<div>
	<input type="hidden" id="id_user" value="<?=$userId;?>" />
	<?php foreach($news as $oneNews){ ?>
	<div class="one_news">
		<h3><?=$oneNews['title'];?></h3>
		<p><?=$oneNews['title'];?></p>
		<span id="like">Like (<b><?=$oneNews['count_like'];?></b>)</span>
		<span id="dislike">DisLike (<b><?=$oneNews['count_dislike'];?></b>)</span>
		<input type="hidden" id="id_news" value="<?=$oneNews['id'];?>" />
	</div>
	<hr/>
	<?php } ?>
</div>



