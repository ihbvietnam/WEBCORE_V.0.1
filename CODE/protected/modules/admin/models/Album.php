<?php
/**
 * 
 * Album class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * Album.php includes attributes and methods of Album class  
 */
class Album extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_article';
	}
	
	/*
	 * Get scope of album for filter in the whole Article table
	 * Article::ARTICLE_ALBUM - constant for type of Album in article table
	 */
	public function defaultScope(){
		return array(
			'condition'=>'type = '.Article::ARTICLE_ALBUM,
		);
	}
	
	/*
	 * Config status of album
	 * pending: 0
	 * active: 1
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;	
	/**
	 * Config special
	 * SPECIAL_REMARK album is viewed at homepage
	 */
	const SPECIAL_REMARK=0;	
	/**
	 * Config number of items display in CListView for the Album list, Admin list, and other album list.  
	 */
	const LIST_ADMIN=10;
	const LIST_ALBUM=10;
	const OTHER_ALBUM=5;
	
	
	public $old_images;
	public $old_title;
	public $list_special;
	private $list_other_attributes;
	/**
	 * Config other new attributes for album.
	 * @var modified: modified time
	 * @var images: Album's Logo
	 * @var description: Album's description 
	 * @var metakey
	 * @var metadesc
	 */
	private $config_other_attributes=array('modified','images','description','metakey','metadesc');	
	
	/**
	 * Get image url which represents status of album
	 * @param boolean $this->status
	 * @return url definitive path of status image
	 * enable.png if $this->status is STATUS_ACTIVE
	 * disable.png if $this->status is STATUS_PENDING
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
	 * Get url of album
	 * @return album's url
	 */
	public function getUrl()
 	{
 		$url=Yii::app()->createUrl("site/album",array('album_alias'=>$this->alias));
		return $url;
 	}
 	
	/**
	 * Get all special view options of class Album
	 * Used in dropDownList on create or update album
	 * @return array represent the display option
	 */
	static function getList_label_specials()
 	{
	return array(
			self::SPECIAL_REMARK=>'Hiển thị ở trang chủ',
		);
 	}
 	
 	/**
 	 * Get specials of an album object
 	 * Used in admin page list
 	 * @return array
 	 */
	public function getLabel_specials()
 	{
		$label_specials=array();
		foreach ($this->list_special as $special) {
			$list_label_specials=self::getList_label_specials();
			$label_specials[]= $list_label_specials[$special];
		}
		return $label_specials;
 	}
 	/**
 	 * Special attributes are encoded before saved in database
 	 * Function get all code of the special attributes
 	 * @return array encoded status of Album's special display options 
 	 */
	static function getCode_special($index=null)
 	{
 		$result=array();
 		$full=range(0,pow(2,sizeof(self::getList_label_specials()))-1);
 		if($index === null){
 			$result=$full;
 		}
 		else {			
 			foreach ($full as $num){
 				if(in_array($index, iPhoenixStatus::decodeStatus($num))){
 					$result[]=$num;
 				}
 			}
 		}
 		return $result;
 	}
 	
	/**
	 * Get number images of a album	 
	 * @return integer number of images in this album 
	 */
	public function getQuantity_images(){
		$list=array_diff ( explode ( ',', $this->images ), array ('' ) );	
		return sizeof($list);
	}
	/**
	 * Get id of first image in album
	 * @return int id of first image in this album
	 */
	public function getThumb_id(){
		$list=array_diff ( explode ( ',', $this->images ), array ('' ) );	
		reset($list);
		return current($list);
	}
	/**
	 * Get url of first image
	 * @return url of the first image in this album
	 */
	public function getThumb_url($type){
		if($this->thumb_id>0){
			$image=Image::model()->findByPk($this->thumb_id);
			$src=$image->getThumb('Album',$type);
			return '<img class="img" src="'.$src.'" alt="'.$image->title.'">';
		}
		else {
			return '<img class="img" src="'.Image::getDefaultThumb('Album',$type).'" alt="">';
		}
	}
	/**
	 * PHP setter magic method for other attributes
	 * @param $name the attribute name
	 * @param $value the attribute value
	 * set value into particular attribute
	 */
	public function __set($name,$value)
	{
		if(in_array($name,$this->config_other_attributes))
			$this->list_other_attributes[$name]=$value;
		else 
			parent::__set($name,$value);
	}
	
	/**
	 * PHP getter magic method for other attributes
	 * @param $name the attribute name
	 * @return value of {$name} attribute
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

	/**
	 * @returns the static model of the specified AR class.
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title,images','required','message'=>'Dữ liệu bắt buộc','on'=>'write',),
			array('title', 'unique','message'=>'Album đã tồn tại','on'=>'write'),
			array('title', 'length', 'max'=>256,'message'=>'Tối đa 256 kí tự','on'=>'write'),
			array('description', 'length', 'max'=>512,'message'=>'Tối đa 512 kí tự','on'=>'write'),
			array('lang,list_special','safe','on'=>'write'),
			array('title,special,lang','safe','on'=>'search'),
			array('images','safe','on'=>'upload_image'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'category'=>array(self::BELONGS_TO,'Category','catid'),
			'author'=>array(self::BELONGS_TO,'User','created_by')
		);
	}

	/**
	 * @return array customized attribute labels 
	 */
	public function attributeLabels()
	{
		return array(
			'title' => 'Tên album',
			'created_by' => 'Người tạo',
			'created_date'=>'Thời gian tạo',
			'description'=>'Mô tả Album',
			'quantity_images'=>'Số lượng ảnh',
			'thumb_album'=>'Ảnh đại diện',
			'list_special' => 'Nhóm hiển thị',
			'special' => 'Lọc theo nhóm hiển thị',
			'lang' => 'Ngôn ngữ'
		);
	}
	/**
	 * This event is raised after the record is instantiated by a find method.
	 */
	public function afterFind()
	{
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);	
		//Store old intro image
		$this->old_images=$this->images;
		//Get list special
		$this->list_special=iPhoenixStatus::decodeStatus($this->special);	
		//Store old title
		$this->old_title=$this->title;
		if(isset($this->list_other_attributes['modified']))
			$this->list_other_attributes['modified']=(array)json_decode($this->list_other_attributes['modified']);
		else 
			$this->list_other_attributes['modified']=array();
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
				$this->status=Album::STATUS_ACTIVE;
				//Set alias
				$this->alias=iPhoenixString::createAlias($this->title).'-'.date('d').date('m').date('Y');	
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
				if($this->title != $this->old_title) $this->alias=iPhoenixString::createAlias($this->title).'-'.date('d').date('m').date('Y');
			}	
			//Encode special
			$this->special=iPhoenixStatus::encodeStatus($this->list_special);
			/*
			//Set list_special of other album to empty
			if(sizeof($this->list_special)>0){
				$list_album=Album::model()->findAll('id <> '.$this->id.' AND lang = '.$this->lang);
				foreach ($list_album as $album){
					$album->list_special=array();
					$album->save();
				}
			} 
			*/
			$this->type=Article::ARTICLE_ALBUM;
			$this->other=json_encode($this->list_other_attributes);
			return true;
		}
		else
			return false;
	}
	
	/**
	 * This method is invoked after saving a record (after validation, if any).
	 * The default implementation raises the {@link onAfterSave} event.
	 * You may override this method to do any preparation work for record saving.	 
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the saving is successed or not. Defaults to true.
	 */	
	public function afterSave(){
		if ($this->old_images != $this->images) {
			foreach ( array_diff ( explode ( ',', $this->images ), array ('' ) ) as $image_id ) {
				$image = Image::model ()->findByPk ( $image_id );
				if (isset ( $image )) {
					$image->parent_id = $this->id;
					if (!$image->save ())
						return false;
				} 
			}
		
		}
		return true;
	}
	
	/**
	 * This method is invoked before delete a record 
	 * @return boolean whether the deleting is successed or not. Defaults to true. 
	 */
	public function beforeDelete() {
		if (parent::beforeDelete ()) {
			//Delete images	
			foreach ( array_diff ( explode ( ',', $this->images ), array ('' ) ) as $image_id ) {
				$image = Image::model ()->findByPk ( $image_id );
				if (isset ( $image )) {
					$image->parent_id = $this->id;
					if (!$image->delete())
						return false;
				} 
			}	
			return true;	
		}
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
		$criteria->compare('lang',$this->lang);
		$criteria->compare('title',$this->title,true);
		if($this->special !='')
			$criteria->addInCondition('special',self::getCode_special($this->special));
		$criteria->order="id DESC";
		if(isset($_GET['pageSize']))
				Yii::app()->user->setState('pageSize',$_GET['pageSize']);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
        		'pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    		),
		));
	}
	
	/**
	 * Suggests a list banner which matching the specified keyword.
	 * @return array list of titles similar to input keyword
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
	/**
	 * Reverse status (enable & disbale)of album
	 * @return boolean wheather the reverse status activities is success or not; default value is false
	 */
	static function reverseStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('status')
		->from('tbl_article')
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
		$sql='UPDATE tbl_article SET status = '.$status.' WHERE id = '.$id;
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
			return $src;
		}
		else return false;
	}
}