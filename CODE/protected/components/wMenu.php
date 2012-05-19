<?php 
Yii::import('zii.widgets.CPortlet');
class wMenu extends CPortlet
{
	public $group;
	public $view;
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$model=Category::model()->findByPk($this->group);
		$model->group=$this->group;
		$list=$model->list_Categories;	
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
		$list_active_menu_id=$model->findActiveMenu();			
		foreach ($list as $id=>$menu) {
			$list_menus[$id]['name']=$menu['name'];
			$list_menus[$id]['url']=$menu['url'];
			if(isset($list_menus[$id]['root']))
			$list_menus[$id]['root']=$menu['root'];
				$list_menus[$id]['class']=isset($menu['class'])?$menu['class']:'';
			if(in_array($id,$list_active_menu_id)){
				$list_menus[$id]['class'] .=" active";
			}
			$list_menus[$id]['havechild']=isset($menu['havechild'])?$menu['havechild']:false;
			$list_menus[$id]['close']=isset($menu['close'])?$menu['close']:false;
		}
		$this->render($this->view,array(
			'list_menus'=>$list_menus,
		));
	}
}
?>