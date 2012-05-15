<?php 
Yii::import('zii.widgets.CPortlet');
class wRemark extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status', Product::STATUS_ACTIVE);
		$criteria->addInCondition('special',Product::getCode_special(Product::SPECIAL_REMARK));
		$criteria->order='id desc';
		$criteria->limit=Setting::s('SIZE_REMARK_PRODUCT');
		$list_product=Product::model()->findAll($criteria);
		$this->render('remark',array(
			'list_product'=>$list_product,
		));
	}
}
?>