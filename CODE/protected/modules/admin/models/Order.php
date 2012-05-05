<?php
class Order extends CActiveRecord
{
	public function tableName()
	{
		return 'article';
	}
	/*
	 * Config scope of news
	 */
	public function defaultScope(){
	if(isset(Yii::app()->session['lang'])  && Yii::app()->session['lang'] == 'en')
			return array(
			'condition'=>'type = '.Article::ARTICLE_ORDER.' AND lang = '.Article::LANG_EN,
		);
		else 
			return array(
			'condition'=>'type = '.Article::ARTICLE_ORDER,
		);	
	}
	/*
	 * Config status of contact
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	
	const LIST_ADMIN=10;
	const SIZE_INTRO_CONTENT=50;

	// array('product_id1'=>'amount1','product_id2'=>'amount2',...)
	public $start_time=null;
	public $stop_time=null;
	public $list_item;
	public $old_answer;
	private $config_other_attributes = array('activekey','address',
											'modified','content','phone','email',
											'fullname','metakey','metadesc',
											'PaySex','PayFullname','PayAddress','PayPhone',
											'DelSex','DelFullname','DelAddress','DelPhone',
											'payment_type','sum');
	public $list_other_attributes;

	/*
	 * Decode content from list item in database for viewing
	*/
	public function getOrder_Content($content){
		$order_content = '';
		foreach($content as $code => $amount){
				$product_name=Yii::app()->db->createCommand()
				->select('name')
				->from('product')
				->where('code=:code',array(':code'=>$code))
				->queryall();
			if($product_name){
				$order_content .=" <br/> Sản phẩm: ".$product_name[0]['name']." - Số lượng: ".$amount;
			}
		}		
		return ($order_content);
	}
	/*
	 * Get image url which view status of contact
	 */
 	public function getImageStatus()
 	{
 		switch ($this->status) {
 			case self::STATUS_ACTIVE: 
 				return Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				return Yii::app()->request->baseUrl.'/images/admin/disable.png';
 				break;
 		}	
 	}
 	public function getImageProcessStatus()
 	{
 		switch ($this->process_status) {
 			case self::STATUS_ACTIVE: 
 				return Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				return Yii::app()->request->baseUrl.'/images/admin/disable.png';
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
			array('fullname,phone,email,address,PayFullname,PayAddress,PayPhone,DelFullname,DelAddress,DelPhone, payment_type','required','message'=>'Dữ liệu bắt buộc','on'=>'create',),
			array('content', 'length', 'max'=>1024,'message'=>'Tối đa 1024 kí tự','on'=>'create'),
			array('email','email','message'=>'Sai dịnh dạng mail','on'=>'create'),
			array('phone', 'length', 'max'=>13,'message'=>'Tối đa 13 kí tự','on'=>'create'),
			array('status, process_status, sum','safe','on'=>'search'),
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
			'id'=> 'Mã đơn hàng',
			'content' => 'Nội dung',
			'phone'=>'Số điện thoại',
			'email'=>'Email',
			'address'=>'Đại chỉ',
			'fullname'=>'Người đặt đơn',
			'created_date'=>'Thời điểm đặt đơn',
			'PayFullname'=>'Họ và tên',
			'PaySex'=>'Danh xưng',
			'PayAddress'=>'Địa chỉ',
			'PayPhone'=>'Điện thoại',
			'DelFullname'=>'Họ và tên',
			'DelSex'=>'Danh xưng',
			'DelAddress'=>'Địa chỉ',
			'DelPhone'=>'Điện thoại',
			'payment_type'=>'Hình thức thanh toán',
			'status'=>'Kích hoạt',
			'process_status'=>'Xử lý',	
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
		//Decode list item
		$this->list_item=(array)json_decode($this->content);
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
				$this->status=Order::STATUS_PENDING;
				$this->process_status = Order::STATUS_PENDING;
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
			}	
			$this->type=Article::ARTICLE_ORDER;
			//Encode list item
			$this->content=json_encode($this->list_item);
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
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('status',$this->status);
		$criteria->compare('process_status',$this->process_status);
		if($this->start_time !=null){			
			$criteria->addCondition('created_date >'.$this->start_time);
		}
		
		if($this->stop_time !=null){			
			$criteria->addCondition('created_date <='.$this->stop_time);
		}		
		if (isset ( $_GET ['pageSize'] ))
			Yii::app ()->user->setState ( 'pageSize', $_GET ['pageSize'] );
		$criteria->order="id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array (
				'pageSize' => Yii::app ()->user->getState ( 'pageSize', Yii::app ()->params ['defaultPageSize'] )),
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
		$list_contact=$this->findAll(array(
			'condition'=>'title LIKE :keyword',
			'order'=>'title DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$titles=array();
		foreach($list_contact as $contact)
			$titles[]=$contact->title;
			return $titles;
	}
	/*
	 * Set status of contact
	 */
	static function reverseStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('status')
		->from('article')
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
		$sql='UPDATE article SET status = '.$status.' WHERE id = '.$id;
		$command=Yii::app()->db->createCommand($sql);
		if($command->execute()) {
			switch ($status) {
 			case self::STATUS_ACTIVE: 
 				$src=Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				$src=Yii::app()->request->baseUrl.'/images/admin/disable.png';
 				break;
 		}	
			return $src;
		}
		else return false;
	}
	
/*
	 * Set status of contact
	 */
	static function reverseProcessStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('process_status')
		->from('article')
		->where('id=:id',array(':id'=>$id))
		->queryRow();
		switch ($command['process_status']){
			case self::STATUS_PENDING:
				 $status=self::STATUS_ACTIVE;
				 break;
			case self::STATUS_ACTIVE:
				$status=self::STATUS_PENDING;
				break;
		}
		$sql='UPDATE article SET process_status = '.$status.' WHERE id = '.$id;
		$command=Yii::app()->db->createCommand($sql);
		if($command->execute()) {
			switch ($status) {
 			case self::STATUS_ACTIVE: 
 				$src=Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				$src=Yii::app()->request->baseUrl.'/images/admin/disable.png';
 				break;
 		}	
			return $src;
		}
		else return false;
	}
}