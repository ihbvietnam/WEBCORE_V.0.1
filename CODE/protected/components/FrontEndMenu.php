<?php 
Yii::import('zii.widgets.CPortlet');
class FrontEndMenu extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$model=new Category();
		$model->group=Category::GROUP_USER_MENU;
		//Create list menu which are used when view menu
		$list=$model->list_Categories;	
		$list_menus=array();
		$list_active_menu_id=Category::findActiveUserMenu();			
		foreach ($list as $id=>$menu) {
			$list_menus[$id]['name']=$menu['name'];
			$list_menus[$id]['url']=$menu['url'];
			if(in_array($id,$list_active_menu_id)){
				$list_menus[$id]['class'] =" active";
			}
		}
		$this->render('front-end-menu',array(
			'list_menus'=>$list_menus,
		));
	}
}
?>