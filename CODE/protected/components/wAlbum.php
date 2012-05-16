<?php 
Yii::import('zii.widgets.CPortlet');
class wAlbum extends CPortlet
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
		$criteria->compare('status', Album::STATUS_ACTIVE);
		$criteria->addInCondition('special',Album::getCode_special($this->special));
		$criteria->limit=$this->limit;
		$album=Album::model()->find($criteria);
		parse_str( parse_url( $album_->link, PHP_URL_QUERY ), $vars );
		$this->render($this->view,array(
			'album_id'=>$vars['v']
		));
	}
}
?>
