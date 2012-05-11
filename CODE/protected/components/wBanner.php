<?php 
Yii::import('zii.widgets.CPortlet');
class wBanner extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$banner=Banner::model()->findByPk(Banner::CODE_LEFT);
		$list_images=array_diff ( explode ( ',', $banner->images ), array ('' ));
		$this->render('banner',array(
			'image_id'=>$list_images[0]
		));
	}
}
?>
