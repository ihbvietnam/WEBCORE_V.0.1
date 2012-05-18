<?php
class Product extends CActiveRecord
{
	public function tableName()
	{
		return 'tbl_product';
	}
	/*
	 * Config status of product
	*/
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	/*
	 * Config special
	 * SPECIAL_REMARK product is viewed at homepage
	 */
	const SPECIAL_REMARK=0;
	const SPECIAL_BESTSELLER=1;
	
	const LIST_PRODUCT=1;
	const LIST_SEARCH=1;
	const LIST_ORDER=10;
	
	const LIST_ADMIN=10;
	const PRESENT_CATEGORY=31;
	
	static $config_unit_price = array('VND'=>'VND');
	public $old_video;
	public $old_introimage;
	public $old_name;
	public $list_special;
	private $config_other_attributes=array('list_suggest','modified','unit','year','warranty','parameter','description','unit_price','introimage','otherimage','metakey','metadesc');	
	private $list_other_attributes;
	
	/*
	 * Get image url which view status of product 
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
	/*
	 * Get image url which view amount status of product 
	 */
 	public function getImageAmountStatus()
 	{
 		switch ($this->amount_status) {
 			case self::STATUS_ACTIVE: 
 				return Yii::app()->request->baseUrl.'/images/admin/enable.png';
 				break;
 			case self::STATUS_PENDING:
 				return Yii::app()->request->baseUrl.'/images/admin/disable.png';
 				break;
 		}	
 	}
 	/*
 	 * Get url
 	 */
 	public function getUrl(){
		$cat_alias=$this->category->alias;
 		$alias=$this->alias;
		$url=Yii::app()->createUrl("product/view",array('cat_alias'=>$cat_alias,'product_alias'=>$alias)); 
		return $url;
	}
 	
 	/*
	 * Get thumb of video
	 */
	public function getThumb_url($type){
		if($this->introimage>0){
			$image=Image::model()->findByPk($this->introimage);
			$src=$image->getThumb('Product',$type);
			return '<img class="img" src="'.$src.'" alt="'.$image->title.'">';
		}
		else {
			
			return '<img class="img" src="'.Image::getDefaultThumb('Product', $type).'" alt=""';
		}
	}
	/*
	 * Get similar product
	 */
	public function getList_similar(){
		if($this->list_suggest != ''){
			$list = array_diff ( explode ( ',', $this->list_suggest ), array ('' ) );
			$result=array();
			$index=0;
			foreach ($list as $id){
				$index++;
				if($index <= Setting::s('LIMIT_SIMILAR_PRODUCT','Product'))
					$result[]=Product::model()->findByPk($id);
			}
		}
		else {
			$criteria=new CDbCriteria;
			$criteria->compare('status', Product::STATUS_ACTIVE);
			$criteria->order='id desc';
			$criteria->compare ( 'status', QA::STATUS_ACTIVE );
			$criteria->compare('catid',$this->catid);
			$criteria->limit=Setting::s('LIMIT_SIMILAR_PRODUCT','Product');
			$criteria->addCondition('id <>'. $this->id);
			$result=Product::model()->findAll($criteria);		
		}
		return $result;
	}
	/*
	 * Get all specials of class Album
	 * Use in drop select when create, update album
	 */
	static function getList_label_specials()
 	{
		return array(
			self::SPECIAL_REMARK=>'Hiển thị trong phần sản phẩm nổi bật',
			self::SPECIAL_BESTSELLER=>'Hiển thị trong phần sản phẩm bán chạy',
		);
 	}	
 	/*
 	 * Get specials of a object album
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
			array('name,catid,code,introimage,manufacturer_id','required','message'=>'Dữ liệu bắt buộc','on'=>'write'),
			array('description,parameter', 'length', 'max'=>1024,'message'=>'Tối đa 1024 kí tự','on'=>'write'),
			array('list_special,lang,unit_price,otherimage,list_suggest', 'safe','on'=>'write'),
			array('num_price', 'numerical', 'integerOnly'=>true,'message'=>'Sai định dạng','on'=>'write'),
			array('name,lang, manufacturer_id, catid,special, amount_status','safe','on'=>'search'),
			array('introimage','safe','on'=>'upload_image'),		
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
			'manufacturer'=>array(self::BELONGS_TO,'Category','manufacturer_id'),
			'author'=>array(self::BELONGS_TO,'User','created_by')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Tên sản phẩm',
			'catid'=>'Nhóm sản phẩm',
			'manufacturer_id'=>'Nhà sản xuất',
			'code'=>'Mã sản phẩm',
			'unit'=>'Đơn vị tính',
			'price'=>'Giá',
			'year'=>'Năm sản xuất',
			'created_by' => 'Người tạo',
			'created_date'=>'Ngày tạo',
			'list_special'=>'Hiển thị',
			'model'=>'Kiểu dáng',
			'description'=>'Miêu tả',
			'unit_price'=>'Đơn vị tiền',
			'special'=>'Trạng thái hiển thị',
			'introimage'=>'Ảnh giới thiệu',
			'otherimage'=>'Các ảnh khác',
			'amount_status'=>'Trạng thái',
			'list_suggest'=>'Sản phẩm liên quan'
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
		//Store old video
		//$this->old_video=$this->video;
		//Store introimage 
		$this->old_introimage=$this->introimage;
		//Get list special
		$this->list_special=iPhoenixStatus::decodeStatus($this->special);
		//Store old name
		$this->old_name=$this->name;
		
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
				$this->status=PRODUCT::STATUS_ACTIVE;
				//Set alias
				$this->alias=iPhoenixString::createAlias($this->name).'-'.date('d').date('m').date('Y');	
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified=json_encode($modified);	
				if($this->name != $this->old_name) $this->alias=iPhoenixString::createAlias($this->name).'-'.date('d').date('m').date('Y');
				//Handler list suggest news
				$list_clear=array_diff(explode(',',$this->list_suggest),array(''));
				$list_filter=array_diff($list_clear,array($this->id));
				$this->list_suggest=implode(',', $list_filter);
			}	
			//Encode special
			$this->special=iPhoenixStatus::encodeStatus($this->list_special);
			$this->other=json_encode($this->list_other_attributes);
			return true;
		}
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
			$introimage = Image::model()->findByPk($this->introimage);
			if(isset($introimage)){
				if($introimage->delete()) 
					return true;
				else 
					return false;	
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
		

		$criteria = new CDbCriteria ();
		$criteria->compare ( 'lang', $this->lang );
		$criteria->compare ( 'name', $this->name, true );
		$criteria->compare ('amount_status',$this->amount_status);		
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
		//Filter manufacturer
		$cat = Category::model ()->findByPk ( $this->manufacturer_id );
		if ($cat != null) {
			$child_categories = $cat->child_categories;
			$list_child_id = array ();
			//Set itself
			$list_child_id [] = $cat->id;
			if ($child_categories != null)
				foreach ( $child_categories as $id => $child_cat ) {
					$list_child_id [] = $id;
				}
			$criteria->addInCondition ( 'manufacturer_id', $list_child_id );
		}
		$criteria->order = "id DESC";
		if (isset ( $_GET ['pageSize'] ))
			Yii::app ()->user->setState ( 'pageSize', $_GET ['pageSize'] );
		if ($this->special != '') {
			$criteria->addInCondition ( 'special', self::getCode_special ( $this->special ) );
		}
		return new CActiveDataProvider ( $this, array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Yii::app ()->user->getState ( 'pageSize', Yii::app ()->params ['defaultPageSize'] ) ) ) );
	}
	/**
	 * Suggests a list of existing names matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestName($keyword,$limit=20)
	{
		$list_qa=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'name DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($list_qa as $qa)
			$names[]=$qa->name;
			return $names;
	}
	/*
	 * Set status of qa
	 */
	static function reverseStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('status')
		->from('tbl_product')
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
		$sql='UPDATE tbl_product SET status = '.$status.' WHERE id = '.$id;
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
	 * Set status of qa
	 */
	static function reverseAmountStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('amount_status')
		->from('tbl_product')
		->where('id=:id',array(':id'=>$id))
		->queryRow();
		switch ($command['amount_status']){
			case self::STATUS_PENDING:
				 $status=self::STATUS_ACTIVE;
				 break;
			case self::STATUS_ACTIVE:
				$status=self::STATUS_PENDING;
				break;
		}
		$sql='UPDATE tbl_product SET amount_status = '.$status.' WHERE id = '.$id;
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

	// Get list manufacturer
	public static function getManufacturerOption()
	{
		//List manufacturer
		$group=new Category();		
		$group->group=Category::GROUP_MANUFACTURER;
		$list=$group->list_categories;
		//$temp=Category::model()->findByPk(190);		
		$list_manufacturer=array();
		foreach ($list as $id=>$manufacturer){			
			//var_dump($manufacturer['parent_id']);
			//exit;
			$tmp = Category::model()->findByPk($id);
			if($tmp['parent_id']==Category::GROUP_MANUFACTURER) 
				$list_manufacturer[$id]=$manufacturer['name'];
		}
		
		return $list_manufacturer;
	}
	
	
		// Get all list manufacturer
	public static function getAllManufacturerOption()
	{
		//List manufacturer
		$group=new Category();		
		$group->group=Category::GROUP_MANUFACTURER;
		$list=$group->list_categories;
		//$temp=Category::model()->findByPk(190);		
		$list_manufacturer=array();
		foreach ($list as $id=>$manufacturer){			
			//var_dump($manufacturer['parent_id']);
			//exit;
			$tmp = Category::model()->findByPk($id);
			$list_manufacturer[$id]=$manufacturer['name'];
		}
		
		return $list_manufacturer;
	}
	
	// Get all category option	
	public static function getAllCategoryOption()
	{
		//List manufacturer
		$group=new Category();		
		$group->group=Category::GROUP_PRODUCT;
		$list=$group->list_categories;		
		$list_manufacturer=array();
		foreach ($list as $id=>$manufacturer){			
			$tmp = Category::model()->findByPk($id);
			$list_manufacturer[$id]=$manufacturer['name'];
		}
		
		return $list_manufacturer;
	}
	
	public function checkprice()
	{
		$returnvalue = $this->num_price;
		if($returnvalue == '')
		{
			$returnvalue = CHtml::link('Hỏi Hàng',array('site/contactproduct'));
		}
		
		return $returnvalue;
	}
}