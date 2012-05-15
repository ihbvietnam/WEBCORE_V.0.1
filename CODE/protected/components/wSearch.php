<?php 
Yii::import('zii.widgets.CPortlet');
class wSearch extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$search=new SearchForm();
		if(isset($_POST['SearchForm']))
			$search->attributes=$_POST['SearchForm'];
		//List category product
		$group=new Category();		
		$group->group=Category::GROUP_PRODUCT;
		$list=$group->list_categories;
		$list_category=array();
		foreach ($list as $id=>$cat){
			$list_category[$id]=$cat;
		}
		$this->render('search',array(
			'search'=>$search,
			'list_category'=>$list_category
		));
	}
}
?>