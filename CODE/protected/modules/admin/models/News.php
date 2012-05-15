<?php
/**
 * This is the model class for table "news".
 *
 */
class News extends CActiveRecord
{	
	public function tableName()
	{
		return 'tbl_article';
	}
	/*
	 * Config scope of news
	 */
	public function defaultScope(){
		return array(
			'condition'=>'type = '.Article::ARTICLE_NEWS,
		);	
	}
	/*
	 * Config status of album
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	
	const LIST_ADMIN=10;
	/*
	 * Config special
	 * SPECIAL_REMARK album is viewed at homepage
	 */
	const SPECIAL_REMARK=0;
	const SPECIAL_NOTICE=1;
	const SPECIAL_MARQUEE=2;
	
	const INTRO_LENGTH=100; 	
	const INTRO_HOMEPAGE_LENGTH=20;	
	const OTHER_NEWS=5;
	const LIST_NEWS=10;
	const LIST_SEARCH=10;
	
	const PRESENT_CATEGORY=30;
	const GUIDE_CATEGORY=59;
	const ALIAS_PRESENT_CATEGORY='gioi-thieu';
	const ALIAS_GUIDE_CATEGORY='huong-dan';
	const ALIAS_GUIDE_BUY_ARTICLE='huong-dan-mua-hang';
	const ALIAS_GUIDE_PAY_ARTICLE='phuong-thuc-thanh-toan';
	
	public $old_fulltext;
	public $old_introimage;
	public $list_special;
	public $old_title;
	private $config_other_attributes=array('modified','fulltext','introtext','introimage','list_suggest','metakey','metadesc');	
	private $list_other_attributes;
	/*
	 * Get list order view
	 */
	public function getList_order_view(){
		$file = dirname(__FILE__).'/../runtime/store.inc';
		$content = file_get_contents($file);
		if($content != '')
			return unserialize($content);
		else
			return array('0'=>'Không thiết lập','1'=>'Mức 1');
	}
	/*
	 * Get url
	 */
	public function getUrl()
 	{
 		$cat_alias=$this->category->alias;
 		$alias=$this->alias;
 		$url=Yii::app()->createUrl("/site/news",array('cat_alias'=>$cat_alias,'news_alias'=>$alias));
		return $url;
 	}
	/*
	 * Get thumb of video
	 */
	public function getThumb_url($type){
		if($this->introimage>0){
			$image=Image::model()->findByPk($this->introimage);
			$src=$image->getThumb('News',$type);
			return '<img class="img" src="'.$src.'" alt="'.$image->title.'">';
		}
		else {
			
			return '<img class="img" src="'.Image::getDefaultThumb('News', $type).'" alt=""';
		}
	}
	/*
	 * Get image url which view status of news
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
	
	public function getLabel_category()
 	{
		$cat=$this->category;
		return $cat->name;
 	}
	/*
	 * Get similar news
	 */
	public function getList_similar(){
		if($this->list_suggest != ''){
			$list = array_diff ( explode ( ',', $this->list_suggest ), array ('' ) );
			$result=array();
			$index=0;
			foreach ($list as $id){
				$index++;
				if($index <= Setting::s('LIMIT_SIMILAR_NEWS'))
					$result[]=News::model()->findByPk($id);
			}
		}
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('status', News::STATUS_ACTIVE);
			$criteria->addCondition('id <>'. $this->id);
			$criteria->order='id desc';
			$criteria->compare('catid',$this->catid);
			$criteria->limit=Setting::s('LIMIT_SIMILAR_NEWS');
			$result=News::model()->findAll($criteria);		
		}
		return $result;
	}	
 	/*
	 * Get all specials of class News
	 * Use in drop select when create, update news
	 */
	static function getList_label_specials()
 	{
	return array(
			self::SPECIAL_NOTICE=>'Hiển thị trong thông báo',
			self::SPECIAL_REMARK=>'Hiển thị trong phần tin nổi bật',
			self::SPECIAL_MARQUEE=>'Hiển thị trong phần tin chạy thuộc trang chủ',
		);
 	}
 	 /*
 	 * Get specials of a object news
 	 * Use in page lit admin
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
 	 /*
 	 * Special is encoded before save in database
 	 * Function get all code of the special
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
	/*
	 * Get thumb image
	 */
	public function getImage($type){
		$image=Image::model()->findByPk($this->introimage);
		if(isset($image)){
			$url='<img class="img" src="'.$image->getThumb('News',$type).'" alt="'.$image->title.'" />';
		}
		else {
			$url='<img class="img" src="'.Image::getDefaultThumb('News',$type).'" />';
		}
			return $url;	
	}
 	/**
	 * PHP setter magic method for other attributes
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
	 * @param string $className active record class name.
	 * @return News the static model class
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,catid,fulltext', 'required','message'=>'Dữ liệu bắt buộc','on'=>'write,copy'),
			array('catid,order_view', 'numerical', 'integerOnly'=>true,'message'=>'Sai định dạng','on'=>'write,copy'),
			array('title', 'length', 'max'=>256,'message'=>'Tối đa 256 kí tự','on'=>'write,copy'),
			array('introimage', 'length', 'max'=>8,'on'=>'write,copy'),
			array('fulltext,list_special,lang,list_suggest', 'safe', 'on'=>'write,copy'),
			array('created_date,created_by', 'safe', 'on'=>'copy'),
			array('introimage','safe','on'=>'upload_image'),
			array('title,catid,special,lang','safe','on'=>'search'),
			array('status','safe','on'=>'reverse_status')
		);
	}
	
	//Function validate unique title
	public function validateUniqueAlias() {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'lower(alias)', strtolower ( $this->alias) );
		if ($this->id > 0)
			$criteria->addCondition ( 'id <> ' . $this->id );
		$list = News::model ()->findAll ( $criteria );
		if (sizeof ( $list ) > 0)
			return false;
		else
			return true;
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
			'status' => 'Trạng thái',
			'title' => 'Tiêu đề',
			'introtext' => 'Tóm tắt',
			'introimage' => 'Ảnh minh họa',
			'author' => 'Tác giả',
			'created_date' => 'Thời điểm đăng tin',
			'category' => 'Thuộc danh mục',
			'fulltext' => 'Nội dung tin',
			'list_special' => 'Nhóm hiển thị',
			'special'=>'Lọc theo nhóm hiển thị',
			'catid' => 'Thuộc danh mục',
			'lang'=>'Ngôn ngữ',
			'order_view'=>'Mức ưu tiên hiển thị',
			'list_suggest'=>'Bài viết liên quan'
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
		$this->old_introimage=$this->introimage;
		//Decode text
		$fulltext=$this->fulltext;
		$this->fulltext=CHtml::decode($fulltext);
		$this->old_fulltext=$this->fulltext;
		
		//Get list special
		$this->list_special=iPhoenixStatus::decodeStatus($this->special);	
		//Decode introtext
		$introtext=$this->introtext;
		$this->introtext=CHtml::decode($introtext);
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
				$this->status=News::STATUS_ACTIVE;
				//Set alias
				$this->alias=iPhoenixString::createAlias($this->title);	
				while(!$this->validateUniqueAlias()){
					$pre=rand(1,100);
					$this->alias=$pre.'-'.$this->alias;
					}
				}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
				if($this->title != $this->old_title) $this->alias=iPhoenixString::createAlias($this->title);
				while(!$this->validateUniqueAlias()){
					$pre=rand(1,100);
					$this->alias=$pre.'-'.$this->alias;
				}
				//Handler list suggest news
				$list_clear=array_diff(explode(',',$this->list_suggest),array(''));
				$list_filter=array_diff($list_clear,array($this->id));
				$this->list_suggest=implode(',', $list_filter);
			}
			//Encode special
			$this->special=iPhoenixStatus::encodeStatus($this->list_special);		
			//Encode other attributes  		
			$this->type=Article::ARTICLE_NEWS;
			//Encode fulltext
			if($this->old_fulltext != $this->fulltext || $this->isNewRecord){
				$fulltext=$this->fulltext;
				$this->fulltext=CHtml::encode($fulltext);
				if($fulltext != "")
					$this->introtext=CHtml::encode(iPhoenixString::createIntrotext($fulltext,self::INTRO_LENGTH));
				else 
					$this->introtext="";
				}
			//Store order view
			if($this->order_view >= sizeof($this->list_order_view)-1)
			{
				$new_max_order_view=sizeof($this->list_order_view);
				$list_order_view=$this->list_order_view+array($new_max_order_view=>'Mức '.$new_max_order_view);
				$str = serialize($list_order_view);
        		$setting_file = dirname(__FILE__).'/../runtime/store.inc';
            	file_put_contents($setting_file, $str);
			}
			$this->other=json_encode($this->list_other_attributes);
			return true;
		}
		else
			return false;
	}
	
	public function afterSave(){
		if($this->old_introimage != $this->introimage){
			$introimage = Image::model()->findByPk($this->introimage);
			if(isset($introimage)){
				$introimage->parent_id=$this->id;
				if($introimage->save()) 
					return parent::afterSave();
				else 
					return false;
				}
			else 
				return true;
			}
		return true;
	}
	/**
	 * This method is invoked before delete a record 
	 */
	public function beforeDelete() {
		if (parent::beforeDelete ()) {
			//Delete images in fulltext
			$contentimages=Image::findImages($this->fulltext);
			foreach ($contentimages as $image){
				$file = Yii::getPathOfAlias ( 'webroot' ) . $image;
				if (file_exists ( $file )) {
					unlink ( $file );
				}
			}	
			//Delete introimage		
			$introimage = Image::model()->findByPk($this->introimage);
			if(isset($introimage)){
				if($introimage->delete()) 
					return true;
				else 
					return false;	
			}
			else 	
				return true;		
		}
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.	
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'lang', $this->lang );
		$criteria->compare ( 'title', $this->title, true );
		//Filter catid
		$cat = Category::model ()->findByPk ( $this->catid );
		if ($cat != null) {
			$child_categories = $cat->child_categories;
			$list_child_id = array ();
			//Set itself
			$list_child_id [] = $cat->id;
			if ($child_categories != null)
				foreach ( $child_categories as $id => $child_cat ) {
					$list_child_id [] = $id;
				}
			$criteria->addInCondition ( 'catid', $list_child_id );
		}
		if (isset ( $_GET ['pageSize'] ))
			Yii::app ()->user->setState ( 'pageSize', $_GET ['pageSize'] );
		if ($this->special != '')
			$criteria->addInCondition ( 'special', self::getCode_special ( $this->special ) );
		
		//$criteria->order="order_view DESC,id DESC";
		return new CActiveDataProvider ( $this, array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Yii::app ()->user->getState ( 'pageSize', Yii::app ()->params ['defaultPageSize'] ) ), 'sort' => array ('defaultOrder' => 'order_view DESC,id DESC' )    		
		));
	}
	/**
	 * Suggests a list of existing titles matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestTitle($keyword,$limit=20)
	{
		$list_news=$this->findAll(array(
			'condition'=>'title LIKE :keyword',
			'order'=>'title DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$titles=array();
		foreach($list_news as $news)
			$titles[]=$news->title;
			return $titles;
	}
	/*
	 * Set status of news
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
		/*
	 * Copy news
	 */
	static function copy($id) {
		$sql = 'insert into ' . self::model ()->tableName () . ' (catid,type,lang,status,special,order_view,title,alias,keywords,other,created_date,created_by) select catid,type,lang,status,special,order_view,title,alias,keywords,other,created_date,created_by from ' . self::model ()->tableName () . ' where id=' . $id;
		$command = Yii::app ()->db->createCommand ( $sql );
		if ($command->execute ()) {
			$copy_id = Yii::app ()->db->getLastInsertID ();
			$model = News::model ()->findByPk ( $copy_id );
			$model->scenario = 'copy';
			$model->title = $model->title . ' - Copy ';
			$model->alias=$model->alias . '-copy';
			while(!$model->validateUniqueAlias()){
				$pre=rand(1,100);
				$model->alias=$pre.'-'.$model->alias;
			}
			$model->created_date = time ();
			$model->introimage=Image::copy($model->introimage,$model->id);			
			$model->created_by = Yii::app ()->user->id;
			if ($model->save ()) {
				return $model;
			}
		} else
			return null;
	}
}