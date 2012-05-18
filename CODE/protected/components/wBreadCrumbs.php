<?php 
Yii::import('zii.widgets.CPortlet');
class wBreadCrumbs extends CPortlet
{
	public $data;
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$this->render ( 'bread-crumbs', array ('data' => $this->data ) );
	}
}
?>

