</div>
<div class="cleaner"></div>
</div>


<div id="templatemo_footer_wrapper">
	<div id="templatemo_footer">
    
    	<div class="footer_box col_w300">
        	<h4>Недавние посты</h4>
            <ul class="footer_menu">
				<?for($i = 0; $i < count($art2['titles']); $i++):?>
					<li><a href="article.php?id=<?=$art2['id'][$i]?>"><?=$art2['titles'][$i]?></a></li>
				<?endfor;?>
            </ul>     
        </div>
        
        <div class="footer_box col_w160">
        	<h4>ТОП авторов</h4>
            <ul class="footer_menu">
				<?for($i = 0; $i < count($aut['name']); $i++):?>
            	<li><?=$aut['name'][$i]?> <?=$aut['surname'][$i]?>, <?=$aut['age'][$i]?></li>
				<?endfor;?>
            </ul>     
        </div>
        
        <div class="footer_box col_w160">
        	<h4>Partners</h4>
            <ul class="footer_menu">
            	<li><a href="http://www.flashmo.com/page/1" target="_parent">Flash Components</a></li>
                <li><a href="http://www.templatemo.com/page/1" target="_parent">Website Templates</a></li>
                <li><a href="http://www.webdesignmo.com/blog" target="_parent">Web Design</a></li>
                <li><a href="http://www.templatemo.com" target="_parent">CSS Templates</a></li>
                <li><a href="http://www.koflash.com" target="_parent">Flash Web Gallery</a></li>
            </ul>     
        </div>

        <div class="footer_box col_w260 fb_last">
        	<h4>Tag Cloud</h4>
            	<a href="#" style="font-size:12px">Aenean</a> <a href="#" style="font-size:11px">Cursus</a> <a href="#" style="font-size:16px">Maecenas</a> <a href="#" style="font-size:11px">Aliquam Ligula</a> <a href="#" style="font-size:20px">Egestas</a> <a href="#" style="font-size:16px">Suscipit</a> <a href="#" style="font-size:12px">Sapien</a> <a href="#" style="font-size:28px">Dignissim</a> <a href="#" style="font-size:14px">Vestibulum</a> <a href="#" style="font-size:12px">Lorem</a> <a href="#" style="font-size:14px">Urnain</a> <a href="#" style="font-size:20px">Neque</a> <a href="#" style="font-size:12px">Aenean</a>
        </div>
    
    	<div class="cleaner"></div>
    </div>
</div>

<div id="templatemo_copyright">
    Copyright © <?=date('Y')?> <a href="#"><?=$titleSite?></a> | 
    <a href="index.php" target="_parent">Ivan Samofal</a>
</div>

</body>
</html>