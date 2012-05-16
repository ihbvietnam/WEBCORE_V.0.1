<?php 
Yii::import('zii.widgets.CPortlet');
class wBanner extends CPortlet
{
	public $code;
	public $view;
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$banner = Banner::model ()->findByPk ( $this->code );
		if (isset ( $banner )) {
			$list_images = array_diff ( explode ( ',', $banner->images ), array ('' ) );
			$this->render ( $this->view, array ('list_images' => $list_images ) );
		}
	}
}
?>
