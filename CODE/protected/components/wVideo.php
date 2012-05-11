<?php 
Yii::import('zii.widgets.CPortlet');
class wVideo extends CPortlet
{
	public function init(){
		parent::init();
		
	}
	protected function renderContent()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status', GalleryVideo::STATUS_ACTIVE);
		$criteria->addInCondition('special',GalleryVideo::getCode_special(GalleryVideo::SPECIAL_REMARK));
		$criteria->order='id desc';
		$criteria->limit=1;
		$gallery_video=GalleryVideo::model()->find($criteria);
		parse_str( parse_url( $gallery_video->link, PHP_URL_QUERY ), $vars );
		$this->render('video',array(
			'video_id'=>$vars['v']
		));
	}
}
?>