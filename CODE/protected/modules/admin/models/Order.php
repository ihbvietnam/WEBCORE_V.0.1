<?php
/**
 * 
 * Order class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
/**
 * This is the model class for table "order".
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */	
	public function tableName()
	{
		return 'tbl_order';
	}
	/**
	 * Config status of order
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	
	const LIST_ADMIN=10;
	const SIZE_INTRO_CONTENT=50;
	
	public $start_time=null;
	public $stop_time=null;
	public $list_item;
	public $old_answer;
	/**
	 * @var array config list other attributes of the banner
	 * this attribute no need to search	 
	 */	
	private $config_other_attributes = array('modified','address','content','phone','email','fullname','note','metakey','metadesc');
	public $list_other_attributes;

   /**
	* Decode content from list item in database to for displaying
	* @param array $content, array of {product_id=>amount} in this order 
	*/
	public function getOrder_content(){
		$order_content = '';
		foreach($this->list_item as $id => $content){
			$content=(array)$content;
			$product=Product::model()->findByPk($id);
			if(isset($product)){
				$order_content .=" Sản phẩm: ".$product->name." - Số lượng: ".$content['amount']." - Giá: ".number_format($content['num_price'], 0, ',', '.')." ".$content['unit_price'].'</br>';
			}
		}		
		return ($order_content);
	}

	/*
	 * Get total order
	*/
	public function getOrder_value(){
		$value=0;
		foreach($this->list_item as $id => $content){
			$content=(array)$content;
			$product=Product::model()->findByPk($id);
			if(isset($product)){
				$value +=$content['amount']*$content['num_price'];
			}
		}		
		return number_format($value, 0, ',', '.').' '.$content['unit_price'];
	}

	
	/**
	 * Get image url which display status of order (representing the actived action of customers)
	 * @return string path to enable.png if this status is STATUS_ACTIVE
	 * path to disable.png if status is STATUS_PENDING
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

	/**
	 * Get image url which display processing status of order (representing the actived processing of shoper)
	 * @return string path to enable.png if this status is STATUS_ACTIVE
	 * path to disable.png if status is STATUS_PENDING
	 */ 	
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
			array('fullname,address,phone','required','message'=>'Dữ liệu bắt buộc','on'=>'create',),
			array('note', 'length', 'max'=>1024,'message'=>'Tối đa 1024 kí tự','on'=>'create'),
			array('email','email','message'=>'Sai dịnh dạng mail','on'=>'create'),
			array('phone', 'length', 'max'=>13,'message'=>'Tối đa 13 kí tự','on'=>'create'),
			array('phone', 'length', 'max'=>13,'message'=>'Tối đa 13 kí tự','on'=>'create'),
			array('status, process_status','safe','on'=>'search'),
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
			'phone'=>'Điện thoại',
			'email'=>'Email',
			'address'=>'Địa chỉ',
			'fullname'=>'Họ và tên',
			'created_date'=>'Thời điểm đặt đơn',
			'status'=>'Kích hoạt',
			'process_status'=>'Xử lý',	
			'note'=>'Ghi chú',
			'order_content'=>'Chi tiết',
			'order_value'=>'Tổng giá trị'
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
	/**
	 * Change status of order
	 * @param integer $id, the ID of order model
	 */
	static function reverseStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('status')
		->from('tbl_order')
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
		$sql='UPDATE tbl_order SET status = '.$status.' WHERE id = '.$id;
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
	
	/**
	 * Change processing status of order
	 * @param integer $id, the ID of order model
	 */
	static function reverseProcessStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('process_status')
		->from('tbl_order')
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
		$sql='UPDATE tbl_order SET process_status = '.$status.' WHERE id = '.$id;
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