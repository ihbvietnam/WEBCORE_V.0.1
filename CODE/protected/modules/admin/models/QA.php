<?php
/**
 * 
 * QA class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
/**
 * This is the model class for table "qa".
 */
class QA extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */	
	public function tableName()
	{
		return 'tbl_article';
	}
	/**
	 * Config scope of news
	 */
	public function defaultScope(){
		return array(
			'condition'=>'type = '.Article::ARTICLE_QA,
		);	
	}
	/**
	 * Config status of qa
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	
	const STATUS_NOT_ANSWER=0;
	const STATUS_ANSWER=1;
	
	const LIST_QA=10;
	const OTHER_QA=5;
	const LIST_ADMIN=10;
	
	const SIZE_INTRO_QUESTION=70;
	
	public $old_answer;
	public $old_title;
	/**
	 * @var array config list other attributes of the banner
	 * this attribute no need to search	 
	 */	
	private $config_other_attributes=array('modified','question','answer','address','phone','email','fullname','metakey','metadesc');	
	private $list_other_attributes;
	public $list_special;
	/*
	 * Config special
	 * SPECIAL_REMARK album is viewed at homepage
	 */
	const SPECIAL_ANSWER=1;
	const SPECIAL_REMARK=0;

	/**
	 * Get url of this image
	 * @return string $url, url of this image
	 */
	public $status_answer;
	public function getUrl()
 	{		
 		$url=Yii::app()->createUrl("qA/view",array('qa_alias'=>$this->alias));
		return $url;
 	}
	/**
	 * Display link answer in admin qa page
	 * @return CHtml link to update the qa
	 */
	static function getList_label_specials()
 	{
	return array(
			self::SPECIAL_REMARK=>'Hiển thị trong phần câu hỏi nổi bật',
			self::SPECIAL_ANSWER=>'Đã trả lời'
		);
 	}
	/*
 	 * Get specials of a object qa
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
	 * Get similar news
	 */
	public function getList_similar() {
		$criteria = new CDbCriteria ();
		$criteria->addCondition('id <>'. $this->id);
		$criteria->compare ( 'status', QA::STATUS_ACTIVE );
		$criteria->addInCondition ( 'special', QA::getCode_special ( QA::SPECIAL_ANSWER ) );
		$criteria->order = 'id desc';
		$criteria->limit = Setting::s ( 'LIMIT_SIMILAR_QA','QA' );
		$result = QA::model ()->findAll ( $criteria );
		return $result;
	}			
	/**
	 * Display link answer in admin qa page
	 * @return CHtml link to update the qa
	 */
	public function getLink_answer(){
		if($this->answer!= "")
		{
			return CHtml::link('Xem câu trả lời',array('update','id'=>$this->id));
		}
		else {
			return CHtml::link('Trả lời',array('update','id'=>$this->id));
		}
	}
	/**
	 * Get image url which display status of contact
	 * @return string path to enable.png if this status is STATUS_ACTIVE
	 * path to disable.png if status is STATUS_PENDING
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
 			case self::STATUS_NOT_ANSWER:
 				return Yii::app()->request->getBaseUrl(true).'/images/admin/disable.png';
 				break;
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
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
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
			array('title,question','required','message'=>'Dữ liệu bắt buộc'),
			array('answer','required','message'=>'Dữ liệu bắt buộc','on'=>'create,answer',),
			array('title', 'length', 'max'=>256,'message'=>'Tối đa 256 kí tự'),
			array('question', 'length', 'max'=>1024,'message'=>'Tối đa 1024 kí tự'),
			array('email','email','message'=>'Sai dịnh dạng mail'),
			array('phone', 'length', 'max'=>13,'message'=>'Tối đa 13 kí tự'),
			array('list_special','safe','on'=>'create,answer'),
			array('address,lang,fullname', 'safe'),
			array('title,status,lang,status_answer,special','safe','on'=>'search'),
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
			'title' => 'Tiêu đề',
			'answer' => 'Câu trả lời',
			'question' => 'Câu hỏi',
			'phone'=>'Số điện thoại',
			'email'=>'Email',
			'fullname'=>'Họ và tên',
			'created_date'=>'Thời điểm đặt câu hỏi',
			'lang'=>'Ngôn ngữ',
			'list_special' => 'Hiển thị',
			'special'=>'Hiển thị'
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
		//Store old title
		$this->old_title=$this->title;
		//Decode answer
		if($this->answer != ""){
			$answer=$this->answer;
			$this->answer=CHtml::decode($answer);
			$this->old_answer=$this->answer;
		}
		//Get list special
		$this->list_special=iPhoenixStatus::decodeStatus($this->special);
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
				$this->status=News::STATUS_ACTIVE;
				//Set alias
				$this->alias=iPhoenixString::createAlias($this->title).'-'.date('d').date('m').date('Y');						
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
				if($this->title != $this->old_title) $this->alias=iPhoenixString::createAlias($this->title).'-'.date('d').date('m').date('Y');
			}	
			if($this->answer !="" && !in_array(self::SPECIAL_ANSWER, $this->list_special)){
					$list=$this->list_special;
					$list[]=self::SPECIAL_ANSWER;
					$this->list_special=$list;
				}
			//Encode special
			$this->special=iPhoenixStatus::encodeStatus($this->list_special);
			$this->type=Article::ARTICLE_QA;
			//Encode answer
			if($this->old_answer != $this->answer){
				$answer=$this->answer;
				$this->answer=CHtml::encode($answer);				
				}
			$this->other=json_encode($this->list_other_attributes);			
			return true;
		}
		else
			return false;
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
		//Filter special
		if ($this->special != ''){
			$criteria->addInCondition ( 'special', self::getCode_special ( $this->special ) );
		}
		//Filter answer
		if($this->status_answer !== ''){
			if ($this->status_answer == self::STATUS_ANSWER)
				$criteria->addInCondition ( 'special', self::getCode_special ( self::SPECIAL_ANSWER ) );
			if ($this->status_answer == self::STATUS_NOT_ANSWER)
				$criteria->addNotInCondition('special', self::getCode_special ( self::SPECIAL_ANSWER ) );
		}
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
	 * Suggests a list of existing titles matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
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
	 * Change status of image
	 * @param integer $id, the ID of image model
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