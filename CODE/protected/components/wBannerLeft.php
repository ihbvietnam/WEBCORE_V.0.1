<?php 
Yii::import('zii.widgets.CPortlet');
class wBannerLeft extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$banner = Banner::model ()->findByPk ( Banner::CODE_LEFT );
		if (isset ( $banner )) {
			$list_images = array_diff ( explode ( ',', $banner->images ), array ('' ) );
			$this->render ( 'banner-left', array ('list_images' => $list_images ) );
		}
	}
}
?>
