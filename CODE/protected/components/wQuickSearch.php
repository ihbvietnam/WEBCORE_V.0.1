<?php 
Yii::import('zii.widgets.CPortlet');
class wQuickSearch extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$search=new SearchForm();
		$search->name='Tìm kiếm...';
		if(isset($_POST['SearchForm']))
			$search->attributes=$_POST['SearchForm'];
		$this->render('quick-search',array(
			'search'=>$search
		));
	}
}
?>
