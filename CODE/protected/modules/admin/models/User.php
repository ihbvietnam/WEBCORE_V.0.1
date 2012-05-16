<?php

/**
 * 
 * User class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */
/**
 * This is the model class for table "tbl_user".
 */
class User extends CActiveRecord
{
	/**
	 * config times typing password
	 */
	const LIMIT_INCORRECT=5;
	/**
	 * config user status
	 */
	const STATUS_PENDING=0;
	const STATUS_ACTIVE=1;
	
	const LIST_ADMIN=10;
	/**
	 * @var array config list other attributes of the banner
	 * this attribute no need to search	 
	 */		
	private $config_other_attributes=array('subscribe','firstname','lastname','phone','address','register_date','last_visit_date');	
	private $list_other_attributes;

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
 				
 		}	
 	}
 	/**
	 * Get list label status, used in dropDownList
	 * @return array, status of user
	 */	
 	public function getList_label_status(){
 		return array(
 				self::STATUS_PENDING=>'Disable',
 				self::STATUS_ACTIVE=>'Enable',
 		);
 	}
 	
 	/**
 	 * 
 	 * config role of users
 	 * @var array $list_roles
 	 */
	private $list_roles=array('admin','author','editor','manager_account');
	
	/**
	 * 
	 * get label for user roles, used in dropDownList
	 */
	public function getList_label_roles()
 	{
	return array(
			'admin'=>'Administrator',
			'editor'=>'Editor',
			'author'=>'Author',
			'manager_account'=>'Manager Account'
		);
 	}
	/**
	 * 
	 * PHP getter magic method for virtual property list_label_roles
	 */
 	public function getLabel_role()
 	{
		$label_role=array();
		foreach ($this->role as $role) {
			$label_role []= $this->list_label_roles[$role];
		}
		return $label_role;
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
	
	public  $old_password,$clear_password,$retype_password;
	//Define attribute role, old_role and set default
	public $role=array();
	public $old_role=array();
	
	/**
	 * Get full name of user
	 * @return string fullname of user
	 */
	public function getFullname(){
		if(isset($this->list_other_attributes['firstname'])&&isset($this->list_other_attributes['lastname']))
			return $this->list_other_attributes['firstname']." ".$this->list_other_attributes['lastname'];
		else 
			if(isset($this->list_other_attributes['firstname'])||isset($this->list_other_attributes['lastname']))
				return isset($this->list_other_attributes['firstname'])?$this->list_other_attributes['firstname']:$this->list_other_attributes['lastname'];
			else 	
				return '';
	}	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//Define rules for the scenarios create
			array('username,clear_password, retype_password,email','required','message'=>'Dữ liệu bắt buộc','on'=>'create',),
			array('username,email', 'unique','message'=>'Username đã được sử dụng','on'=>'create'),
			array('status', 'in', 'range'=>array(self::STATUS_PENDING,self::STATUS_ACTIVE),'on'=>'create'),			
			array('role', 'validatorRole','on'=>'create'),
			array('retype_password', 'compare', 'compareAttribute'=>'clear_password','message'=>'Gõ lại chưa khớp','on'=>'create'),
			array('email','email','message'=>'Sai dịnh dạng mail','on'=>'create'),
			array('phone', 'length', 'max'=>16,'message'=>'Tối đa 16 kí tự','on'=>'create'),
			array('clear_password, retype_password,username, email,firstname, lastname', 'length', 'max'=>32,'message'=>'Tối đa 32 kí tự','on'=>'create'),
			array('address', 'length', 'max'=>128,'message'=>'Tối đa 128 kí tự','on'=>'create'),
			//Define rules for the scenarios update
			array('email', 'required','message'=>'Dữ liệu bắt buộc','on'=>'update'),
			array('email', 'unique','message'=>'Email đã được sử dụng','on'=>'update'),
			array('status', 'in', 'range'=>array(self::STATUS_PENDING,self::STATUS_ACTIVE),'on'=>'update'),
			array('role', 'validatorRole','on'=>'update'),
			array('email','email','message'=>'Sai dịnh dạng mail','on'=>'update'),
			array('phone', 'length', 'max'=>16,'message'=>'Tối đa 16 kí tự','on'=>'update'),
			array('email,firstname, lastname', 'length', 'max'=>32,'message'=>'Tối đa 32 kí tự','on'=>'update'),
			array('address', 'length', 'max'=>128,'message'=>'Tối đa 128 kí tự','on'=>'update'),
			//Define rules for the scenarios reset password
			array('clear_password, retype_password', 'required','message'=>'Dữ liệu bắt buộc','on'=>'reset_password'),
			array('retype_password', 'compare', 'compareAttribute'=>'clear_password','message'=>'Gõ lại chưa khớp','on'=>'reset_password'),
			array('clear_password, retype_password,username', 'length', 'max'=>32,'message'=>'Tối đa 32 kí tự','on'=>'reset_password'),
			//Define rules for the scenarios change password
			array('old_password,clear_password, retype_password', 'required','message'=>'Dữ liệu bắt buộc','on'=>'change_password'),
			array('old_password','validatorOldPassword','on'=>'change_password'),
			array('retype_password', 'compare', 'compareAttribute'=>'clear_password','message'=>'Gõ lại chưa khớp','on'=>'change_password'),
			array('clear_password, retype_password,username', 'length', 'max'=>32,'message'=>'Tối đa 32 kí tự','on'=>'change_password'),
			//Define rules for the scenarios search 
			array('username, email', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * 
	 * Function validator role
	 * @param unknown_type $attributes
	 * @param unknown_type $params
	 */
	public function validatorRole($attributes,$params){
		if(sizeof(array_diff($this->role,$this->list_roles))>0){
			$this->addError('role', 'Không tồn tại quyền này');
		}
	}
	/**
	 * 
	 * Function validator role
	 * @param unknown_type $attributes
	 * @param unknown_type $params
	 */
	public function validatorOldPassword($attributes,$params){
		$user=User::model()->findByPk(Yii::app()->user->id);
		if(!$user->validatePassword($this->old_password)){
			$this->addError('old_password','Password không chính xác');
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'role' => 'Quyền',
			'status' => 'Trạng thái',
			'lastname'=> 'Tên',
			'firstname'=> 'Họ',
			'fullname'=> 'Họ và tên',
			'address'=> 'Địa chỉ',
			'phone'=> 'Điện thoại',
			'register_date'=> 'Ngày đăng ký',
			'last_visit_date'=> 'Ngày đăng nhập gần nhất',
			'activation'=> 'Mã kích hoạt',
			'subscribe'=> 'Đăng kí nhận tin',
			'old_password'=> 'Password cũ',
			'clear_password'=> 'Password',
			'retype_password'=> 'Gõ lại password'
		);
	}
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterConstruct()
	{
		//Set default for attribute status
		$this->list_other_attributes['status']=User::STATUS_PENDING;
		return parent::afterConstruct();
	}
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterFind()
	{
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);	
		//Set role of user
		$list_roles=Yii::app()->authManager->getRoles($this->id);
		foreach ($list_roles as $name=>$role){
			$this->role[]=$name;
		}
		//Set old_role 
		$this->old_role=$this->role;
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
				$this->register_date=time();
				$this->last_visit_date=time();
			}	
			//Encode other attributes  			
			$this->other=json_encode($this->list_other_attributes);
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
	public function afterSave()
	{
		$this->addRoles(array_values(array_diff($this->role,$this->old_role)));
		$this->removeRoles(array_values(array_diff($this->old_role,$this->role)));
		parent::afterSave();
	}
	//Handler add and romove roles
	public function addRoles($list)
	{
		foreach ($list as $role){
			Yii::app()->authManager->assign($role,$this->id);
		}
	}
	public function removeRoles($list)
	{
		foreach ($list as $role){
			Yii::app()->authManager->revoke($role,$this->id);
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
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
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}
	/**
	 * Generates the password hash.
	 * @param string password
	 * @param string salt
	 * @return string hash
	 */
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}

	/**
	 * Generates a salt that can be used to generate a password hash.
	 * @return string the salt
	 */
	public function generateSalt()
	{
		return uniqid('',true);
	}
	/**
	 * Suggests a list of existing usernames matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestUsername($keyword,$limit=20)
	{
		$users=$this->findAll(array(
			'condition'=>'username LIKE :keyword',
			'order'=>'username DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($users as $user)
			$names[]=$user->username;
			return $names;
	}
	/**
	 * Suggests a list of existing email matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching username names
	 */
	public function suggestEmail($keyword,$limit=20)
	{
		$users=$this->findAll(array(
			'condition'=>'email LIKE :keyword',
			'order'=>'email DESC',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($users as $user)
			$names[]=$user->email;
			return $names;
	}
	/**
	 * Change status of image
	 * @param integer $id, the ID of image model
	 */
	static function reverseStatus($id){
		$command=Yii::app()->db->createCommand()
		->select('status')
		->from('tbl_user')
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
		$sql='UPDATE tbl_user SET status = '.$status.' WHERE id = '.$id;
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