<?php 
Yii::import('zii.widgets.CPortlet');
class wNews extends CPortlet
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
		$criteria->compare('status', News::STATUS_ACTIVE);
		$criteria->addInCondition('special',News::getCode_special($this->special));
		$criteria->order='id desc';
		$criteria->limit=$this->limit;
		$list_news=News::model()->findAll($criteria);
		$this->render($this->view,array(
			'list_News'=>$list_news,
		));
	}
}
?>

