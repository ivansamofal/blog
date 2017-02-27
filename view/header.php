<?
		if($_POST['query']){	
		header("Location: articles.php?query={$_POST['query']}");
		}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/templatemo_style.css">

<? ($row['title']) ? $title = $row['title'] : '';?>
<title><?=$title?></title>
<meta charset="utf-8">
 <meta name="keywords" content="<?=$keywords?>" />
  <meta name="description" content="<?=$description?>" />
<!-- скрипты для увеличения фоток на странице отелей -->
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery.shadow.js"></script>
<script type="text/javascript" src="js/jquery.ifixpng.js"></script>
<script type="text/javascript" src="js/jquery.fancyzoom.min.js"></script>
<script type="text/javascript">
    jQuery(function() {
        jQuery('#fancy a').fancyzoom();
    });
</script>
</head>
<?
$menuObj = new menuClass;
$menu = $menuObj->getMenu($mysqli);
$cats = $menuObj->getCategories($mysqli);
//var_dump($cats);
?>
<body>
<!--<div class="item-article">
	<div class="logo"><a href="index.php"><div></div></a>
		<ul id="mainMenu">
		<? $uri = explode('/', $_SERVER["REQUEST_URI"]);
?>
<? //вывод пунктов меню 
?>
	<? for($i = 0; $i < count($menu['item']); $i++):?>
		<? if($menu['url'][$i] === $uri[count($uri)-1]):?>
			<li class="activeMenu"><a href="<?=$menu['url'][$i]?>"><?=$menu['item'][$i]?></a></li>
		<? endif;?>
			<?if(isset($_SESSION['id'])):?>
				<?if($menu['auth'][$i] && $menu['url'][$i] != $uri[count($uri)-1] || $menu['all'][$i] && $menu['url'][$i] != $uri[count($uri)-1]):?>
					<?if($menu['url'][$i] === 'profile.php'):?>
						<li><a href="<?=$menu['url'][$i]?>?id=<?=$_SESSION['id']?>"><?=$menu['item'][$i]?></a></li>
					<?else:?>
						<li><a href="<?=$menu['url'][$i]?>"><?=$menu['item'][$i]?></a></li>
					<?endif;?>
				<?endif;?>
			<?else:?>
				<?if($menu['guests'][$i] && $menu['url'][$i] != $uri[count($uri)-1] || $menu['all'][$i] && $menu['url'][$i] != $uri[count($uri)-1]):?>
					<li><a href="<?=$menu['url'][$i]?>"><?=$menu['item'][$i]?></a></li>
				<?endif;?>
			<?endif;?>
	<? endfor;?>
		</ul>
		
		

	</div>-->
	
	
<div id="templatemo_body_wrapper">
<div id="templatemo_wrapper">
    
    <div id="templatemo_header">
            
        <div id="site_title">
            <a href="index.php" target="_parent">Samofal 
            	<span>Ivan</span>
                <span class="tagline"><?=$titleSite?></span>
            </a>
        </div> <!-- end of site_title -->
		
	
        
        <div id="search_box">
            <form action="#" method="post">
                <input type="text" placeholder="Поиск..." name="query" size="10" id="searchfield" title="Поиск" />
              <input type="submit" name="Search" placeholder="Search" id="searchbutton" title="Искать" />
            </form>
        </div>
    
   
        <div class="cleaner"></div>
        
    </div> <!-- end of header -->
    <div id="templatemo_menu">
        <ul>
			<?if('/myblog2/index.php' == $_SERVER['REQUEST_URI']):?>
				<li><a href="index.php" class="current"><span></span>Главная</a></li>
			<?else:?>
				<li><a href="index.php" ><span></span>Главная</a></li>
			<?endif;?>
			<? for($i = 0; $i < count($cats['id']); $i++):?>
				
				<?if($_GET['cat'] == $cats['alias'][$i]):?>
					<li><a class="current" href="articles.php?cat=<?=$cats['alias'][$i]?>"><span></span><?=$cats['name'][$i]?></a></li>
				<?else:?>
				<li><a href="articles.php?cat=<?=$cats['alias'][$i]?>"><span></span><?=$cats['name'][$i]?></a></li>
				<?endif;?>
			<? endfor;?>
        </ul>    	
        
        <div id="register_box">
        	<? if (!$_SESSION['id']): ?>
			Already Registered? Click <a href="#" class="signup">Here</a> | <a href="register.php" class="new_reg">Register</a>
			<?endif;?>
        </div>
    </div>