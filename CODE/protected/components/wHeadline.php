<?php 
Yii::import('zii.widgets.CPortlet');
class wHeadline extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$banner=Banner::model()->findByPk(Banner::CODE_HEADLINE);
		$list_id=array_diff ( explode ( ',', $banner->images ), array (''));
		$this->render('head-line',array(
			'list_id'=>$list_id
		));
	}
}
?>

