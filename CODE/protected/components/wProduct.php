<?php 
Yii::import('zii.widgets.CPortlet');
class wProduct extends CPortlet
{
	public $view;
	public $special;
	public $limit;
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status', Product::STATUS_ACTIVE);
		$criteria->addInCondition('special',Product::getCode_special($this->special));
		$criteria->order='id desc';
		$criteria->limit=$this->limit;
		$list_product=Product::model()->findAll($criteria);
		$this->render($this->view,array(
			'list_product'=>$list_product,
		));
	}
}
?>
