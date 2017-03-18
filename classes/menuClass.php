<?
class menuClass{
	
	public function getMenu($db){//get menu create, profile etc
		$getMenu = $db->query("SELECT * FROM `menu` WHERE `is_active` = true");
		while($rowMenu = $getMenu->fetch()){
			$menu['item'][] = $rowMenu['name_menu'];
			$menu['url'][] = $rowMenu['url'];
			$menu['auth'][] = $rowMenu['for_auth'];
			$menu['guests'][] = $rowMenu['for_guests'];
			$menu['all'][] = $rowMenu['for_all'];
		}
		return $menu;
	}
	public function getCategories($db){//get categories for the blog
		$getCats = $db->query("SELECT * FROM `categories`");
		while($rowCat = $getCats->fetch()){
			$cats['id'][] = $rowCat['id_cat'];
			$cats['name'][] = $rowCat['name'];
			$cats['alias'][] = $rowCat['alias_cat'];
		}
		return $cats;
	}	
}