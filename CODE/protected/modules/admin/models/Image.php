<?php

/**
 * This is the model class for table "image".
 *
 * The followings are the available columns in table 'image':
 * @property integer $id
 * @property integer $catid
 * @property string $other
 */
class Image extends CActiveRecord
{
	const MAX_WIDTH_THUMB_IMAGE_UPDATE=450;
	const MAX_WIDTH_THUMB_AUTO=150;
	/*
	 * Config status of image
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;	
	/*
	 * Config categories image
	 */
	static $config_category=array(
		'News'=>'News',
		'Album'=>'Album',
		'GalleryVideo'=>'GalleryVideo',
		'Banner'=>'Banner',
	);
	/*
	 * Config size of thumb
	 */
	static $config_thumb_size=array(
		'News'=>array(
			'thumb_list_admin'=>array('h'=>45,'w'=>45),
			'thumb_update'=>array('h'=>45,'w'=>45),
			'headline'=>array('h'=>258,'w'=>425),
			'thumb_headline'=>array('h'=>50,'w'=>60),
			'thumb_homepage'=>array('h'=>90,'w'=>90),
			'thumb_detailpage'=>array('h'=>90, 'w'=>125),
			'thumb_listpage'=>array('h'=>90,'w'=>90)
		),
		'Album'=>array(
			'thumb_update'=>array('h'=>70,'w'=>100),
			'thumb_list_admin'=>array('h'=>45,'w'=>60),
			'first_image_homepage'=>array('h'=>132,'w'=>182),
			'other_image_homepage'=>array('h'=>55,'w'=>72),
			'thumb_list_page'=>array('h'=>100,'w'=>125),
			'thumb_image_big'=>array('h'=>378,'w'=>620),
			'thumb_image_small'=>array('h'=>35,'w'=>35),
		),
		'Banner'=>array(
			'thumb_update'=>array('h'=>70,'w'=>100),
			'right'=>array('h'=>124,'w'=>300),
			'thumb_right'=>array('h'=>62,'w'=>150),
			'thumb_list_admin'=>array('h'=>45,'w'=>60),
			'footer'=>array('h'=>130,'w'=>185),
			'thumb_footer'=>array('h'=>65,'w'=>'92'),
			'link_partner'=>array('h'=>50,'w'=>50),
			'thumb_top'=>array('h'=>43,'w'=>327),
			'top'=>array('h'=>129,'w'=>980),
			'main'=>array('h'=>185,'w'=>630),
			'thumb_main'=>array('h'=>92,'w'=>315)
		),
		'GalleryVideo'=>array(
			'thumb_list_admin'=>array('h'=>45,'w'=>60),
			'thumb_update'=>array('h'=>45,'w'=>60),
			'thumb_detail_video'=>array('h'=>100,'w'=>125),
		),
		'Image'=>array(
			'thumb_image_update'=>array('h'=>300,'w'=>450),
		)	
	);	
	/*
	 * Config thumb_type 
	 * Use remove image
	 */
	static $config_thumb_type=array('thumb_auto','thumb_right','thumb_update','thumb_detail_video','thumb_list_page','thumb_image_big','thumb_image_small','thumb_listpage','thumb_detailpage','link_partner','footer','right','other_image_homepage','first_image_homepage','thumb_update','thumb_list_admin','headline','thumb_headline');
	private $config_other_attributes=array('created_date','created_by');	
	private $list_other_attributes;
	
	/*
	 * Get path of origin image
	 */
	public function getPathOrigin(){
		return Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension;
	}
	/*
	 * Get url of origin image
	 */
	public function getUrlOrigin(){
		return Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension;
	}
	/*
	 * Get width of origin image
	 */
	public function getWidth(){
		$size=getimagesize($this->pathOrigin);
		return $size[0];
	}
	/*
	 * Get height of origin image
	 */
	public function getHeight(){
		$size=getimagesize($this->pathOrigin);
		return $size[1];
	}
	/*
	 * Get url
	 */
	public function getUrl()
 	{
 		if($this->url !="") 
 			return $this->url;
 		else 
 			return "";
 	}
 	/*
 	 * Get auto thumb of image 
 	 */
	public function getAutoThumb(){
			$type="auto_thumb";
			$url=Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension;
			if(!file_exists($url)){
			if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type)){
				mkdir(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type);
			}
			if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension)){
				$thumb=new ResizeImage(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension);
				$zoom=(int)Image::MAX_WIDTH_THUMB_AUTO/$this->width;
				$w=$zoom*$this->width;
				$h=$zoom*$this->height;
				$thumb->resize_image($w,$h);
				$thumb->save($url);
			}
		}
		return '<img class="img" src="'.Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension.'" alt="">';
	}
	/*
	 * Get thumb of image
	 */
	public function getThumb($category=null,$type=null){
		if($category != null && $type != null){
		$url=Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension;
		if(!file_exists($url)){
			if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type)){
				mkdir(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type);
			}
			if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension)){
				$thumb=new ResizeImage(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension);
				$thumb->resize_image(self::$config_thumb_size[$category][$type]['w'],self::$config_thumb_size[$category][$type]['h']);
				$thumb->save($url);
			}
		}
		return Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension;
		}
		else {
			$type="auto_thumb";
			$url=Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension;
			if(!file_exists($url)){
			if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type)){
				mkdir(Yii::getPathOfAlias('webroot').'/'.$this->src.'/'.$type);
			}
			if(file_exists(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension)){
				$thumb=new ResizeImage(Yii::getPathOfAlias('webroot').'/'.$this->src.'/origin/'.$this->filename.'.'.$this->extension);
				$zoom=(int)Image::MAX_WIDTH_THUMB_AUTO/$this->width;
				$w=$zoom*$this->width;
				$h=$zoom*$this->height;
				$thumb->resize_image($w,$h);
				$thumb->save($url);
			}
		}
		return Yii::app()->request->getBaseUrl(true).'/'.$this->src.'/'.$type.'/'.$this->filename.'.'.$this->extension;
		}
	}
	/*
	 * Returnthumb default of image
	 */
	static function getDefaultThumb($category,$type){
		$config=array(
		'News'=>array(
			'thumb_list_admin'=>'images/default/default45x45.jpg',
			'thumb_update'=>'images/default/default45x45.jpg',
			'headline'=>'images/default/default258x425.jpg',
			'thumb_headline'=>'images/default/default50x60.jpg',
			'thumb_homepage'=>'images/default/default90x90.jpg',
			'thumb_detailpage'=>'images/default/default90x125.jpg',
			'thumb_listpage'=>'images/default/default90x90.jpg',
		),
		'Album'=>array(
			'thumb_update'=>array('h'=>70,'w'=>100),
			'thumb_list_admin'=>array('h'=>45,'w'=>60),
			'first_image_homepage'=>array('h'=>132,'w'=>182),
			'other_image_homepage'=>array('h'=>55,'w'=>72),
			'thumb_list_page'=>array('h'=>100,'w'=>125),
			'thumb_image_big'=>array('h'=>378,'w'=>620),
			'thumb_image_small'=>array('h'=>35,'w'=>35),
		),
		'Banner'=>array(
			'thumb_update'=>array('h'=>70,'w'=>100),
			'right'=>array('h'=>124,'w'=>300),
			'thumb_right'=>array('h'=>62,'w'=>150),
			'thumb_list_admin'=>array('h'=>45,'w'=>60),
			'footer'=>array('h'=>130,'w'=>185),
			'thumb_footer'=>array('h'=>65,'w'=>'92'),
			'link_partner'=>array('h'=>50,'w'=>50),
			'main'=>array('h'=>185,'w'=>630),
			'thumb_main'=>array('h'=>92,'w'=>315)
		),
		'GalleryVideo'=>array(
			'thumb_list_admin'=>array('h'=>45,'w'=>60),
			'thumb_update'=>array('h'=>45,'w'=>60),
			'thumb_detail_video'=>'images/default/default100x125.jpg',
		),
		'Image'=>array(
			'thumb_image_update'=>array('h'=>300,'w'=>450),
		)	
	);
		if(isset($config[$category][$type])) 
			return Yii::app()->request->getBaseUrl(true).'/'.$config[$category][$type];
		else 
			return '';
	}
	/*
	 * PHP setter magic method for other attributes
	 */
	public function __set($name,$value)
	{
		if(in_array($name,$this->config_other_attributes))
			$this->list_other_attributes[$name]=$value;
		else 
			parent::__set($name,$value);
	}
	
	/*
	 * PHP getter magic method for other attributes
	 */
	public function __get($name)
	{
		if(in_array($name,$this->config_other_attributes))
			if(isset($this->list_other_attributes[$name])) 
				return $this->list_other_attributes[$name];
			else 
		 		return null;
		else
			return parent::__get($name);
	}
	/*
	 * Get image url which view status of image
	 */
 	public function getImageStatus()
 	{
 		switch ($this->status) {
 			case self::STATUS_ACTIVE: 
 				return Yii::app()->request->getBaseUrl(true).'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				return Yii::app()->request->getBaseUrl(true).'/images/admin/disable.png';
 				break;
 		}	
 	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Image the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('src,filename,extension', 'required'),
			array('other', 'length', 'max'=>2048),
			array('title,url','safe','on'=>'update'),
			array('title','safe','on'=>'search')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author'=>array(self::BELONGS_TO,'User','created_by')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'title'=>'Tên ảnh',
			'url'=>'Link liên kết'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('title',$this->title);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('category',$this->category);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterFind()
	{
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);	
		return parent::afterFind();
	}
	/**
	 * This method is invoked before saving a record (after validation, if any).
	 * The default implementation raises the {@link onBeforeSave} event.
	 * You may override this method to do any preparation work for record saving.
	 * Use {@link isNewRecord} to determine whether the saving is
	 * for inserting or updating record.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the saving should be executed. Defaults to true.
	 */
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created_date=time();
				$this->created_by=Yii::app()->user->id;
			}				
			//Encode other attributes  		
			$this->other = json_encode ( $this->list_other_attributes );
			return true;	
		} 
		else
			return false;
	}
	/**
	 * This method is invoked after saving a record successfully.
	 * The default implementation raises the {@link onAfterSave} event.
	 * You may override this method to do postprocessing after record saving.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterSave()
	{
		if($this->isNewRecord){
			if ($this->parent_id > 0) {
				switch ($this->category) {
					case self::$config_category ['News'] :
						$parent = News::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['Album'] :
						$parent = Album::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['Banner'] :
						$parent = Banner::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
					case self::$config_category ['GalleryVideo'] :
						$parent = GalleryVideo::model ()->findByPk ( $this->parent_id );
						$parent->scenario = 'upload-image';
						break;
				}
			$attribute=$this->parent_attribute;
			$old_attributes = array_diff ( explode ( ',', $parent->$attribute ), array ('' ) );
			if(!in_array($this->id,$old_attributes)) 
			{
				$old_attributes[]=$this->id;		
				$parent->$attribute = implode ( ',', $old_attributes);
				if($parent->save())
					return true;
				else 
					return false;
			}
			}
		}
		return parent::afterSave();
	}
	/**
	 * This method is invoked before delete a record 
	 */
	public function beforeDelete() {
		if (parent::beforeDelete ()) {
			foreach ( self::$config_thumb_type as $type ) {
				$dir = Yii::getPathOfAlias ( 'webroot' ) . '/' . $this->src . '/' . $type;
				$file = $dir . '/' . $this->filename . '.' . $this->extension;
				if (file_exists ( $file )) {
					unlink ( $file );
					if (count ( scandir ( $dir ) ) == 2) {
						rmdir ( $dir );
					}
				}
			}
		if ($this->parent_id > 0) {
				switch ($this->category) {
					case self::$config_category ['News'] :
						$parent = News::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Album'] :
						$parent = Album::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['Banner'] :
						$parent = Banner::model ()->findByPk ( $this->parent_id );
						break;
					case self::$config_category ['GalleryVideo'] :
						$parent = GalleryVideo::model ()->findByPk ( $this->parent_id );
						break;
				}
				$attribute = $this->parent_attribute;
				$old_attributes = array_diff ( explode ( ',', $parent->$attribute ), array ('' ) );
				foreach ( $old_attributes as $id => $image_id ) {
					if ($image_id == $this->id) {
						unset ( $old_attributes [$id] );
					}
				}
				$parent->$attribute = implode ( ',', $old_attributes);
			if($parent->save())
				return true;
			else 
				return false;
			}
			else {
				return true;
			}
		}
		else
			return false;
	}
	//Create directory which contains image
	static function createDir($path){
		$dir=$path;
		$dir .= '/'.date('Y',time());
		if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$dir)){
			mkdir(Yii::getPathOfAlias('webroot').'/'.$dir);
		}
		$dir .= '/'.date('m',time());
		if(!file_exists(Yii::getPathOfAlias('webroot').'/'.$dir)){
			mkdir(Yii::getPathOfAlias('webroot').'/'.$dir);
		}
		$dir .= '/'.date( 'd', time () );
		if (! file_exists ( Yii::getPathOfAlias ( 'webroot' ) . '/' . $dir )) {
			mkdir ( Yii::getPathOfAlias ( 'webroot' ) . '/' . $dir );
		}
		return $dir;
	}
	//Find images from html
	static function findImages($html) {
		if ($html == "")
			return array ();
		else {
			/*
			$doc = new DOMDocument ();
			$doc->loadHTML ( $html );
			$xml = simplexml_import_dom ( $doc ); // just to make xpath more simple
			$images = $xml->xpath ( '//img' );
			$list_src = array ();
			foreach ( $images as $img ) {
				$src = $img ['src']->__toString ();
				$pos = strpos ( $src, Yii::app ()->request->serverName);
    		if($pos>0){
    			$list_src[]=substr($src, $pos+strlen(Yii::app()->request->serverName));
    		}
		}	
		return $list_src;
		*/
		preg_match_all('/src="([^"]+)"/',$html, $result);
		$files=$result[1];
		$list_src=array();
		foreach ($files as $src){
				$pos = strpos ( $src, Yii::app ()->request->serverName);
    		if($pos>0){
    			$list_src[]=substr($src, $pos+strlen(Yii::app()->request->serverName));
			}
		}
		return $list_src;
		}
	}
	/*
	 * Copy image
	 */
	static function copy($origin_id,$new_parent_id){
		$origin=Image::model()->findByPk($origin_id);
		$copy= new Image();
		$filename=$origin->filename;
        $copy->extension=$origin->extension;
        $copy->parent_attribute=$origin->parent_attribute;
        $copy->category=$origin->category;
        $copy->parent_id=$new_parent_id;
        $origin_directory=Yii::getPathOfAlias('webroot').'/'.$origin->src.'/';
        $new_folder=Image::createDir('upload');
        $new_directory=Yii::getPathOfAlias('webroot').'/'.$new_folder.'/';
		if(!file_exists($new_directory .'/origin')){
				mkdir($new_directory .'/origin');
			}
        while ( file_exists ( $new_directory . '/origin/' . $filename . '.' . $origin->extension ) ) {
			$filename = $filename . '-' . rand ( 10, 99 );
		}
		if (file_exists ( $origin_directory . '/origin/' . $origin->filename . '.' . $origin->extension )) {
			if (copy ( $origin_directory . '/origin/' . $origin->filename . '.' . $origin->extension, $new_directory . '/origin/' . $filename . '.' . $origin->extension )) {
				$copy->src = $new_folder;
				$copy->filename=$filename;
        }
        else 	
        {
        	$copy->src=$origin->src;
        	$copy->filename=$origin->filename;   
        }
        }
        if($copy->save()){
        	return $copy->id;
        }
        else
        	return false;
	}
	/*
	 * Suggests a list image which matching the specified keyword.
	 */
	public function suggestTitle($keyword,$limit=20)
	{
		$list_qa=$this->findAll(array(
			'condition'=>'title LIKE :keyword',
			'order'=>'title DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$titles=array();
		foreach($list_qa as $qa)
			$titles[]=$qa->title;
			return $titles;
	}
	/*
	 * Set status of image
	 */
	static function reverseStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('status')
		->from('image')
		->where('id=:id',array(':id'=>$id))
		->queryRow();
		switch ($command['status']){
			case self::STATUS_PENDING:
				 $status=self::STATUS_ACTIVE;
				 break;
			case self::STATUS_ACTIVE:
				$status=self::STATUS_PENDING;
				break;
		}
		$sql='UPDATE image SET status = '.$status.' WHERE id = '.$id;
		$command=Yii::app()->db->createCommand($sql);
		if($command->execute()) {
			switch ($status) {
 			case self::STATUS_ACTIVE: 
 				$src=Yii::app()->request->getBaseUrl(true).'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				$src=Yii::app()->request->getBaseUrl(true).'/images/admin/disable.png';
 				break;
 			}	
 			$image=Image::model()->findByPk($id);
 			if($image->category=='Banner' && in_array($image->parent_id,array(Banner::CODE_TOP_EN,Banner::CODE_TOP_VI,Banner::CODE_MAIN)))
 			{	
 				$sql='UPDATE image SET status = 0 WHERE id <> '.$id.' AND category = "'.$image->category.'" AND parent_id ='.$image->parent_id;
 				$command=Yii::app()->db->createCommand($sql);
 				$command->execute();
 			}
			return $src;
		}
		else return false;
	}
}