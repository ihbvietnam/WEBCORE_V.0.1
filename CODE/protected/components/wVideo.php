<?php 
Yii::import('zii.widgets.CPortlet');
class wVideo extends CPortlet
{
	public $view;
	public $limit;
	public $special;
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status', GalleryVideo::STATUS_ACTIVE);
		$criteria->addInCondition('special',GalleryVideo::getCode_special($this->special));
		$criteria->limit=$this->limit;
		$gallery_video=GalleryVideo::model()->find($criteria);
		parse_str( parse_url( $gallery_video->link, PHP_URL_QUERY ), $vars );
		$this->render($this->view,array(
			'video_id'=>$vars['v']
		));
	}
}
?>