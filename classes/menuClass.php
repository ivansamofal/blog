<?
class menuClass{
	
	public function getMenu($mysqli){//get menu create, profile etc
		$getMenu = $mysqli->query("SELECT * FROM `menu` WHERE `is_active` = true");
		while($rowMenu = $getMenu->fetch_array()){
			$menu['item'][] = $rowMenu['name_menu'];
			$menu['url'][] = $rowMenu['url'];
			$menu['auth'][] = $rowMenu['for_auth'];
			$menu['guests'][] = $rowMenu['for_guests'];
			$menu['all'][] = $rowMenu['for_all'];
		}
		return $menu;
	}
	public function getCategories($mysqli){//get categories for the blog
		$getCats = $mysqli->query("SELECT * FROM `categories`");
		while($rowCat = $getCats->fetch_array()){
			$cats['id'][] = $rowCat['id_cat'];
			$cats['name'][] = $rowCat['name'];
			$cats['alias'][] = $rowCat['alias_cat'];
		}
		return $cats;
	}	
}