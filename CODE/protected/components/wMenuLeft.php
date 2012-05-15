<?php 
Yii::import('zii.widgets.CPortlet');
class wMenuLeft extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$model=new Category();
		$model->group=Category::GROUP_PRODUCT;
		//Create list menu which are used when view menu
		$list_categories=$model->list_Categories;	
		$list=array();
		foreach ($list_categories as $index=>$category){
			$list_special=iPhoenixStatus::decodeStatus($category['special']);
			if(in_array(Category::SPECIAL_REMARK,$list_special))
				$list[$index]=$category;			
		}
		$previous_id=0;
		$finish=0;
		if(sizeof($list)>0){
			$first=true;
			foreach ($list as $id=>$menu) {
				if($first==true) {
					$list[$id]['class']='first';
					$first=false;
				}
				if($menu['level']==1)$last=$id;
				if($previous_id>0 && $list[$previous_id]['level']<$menu['level']){
					if($list[$previous_id]['level']==1){
						$list[$previous_id]['havechild']=true;		
					}
					else {
						$list[$previous_id]['class']='x';
					}
					$list[$id]['class']='first-item';			
				}
				if($previous_id>0 && $list[$previous_id]['level']>$menu['level']){
					$list[$previous_id]['class']='last-item';	
					$list[$previous_id]['close']=$list[$previous_id]['level']-$menu['level'];			
				}
				$previous_id=$id;
			}
			$list[$previous_id]['class']='last-item';
			$list[$last]['class']='last';
			$list[$previous_id]['close']=$list[$previous_id]['level']-1;
		}
		$list_menus=array();			
		foreach ($list as $id=>$menu) {
			$list_menus[$id]['name']=$menu['name'];
			$list_menus[$id]['url']=$menu['url'];
			$list_menus[$id]['class']=isset($menu['class'])?$menu['class']:'';
			$list_menus[$id]['havechild']=isset($menu['havechild'])?$menu['havechild']:false;
			$list_menus[$id]['close']=isset($menu['close'])?$menu['close']:false;
		}
		$this->render('menu-left',array(
			'list_menus'=>$list_menus,
		));
	}
}
?>