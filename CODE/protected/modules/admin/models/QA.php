<?php
class QA extends CActiveRecord
{
	public function tableName()
	{
		return 'tbl_article';
	}
	/*
	 * Config scope of news
	 */
	public function defaultScope(){
		if(isset(Yii::app()->session['lang'])  && Yii::app()->session['lang'] == 'en')
			return array(
			'condition'=>'type = '.Article::ARTICLE_QA.' AND lang = '.Article::LANG_EN,
		);
		elseif(isset(Yii::app()->session['lang'])  && Yii::app()->session['lang'] == 'vi')
			return array(
			'condition'=>'type = '.Article::ARTICLE_QA.' AND lang = '.Article::LANG_VI,
		);
		elseif(isset(Yii::app()->session['lang'])  && Yii::app()->session['lang'] == 'all')
			return array(
			'condition'=>'type = '.Article::ARTICLE_QA,
		);
		else 
			return array(
			'condition'=>'type = '.Article::ARTICLE_QA.' AND lang = '.Article::LANG_VI,
		);	
	}
	/*
	 * Config status of qa
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	const STATUS_NOT_ANSWER=2;
	const STATUS_ANSWER=3;	
	const LIST_QA=10;
	const OTHER_QA=5;
	const LIST_ADMIN=10;
	
	const SIZE_INTRO_QUESTION=70;
	
	public $old_answer;
	public $old_title;
	private $config_other_attributes=array('modified','question','answer','phone','email','fullname','metakey','metadesc');	
	private $list_other_attributes;
	/*
	 * Get url
	 */
	public function getUrl()
 	{		
 		$url=Yii::app()->createUrl("site/qa",array('qa_alias'=>$this->alias));
		return $url;
 	}	
	/*
	 * Get link answer in list admin
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
	/*
	 * Get image url which view status of qa
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
			array('fullname,title,question,email','required','message'=>'Dữ liệu bắt buộc','on'=>'question',),
			array('title', 'length', 'max'=>256,'message'=>'Tối đa 256 kí tự','on'=>'question'),
			array('question', 'length', 'max'=>1024,'message'=>'Tối đa 1024 kí tự','on'=>'question'),
			array('email','email','message'=>'Sai dịnh dạng mail','on'=>'question'),
			array('phone', 'length', 'max'=>13,'message'=>'Tối đa 13 kí tự','on'=>'question'),
			array('answer,lang','safe','on'=>'answer'),
			array('lang', 'numerical', 'integerOnly'=>true,'message'=>'Sai định dạng','on'=>'answer,question'),
			array('title,status,lang','safe','on'=>'search'),
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
			'lang'=>'Ngôn ngữ'
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
				$this->status=QA::STATUS_NOT_ANSWER;
				//Set alias
				$this->alias=iPhoenixString::createAlias($this->title).'-'.date('d').date('m').date('Y');	
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
				if($this->title != $this->old_title) $this->alias=iPhoenixString::createAlias($this->title).'-'.date('d').date('m').date('Y');
			}	
			$this->type=Article::ARTICLE_QA;
			//Encode answer
			if($this->old_answer != $this->answer){
				$answer=$this->answer;
				$this->answer=CHtml::encode($answer);				
				}
			if($this->answer != "" && $this->status != QA::STATUS_PENDING){
				$this->status=QA::STATUS_ACTIVE;				
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
		if($this->status==self::STATUS_ANSWER){
			$criteria->addInCondition('status', array(self::STATUS_ACTIVE,self::STATUS_PENDING));
		}
		else {
			$criteria->compare('status',$this->status);
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
	/*
	 * Set status of qa
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
			case self::STATUS_NOT_ANSWER:
				$status=self::STATUS_NOT_ANSWER;
				break;
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