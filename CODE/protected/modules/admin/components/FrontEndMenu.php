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
		if(isset(Yii::app()->session['lang'])  && Yii::app()->session['lang'] == 'en')
			$model->group=Category::GROUP_USER_MENU_EN;
		else 
			$model->group=Category::GROUP_USER_MENU;
		//Create list menu which are used when view menu
		$list=$model->list_Categories;	
		$previous_id=0;
		$finish=0;
		if(sizeof($list)>0){
			$first=true;
			foreach ($list as $id=>$menu) {
				if($menu['level']==1)$last=$id;
				if($previous_id>0 && $list[$previous_id]['level']<$menu['level']){
					$list[$previous_id]['havechild']=true;				
				}
				if($previous_id>0 && $list[$previous_id]['level']>$menu['level']){
					$list[$previous_id]['close']=$list[$previous_id]['level']-$menu['level'];			
				}
				$previous_id=$id;
			}
			$list[$last]['class']='last';
			$list[$previous_id]['close']=$list[$previous_id]['level']-1;
		}
		$list_menus=array();			
		foreach ($list as $id=>$menu) {
			$list_menus[$id]['name']=$menu['name'];
			$list_menus[$id]['url']=$menu['url'];
			$list_menus[$id]['root']=$menu['root'];
			$list_menus[$id]['class']=isset($menu['class'])?$menu['class']:'';
			$list_menus[$id]['havechild']=isset($menu['havechild'])?$menu['havechild']:false;
			$list_menus[$id]['close']=isset($menu['close'])?$menu['close']:false;
		}
		$this->render('frontEndMenu',array(
			'list_menus'=>$list_menus,
		));
	}
}
?>