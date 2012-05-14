<?php
class Banner extends CActiveRecord
{
	public function tableName()
	{
		return 'tbl_article';
	}
	/*
	 * Config scope of banner
	 */
	public function defaultScope(){
		return array(
			'condition'=>'type = '.Article::ARTICLE_BANNER,
		);	
	}
	/*
	 * Config status of banner
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	const LIST_ADMIN=10;
	
	/*
	 * Config code of banner (id)
	 */
	const CODE_RIGHT=8;
	const CODE_HEADLINE=2;
	const CODE_LEFT=1;
	
	public $old_images;
	public $old_title;
	private $list_other_attributes;
	private $config_other_attributes=array('modified','images','description','metakey','metadesc');	
	
	/*
	 * Get image url which view status of banner 
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
	/*
	 * Get quantity images of a banner
	 */
	public function getQuantity_images(){
		$list=array_diff ( explode ( ',', $this->images ), array ('' ) );	
		return sizeof($list);
	}
	/*
	 * Get id of first image in banner
	 */
	public function getThumb_id(){
		$list=array_diff ( explode ( ',', $this->images ), array ('' ) );	
		reset($list);
		return current($list);
	}
		/*
	 * Get url of first image
	 */
	public function getThumb_url($type){
		if($this->thumb_id>0){
			$image=Image::model()->findByPk($this->thumb_id);
			$src=$image->getThumb('Banner',$type);
		}
		else {
			$src="";
		}
		return '<img src="'.$src.'">';
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
	/**
	 * Returns the static model of the specified AR class.
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
			array('title', 'unique','message'=>'Banner đã tồn tại','on'=>'write'),
			array('title', 'length', 'max'=>256,'message'=>'Tối đa 256 kí tự','on'=>'write'),
			array('description', 'length', 'max'=>512,'message'=>'Tối đa 512 kí tự','on'=>'write'),
			array('title','safe','on'=>'search'),
			array('images','safe','on'=>'upload_image'),
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
			'category'=>array(self::BELONGS_TO,'Category','catid'),
			'author'=>array(self::BELONGS_TO,'User','created_by')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Mã banner',
			'title' => 'Tên Banner',
			'created_by' => 'Người đăng Banner',
			'created_date'=>'Thời điểm đăng Banner',
			'description'=>'Mô tả Banner',
			'quantity_images'=>'Số lượng ảnh trong Banner',
			'thumb_Banner'=>'Ảnh đại diện của Banner'
		);
	}
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterFind()
	{
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);	
		//Store old intro image
		$this->old_images=$this->images;
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
				$this->status=Banner::STATUS_ACTIVE;
				//Set alias
				$this->alias=iPhoenixString::createAlias($this->title).'-'.date('d').date('m').date('Y');	
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
				if($this->title != $this->old_title) $this->alias=iPhoenixString::createAlias($this->title).'-'.date('d').date('m').date('Y');
			}	
			$this->type=Article::ARTICLE_BANNER;
			$this->other=json_encode($this->list_other_attributes);
			return true;
		}
		else
			return false;
	}
	
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
		$criteria=new CDbCriteria;
		$criteria->compare('title',$this->title,true);
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
	/*
	 * Suggests a list banner which matching the specified keyword.
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
	 * Reverse status of banner
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