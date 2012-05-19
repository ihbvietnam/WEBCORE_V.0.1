<?php
/**
 * 
 * Category class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * Category includes attributes and methods of Category class  
 */
class Category extends CActiveRecord
{	
	/**
	 * Config maximun rank in a group
	 */
	const MAX_RANK=4;	
	/**
	 * Config code error when delete category
	 */
	const DELETE_OK=1;
	const DELETE_HAS_CHILD=2;
	const DELETE_HAS_ITEMS=3;
	/**
	 * Config code (id) of the main category groups which have parent_id=0
	 */
	const GROUP_ROOT=0;
	const GROUP_ADMIN_MENU=1;
	const GROUP_USER_MENU=2;
	const GROUP_STATICPAGE=3;
	const GROUP_NEWS=4;
	const GROUP_PRODUCT=5;
	const GROUP_MANUFACTURER=6;
	const GROUP_ALBUM=7;
	const GROUP_GALLERYVIDEO=8;
	/*
	 * Config default controller and action when create admin menu
	 */
	const ADMIN_MENU_CONTROLLER_DEFAULT='news';
	const ADMIN_MENU_ACTION_DEFAULT='index';
	/**
	 * Config special
	 * SPECIAL_REMARK when group is news, category news is viewed at homepage
	 */
	const SPECIAL_REMARK=0;

	/**
	 * @var array config list other attributes of the banner
	 * these attributes is stored in other field of article table	 
	 */
	private $config_other_attributes=array('introimage','params','action','controller','description','modified','max_rank');	
	private $list_other_attributes;
	
	public $list_special;
	public $group;
	// Template var that store data when tree traversal
	public $tmp_list;
	// Store old order view
	public $old_order_view;
	// Store old parent id
	public $old_parent_id;
	//Store name
	public $old_name;
	
	/**
	 * Get all specials of class Category
	 * Use in drop select when create, update banner
	 */
	static function getList_label_specials()
 	{
	return array(
			self::SPECIAL_REMARK=>'Hiển thị ở trang chủ',
		);
 	}
 	/**
 	 * Get specials attributes of a category object
 	 * Used in page list admin views
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
 	 * Special attributes are encoded before save in database
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
	 * Returns all categories in the group
	 * @return array $result, array all category in a group
	 */
	public function getList_Categories(){
		$result=array();	
		if($this->group==0){
			$max_rank=1;
		}
		else {
			if(Category::model()->findByPk($this->group)!=null){
				$root=Category::model()->findByPk($this->group);
				$max_rank=$root->max_rank;
			}
			else {
				return $result;
			}
		}
		$this->tmp_list=array();
		$this->treeTraversal($this->group, 0, $max_rank);
		$result=$this->tmp_list;
		return $result;
	}
	/**
	 * Returns all child of the category.
	 * @return array $result array of sub-categories of this category
	 */
	public function getChild_categories(){
		if(!isset($this->id)){	
			return array();
		}
		else {
			$this->tmp_list=array();
			$this->treeTraversal($this->id, 0, PHP_INT_MAX);
			$result=$this->tmp_list;
			return $result;
		}
	}
	/**
	 * Return ancestor categories of the category 
	 * Used in bread crumb
	 * @return array $bread_crumb ancestor array of this category
	 */
	public function getBread_crumb(){
		$bread_crumb=array();
		$check=true;
		$current_id=$this->id;
		while ($check){
			$current=Category::model()->findByPk($current_id);
			$bread_crumb[]=$current_id;
			if(in_array($current->parent_id,array(Category::GROUP_NEWS,Category::GROUP_PRODUCT,Category::GROUP_STATICPAGE,Category::GROUP_ALBUM,Category::GROUP_GALLERYVIDEO))){
				$check=false;
			}
			else 
				$current_id=$current->parent_id;
		}
		return $bread_crumb;
	}
	
	/**
	 * Return ancestor of the category which has level 1 in the category group.
	 * @return integer $current_id, the ID of root category
	 */
	public function getRoot(){
		$check=true;
		$current_id=$this->id;
		while ($check){
			$current=Category::model()->findByPk($current_id);
			if(in_array($current->parent_id,array(Category::GROUP_ADMIN_MENU,Category::GROUP_USER_MENU,Category::GROUP_ALBUM,Category::GROUP_GALLERYVIDEO,Category::GROUP_MANUFACTURER,Category::GROUP_NEWS,Category::GROUP_STATICPAGE,Category::GROUP_PRODUCT)))
			{
				$check=false;
			}
			else 
				$current_id=$current->parent_id;
		}
		return $current_id;
	}
	
	/**
	 * find category group
	 * @return integer $current_id, the id of category group 
	 */
	public function findGroup(){
		$check=true;
		$current_id=$this->id;
		while ($check){
			$current=Category::model()->findByPk($current_id);
			if($current->parent_id == 0){
				$check=false;
			}
			else 
				$current_id=$current->parent_id;
		}
		return $current_id;
	}
	
	/**
	 * Returns the rank of category 
	 * @return integer $result, the rank of this category
	 */
	public function getRank(){
		$result=0;
		foreach ($this->child_categories as $cat){
			if($cat['level'] > $result) $result=$cat['level'];
		}
		return $result;
	}
	
	/**
	 * Returns order view of brother categories
	 * @return array $result, the array sibling of this category
	 */
	public function getList_order_view(){
		$result=array();	
		$list=Category::model()->findAll('parent_id='.$this->parent_id);
		foreach ($list as $cat){
			$result[$cat->id]=$cat->order_view;
		}
		return $result;
	}
	
	/**
	 * Returns all categories that can be parent of this category.
	 */
	public function getParent_categories(){
		
		$this->tmp_list=array($this->group=>array('level'=>0,'name'=>'Thư mục gốc'));	
		if($this->group==0){
			return $this->tmp_list;
		}
		else {
			$root=Category::model()->findByPk($this->group);
			$max_rank=$root->max_rank-1;
		}
		if($max_rank > 0){
			$this->treeTraversal($this->group, 0, $max_rank);
		}
		$result=$this->tmp_list;
		
		$black_list=array();
		//Remove the category
		$black_list[]=$this->id;
		//Remove all child of category
		foreach ($this->child_categories as $cat_id=>$cat){
			$black_list[]=$cat_id;
		}
		foreach ($black_list as $cat_id) {
			unset($result[$cat_id]);
		}		
		return $result;
	}
	/**
	 * Recursive algorithms for tree traversals
	 */
	public function treeTraversal($group,$level,$rank){
		$new_level=$level+1;
		$criteria=new CDbCriteria;
		$criteria->compare('parent_id', $group);
		$criteria->order='order_view';
		$list_category=Category::model()->findAll($criteria);
		foreach ($list_category as $category){
			$category->group=$this->group;
			//Get route and params if group is menu
			if($this->group==Category::GROUP_ADMIN_MENU || $this->group==Category::GROUP_USER_MENU){
				$this->tmp_list[$category->id]=array('level'=>$new_level,'name'=>$category->name,'url'=>$category->url,'root'=>$category->root);
			}
			elseif(in_array($this->group,array(Category::GROUP_NEWS,Category::GROUP_PRODUCT,Category::GROUP_STATICPAGE,Category::GROUP_ALBUM,Category::GROUP_GALLERYVIDEO))){
				$this->tmp_list[$category->id]=array('level'=>$new_level,'name'=>$category->name,'url'=>$category->url,'special'=>$category->special);
			}
			else {
				$this->tmp_list[$category->id]=array('level'=>$new_level,'name'=>$category->name);
			}
			if($new_level<$rank){
			$this->treeTraversal($category->id, $new_level, $rank);
			}
		}
	}
	/*
	 * Returns the level of the category in group
	 */
	public function getLevel(){
		foreach ($this->list_categories as $id=>$category) {
			if($this->id==$id) return $category['level'];
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
	 * @return Category the static model class
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
		return 'tbl_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('max_rank','required','on'=>'root'),
			array('max_rank','numerical','on'=>'root'),
			array('max_rank','validatorMaxRank','on'=>'root'),
			array('name,parent_id', 'required','message'=>'Dữ liệu bắt buộc'),
			array('parent_id','validatorParent'),
			array('name', 'length', 'max'=>256,'message'=>'Tối đa 32 kí tự'),
			array('description, name', 'length', 'max'=>512,'message'=>'Tối đa 32 kí tự'),
			array('order_view','required','message'=>'Dữ liệu bắt buộc','on'=>'staticPage,menu,news,product'),
			array('order_view','numerical','on'=>'menu,news,product,staticPage'),
			array('controller,action','required','on'=>'menu','message'=>'Dữ liệu bắt buộc'),
			array('params','safe','on'=>'menu'),
			array('list_special,lang','safe','on'=>'staticPage,news,product')
		);
	}
	
	/**
	 * Function validator role
	 */
	public function validatorMaxRank($attributes,$params){
		if($this->id > 0){
			if($this->rank>$this->max_rank) 
				$this->addError('max_rank', 'Nhóm thư mục này hiện đã vượt quá cấp mà bạn chọn.');
		}			
	}
	/**
	 * 
	 * Function validator role
	 */
	public function validatorParent($attributes,$params){
		if($this->group>0 && $this->id>0){
			$root=Category::model()->findByPk($this->group);
			$max_rank=$root->max_rank;
			$parent=Category::model()->findByPk($this->parent_id);
			$parent->group=$this->group;
			if(($parent->level+$this->rank)>=$root->max_rank){
				$this->addError('parent_id', 'Vượt quá cấp quy định. Bạn không thể chuyển tới thư mục này.');
			}
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
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
			'name' => 'Tên',
			'description' => 'Miêu tả',
			'parent_id'	=> 'Thuộc',
			'max_rank'=>'Mức cấp con',
			'order_view'=>'Thứ tự hiển thị',
			'params'=>'Cấu hình tham số 3 cho URL',
			'controller'=>'Cấu hình tham số 1 cho URL',
			'action'=>'Cấu hình tham số 2 cho URL',
			'list_special' => 'Nhóm hiển thị',
			'lang'=>'Ngôn ngữ'
		);
	}
	
	/**
	 * This event is raised after the record is instantiated by a find method.
	 * @param CEvent $event the event parameter
	 */
	public function afterFind()
	{
		//Store old order view	
		if($this->order_view !=""){
			$this->old_order_view=$this->order_view;
		}
		//Store old parent id
		if($this->parent_id != ""){
			$this->old_parent_id=$this->parent_id;
		}
		$this->old_name=$this->name;
		//Get list special
		if($this->special != ""){
			$this->list_special=iPhoenixStatus::decodeStatus($this->special);	
		}
		//Decode attribute other to set other attributes
		$this->list_other_attributes=(array)json_decode($this->other);	
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
				//Set order view
				$this->order_view=sizeof($this->list_order_view)+1;
				if($this->parent_id == Category::GROUP_STATICPAGE || $this->parent_id == Category::GROUP_NEWS || $this->parent_id == Category::GROUP_PRODUCT) 
					$this->list_special=array(Category::SPECIAL_REMARK);
				//Set alias
				/*
				if($this->group==self::GROUP_ADMIN_MENU)
					$this->alias='admin-menu-'.iPhoenixString::createAlias($this->name);
				elseif($this->group==self::GROUP_USER_MENU)
					$this->alias='user-menu-'.iPhoenixString::createAlias($this->name);	
				else
				*/ 
				$alias=iPhoenixString::createAlias($this->name);
				if(sizeof(Category::model()->findAll('alias ="'.$alias.'"'))>0)
				{
					$parent=Category::model()->findByPk($this->parent_id);
					if(isset($parent))	$alias = $alias.'-'.$parent->alias;
				}
				while(sizeof(Category::model()->findAll('alias ="'.$alias.'"'))>0){
					$suffix=rand(1,9);
					$alias =$alias.'-'.$suffix;
				}
				$this->alias=$alias;
			}	
			else {
				$modified=$this->modified;
				$modified[time()]=Yii::app()->user->id;
				$this->modified = json_encode ( $modified );
				if ($this->name != $this->old_name) {
					$alias = iPhoenixString::createAlias ( $this->name );
					if (sizeof ( Category::model ()->findAll ( 'alias ="' . $alias . '"' ) ) > 0) {
						$parent = Category::model ()->findByPk ( $model->parent_id );
						if (isset ( $parent ))
							$alias = $alias.'-'.$parent->alias;
					}
					while ( sizeof ( Category::model ()->findAll ( 'alias ="' . $alias . '"' ) ) > 0 ) {
						$suffix = rand ( 1, 9 );
						$alias = $alias . '-' . $suffix;
					}
					$this->alias = $alias;
				}
			}
			//Encode special
			if($this->group == self::GROUP_STATICPAGE || $this->group == self::GROUP_NEWS || $this->group == self::GROUP_PRODUCT)
				$this->special=iPhoenixStatus::encodeStatus($this->list_special);
			//Encode other attributes  		
			$this->other = json_encode ( $this->list_other_attributes );
			return true;
		} else
			return false;
	}
	/**
	 * Change order view of a category
	 * @return boolean false if it is not changed successfully
	 * otherwise, it changed the order of this category
	 */
	
	public function changeOrderView() {
		if(!isset($this->old_parent_id) || $this->old_parent_id == ""){
			$this->old_parent_id=0;
		}
			//Change order view
		if ($this->parent_id == $this->old_parent_id) {
			if ($this->order_view < $this->old_order_view) {
				foreach ( $this->list_order_view as $id => $order ) {
					if ($id != $this->id && $order >= $this->order_view) {
						$category = Category::model ()->findByPk ( $id );
						if ($category->order_view < $this->old_order_view )
							$category->order_view = $order + 1;
						if (! $category->save ())
							return false;
					}
				}
			}
			if ($this->order_view > $this->old_order_view) {
				foreach ( $this->list_order_view as $id => $order ) {
					if ($id != $this->id && $order <= $this->order_view) {
						$category = Category::model ()->findByPk ( $id );
						if ($category->order_view > $this->old_order_view )
							$category->order_view = $order - 1;
						if (! $category->save ())
							return false;
					}
				}
			}
		} else {
			//Fix order view in old parent category
			$list = Category::model ()->findAll ( 'parent_id=' . $this->old_parent_id );
			foreach ( $list as $cat ) {
				if ($cat->order_view > $this->old_order_view) {
					$cat->order_view = $cat->order_view - 1;
					if (!$cat->save ())
						return false;
				}
			}
			//Fix order view in new parent category
			foreach ( $this->list_order_view as $id => $order ) {
				if ($id != $this->id && $order >= $this->order_view) {
					$category = Category::model ()->findByPk ( $id );
					$category->order_view = $order + 1;
					if (! $category->save ())
						return false;
				}
			}
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

		$criteria->compare('id',$this->id);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('child_id',$this->child_id);
		$criteria->compare('other',$this->other,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Recursive algorithms for tree traversals
	 */
	public function checkDelete($id){
		$list_category=Category::model()->findAll('parent_id = '.$id);
		if(sizeof($list_category)>0){
			return self::DELETE_HAS_CHILD;
		}
		switch($this->group){
			case self::GROUP_NEWS:
				$list_news=News::model()->findAll('catid = '. $id);
				if(sizeof($list_news)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::GROUP_PRODUCT:
				$list_product=Product::model()->findAll('catid = '. $id);
				if(sizeof($list_product)>0) return self::DELETE_HAS_ITEMS;
				break;
			case self::GROUP_STATICPAGE:
				$list_page=StaticPage::model()->findAll('catid = '. $id);
				if(sizeof($list_page)>0) return self::DELETE_HAS_ITEMS;
				break;
		}
		return self::DELETE_OK;
	}
	/**
	 * Config menu of category, each menu have corresponding controller/action
	 * @param string $type, controller or action
	 * @param array $value, the information of corresponding url
	 * @return array
	 */
	public function codeUrl($type,$value=array()){
		switch ($type) {
			case 'controller': 
					return array('product'=>'Sản phẩm','news'=>'Tin tức','staticPage'=>'Trang tĩnh','album'=>'Album','galleryVideo'=>'Video','config'=>'Hệ thống','language'=>'Ngôn ngữ','setting'=>'Cấu hình','order'=>'Đơn hàng','user'=>'User','qa'=>'Hỏi đáp','banner'=>'Banner','contact'=>'Liên hệ');				
				break;
			case 'action':
				switch ($value['controller']) {	
					case 'product':													
							return array('view_all'=>'Hiển thị tất cả sản phẩm','view_category'=>'Hiển thị theo danh mục','index'=>'Quản lý danh sách','create'=>'Tạo mới','manager_category'=>'Quản lý danh mục','manufacturer'=>'Nhà sản xuất');
						break;			
					case 'news':						
							return array('view_all'=>'Hiển thị tất cả tin tức','view_category'=>'Hiển thị theo danh mục','index'=>'Quản lý danh sách','create'=>'Tạo mới','manager_category'=>'Quản lý danh mục');					
						break;
					case 'staticPage':						
							return array('view_all'=>'Hiển thị tất cả các trang tĩnh','view_category'=>'Hiển thị danh mục','view_page'=>'Hiển thị trang','home'=>'Trang chủ','index'=>'Quản lý danh sách','create'=>'Tạo mới','manager_category'=>'Quản lý danh mục');					
						break;
					case 'album':							
						return array('view_all'=>'Hiển thị tất cả album','view_category'=>'Hiển thị theo danh mục','index'=>'Quản lý danh sách','create'=>'Tạo mới','manager_category'=>'Quản lý danh mục');
						break;
					case 'galleryVideo':							
						return array('view_all'=>'Hiển thị tất cả video','view_category'=>'Hiển thị theo danh mục','index'=>'Quản lý danh sách','create'=>'Tạo mới','manager_category'=>'Quản lý danh mục');
						break;
					case 'config':								
						return array('root'=>'Danh mục gốc','menu'=>'Menu','clear_image'=>'Dọn dẹp ảnh rác');
						break;
					case 'language':
						return array('create'=>'Tạo mới','edit'=>'Cập nhật','delete'=>'Xóa','import'=>'Nhập dữ liệu từ file excel','export'=>'Xuất dữ liệu ra file excel');
						break;
					case 'setting':	
						return array('index'=>'Quản lý');
						break;
					case 'order':							
						return array('index'=>'Quản lý');
						break;						
					case 'qa':						
						return array('index'=>'Quản lý','view_qa'=>'Hiển thị');
						break;
					case 'contact':							
						return array('index'=>'Quản lý','view_contact'=>'Hiển thị');
						break;
					case 'user':								
						return array('index'=>'Quản lý danh sách','create'=>'Thêm mới');
						break;
					case 'banner':								
						return array('index'=>'Quản lý','create'=>'Tạo mới');
						break;		
				}
				break;			
		}
	}
	/**
	 * Get list params for menu
	 * @param string $controller, the controller of menu
	 * @param string $action, the action of menu
	 */
	static function getListParams($controller,$action){
		$result=array();
		switch ($controller){
			case 'news':
				switch ($action) {
					case 'view_category': 
						$group=new Category();		
						$group->group=Category::GROUP_NEWS;
						$list_category=$group->list_categories;
						foreach ($list_category as $id=>$info_cat){
							$cat=Category::model()->findByPk($id);
							$index=json_encode(array('cat_alias'=>$cat->alias));
							$view = "";
							for($i=1;$i<$info_cat['level'];$i++){
								$view .="---";
							}
							$label=$view." ".$info_cat['name']." ".$view;
							$result[$index]=$label;
						}
						return $result;					
					default:
						return $result;
				}
				break;
			case 'galleryVideo':
				switch ($action) {
					case 'view_category': 
						$group=new Category();		
						$group->group=Category::GROUP_GALLERYVIDEO;
						$list_category=$group->list_categories;
						foreach ($list_category as $id=>$info_cat){
							$cat=Category::model()->findByPk($id);
							$index=json_encode(array('cat_alias'=>$cat->alias));
							$view = "";
							for($i=1;$i<$info_cat['level'];$i++){
								$view .="---";
							}
							$label=$view." ".$info_cat['name']." ".$view;
							$result[$index]=$label;
						}
						return $result;					
					default:
						return $result;
				}
				break;
			case 'album':
				switch ($action) {
					case 'view_category': 
						$group=new Category();		
						$group->group=Category::GROUP_ALBUM;
						$list_category=$group->list_categories;
						foreach ($list_category as $id=>$info_cat){
							$cat=Category::model()->findByPk($id);
							$index=json_encode(array('cat_alias'=>$cat->alias));
							$view = "";
							for($i=1;$i<$info_cat['level'];$i++){
								$view .="---";
							}
							$label=$view." ".$info_cat['name']." ".$view;
							$result[$index]=$label;
						}
						return $result;					
					default:
						return $result;
				}
				break;
			case 'staticPage':
				switch ($action) {
					case 'view_category': 
						$group=new Category();		
						$group->group=Category::GROUP_STATICPAGE;
						$list_category=$group->list_categories;
						foreach ($list_category as $id=>$info_cat){
							$cat=Category::model()->findByPk($id);
							$index=json_encode(array('cat_alias'=>$cat->alias));
							$view = "";
							for($i=1;$i<$info_cat['level'];$i++){
								$view .="---";
							}
							$label=$view." ".$info_cat['name']." ".$view;
							$result[$index]=$label;
						}
						return $result;	
						break;
					case 'view_page':
						$criteria=new CDbCriteria;
						$group=new Category();		
						$group->group=Category::GROUP_STATICPAGE;
						$list_category = array ();
						//Set itself
						$list_child_id [] = $cat->id;
						if ($group->list_categories != null)
							foreach ( $group->list_categories as $id => $child_cat ) {
								$list_category [] = $id;
						}
						$criteria->addInCondition('catid',$list_category);
						$criteria->compare('status',StaticPage::STATUS_ACTIVE);
						$list_page=StaticPage::model()->findAll($criteria);
						foreach ($list_page as $page){
							$index=json_encode(array('cat_alias'=>$page->category->alias,'pageStatic_alias'=>$page->alias));
							$result[$index]=$page->title;
						}
						return $result;	
						break;			
					default:
						return $result;
				}
				break;
		case 'product':
				switch ($action) {
					case 'view_category': 
						$group=new Category();		
						$group->group=Category::GROUP_PRODUCT;
						$list_category=$group->list_categories;
						foreach ($list_category as $id=>$info_cat){
							$cat=Category::model()->findByPk($id);
							$index=json_encode(array('cat_alias'=>$cat->alias));
							$view = "";
							for($i=1;$i<$info_cat['level'];$i++){
								$view .="---";
							}
							$label=$view." ".$info_cat['name']." ".$view;
							$result[$index]=$label;
						}
						return $result;					
					default:
						return $result;
				}
				break;
			case 'config':
				switch ($action) {
					case 'menu': 
						$result=array();
						//Config admin menu
						$value=json_encode(array('group'=>Category::GROUP_ADMIN_MENU));
						$result[$value]='Quản lý menu trang quản trị';
						//Config user menu
						$value=json_encode(array('group'=>Category::GROUP_USER_MENU));
						$result[$value]='Quản lý menu trang front end';
						return $result;
					default:
						return $result;
				}
				break;
			default:
				return $result;
		}
	}
	
	/**
	 * Create route for url of menu
	 * @return string the corresponding url of this controller/action
	 */	
	public function getRoute(){
		$config=array(
			'product'=>array(
				'view_all'=>'/product/index',
				'index'=>'/admin/product/index',
				'create'=>'/admin/product/create',
				'manager_category'=>'/admin/category',
				'view_category'=>'/product/list',
				'manufacturer'=>'/admin/category'
			),
			'news'=>array(
				'index'=>'/admin/news/index',
				'create'=>'/admin/news/create',
				'manager_category'=>'/admin/category',
				'view_category'=>'/news/list',
				'view_all'=>'/news/index',
			),
			'staticPage'=>array(
				'index'=>'/admin/staticPage/index',
				'create'=>'/admin/staticPage/create',
				'manager_category'=>'/admin/category',
				'view_category'=>'staticPage/list',
				'view_all'=>'/staticPage/index',
				'view_page'=>'/staticPage/view',
				'home'=>'site/home'
			),
			'album'=>array(
				'index'=>'/admin/album/index',
				'create'=>'/admin/album/create',
				'manager_category'=>'/admin/category',
				'view_category'=>'/album/list',
				'view_all'=>'/album/index',
			),
			'galleryVideo'=>array(
				'index'=>'/admin/galleryVideo/index',
				'create'=>'/admin/galleryVideo/create',
				'manager_category'=>'/admin/category',
				'view_category'=>'/galleryVideo/list',
				'view_all'=>'/galleryVideo/index',
			),
			'order'=>array(
				'index'=>'/admin/order/index',
			),	
			'qa'=>array(
				'index'=>'/admin/qA/index',
				'create'=>'/admin/qA/create',
				'view_qa'=>'qA/index'
			),
			'contact'=>array(
				'index'=>'/admin/contact/index',
				'view_contact'=>'site/contact'
			),
			'user'=>array(
				'index'=>'/admin/user/index',
				'create'=>'/admin/user/create',
			),
			'banner'=>array(
				'index'=>'/admin/banner/index',
				'create'=>'/admin/banner/create',
			),
			'setting'=>array(
				'index'=>'/admin/setting/index',
			), 
			'language'=>array(
				'edit'=>'/admin/language/edit',
				'create'=>'/admin/language/create',
				'delete'=>'/admin/language/delete',
				'export'=>'/admin/language/export',
				'import'=>'/admin/language/import',
			),
			'config' => array (
				'menu' => '/admin/category', 
				'clear_image' => '/admin/image/clear',
				'root'=>'/admin/category',
			) 
		);
		if(isset($config [$this->controller] [$this->action]))
			return $config [$this->controller] [$this->action];
		else
			return '/site/home';
	}
	/**
	 * Create params for url of menu
	 * @return string, the url of menu
	 */
	public function getUrl() {
		if ($this->group == Category::GROUP_ADMIN_MENU || $this->group == Category::GROUP_USER_MENU) {
			$config = array (
					'news' => array (
						'manager_category' => array ('group' => Category::GROUP_NEWS),
					),
					'staticPage' => array (
						'manager_category' => array ('group' => Category::GROUP_STATICPAGE),
					),
					'product' => array (
						'manager_category' => array ('group' => Category::GROUP_PRODUCT ),
						'manufacturer'=>array('group'=>Category::GROUP_MANUFACTURER)
					),	
					'album' => array (
						'manager_category' => array ('group' => Category::GROUP_ALBUM),
					),
					'galleryVideo' => array (
						'manager_category' => array ('group' => Category::GROUP_GALLERYVIDEO),
					),		
					'config'=>array(
						'root'=>array ('group' => Category::GROUP_ROOT),
					)
			);
			if ($this->params != "") {
				$params = ( array ) json_decode ( $this->params );
			} elseif (isset ( $config [$this->controller] [$this->action] ))
				$params = $config [$this->controller] [$this->action];
			if (isset ( $params ))
				$url = Yii::app ()->createUrl ( $this->route, $params );
			else
				$url = Yii::app ()->createUrl ( $this->route );
			return $url;
		}
		elseif($this->findGroup() == Category::GROUP_NEWS){
			
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/news/list",array('cat_alias'=>$cat_alias));
			return $url;
		}
		elseif($this->findGroup() == Category::GROUP_STATICPAGE){
			
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/staticPage/index",array('cat_alias'=>$cat_alias));
			return $url;
		}
		elseif($this->findGroup() == Category::GROUP_ALBUM){
			
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/album/index",array('album_alias'=>$cat_alias));
			return $url;
		}
		elseif($this->findGroup() == Category::GROUP_GALLERYVIDEO){
			
 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/galleryVideo/index",array('galleryVideo_alias'=>$cat_alias));
			return $url;
		}
		elseif($this->findGroup() == Category::GROUP_PRODUCT){

 			$cat_alias=$this->alias;
 			$url=Yii::app()->createUrl("/product/list",array('cat_alias'=>$cat_alias));
			return $url;
		}
		else 
		{
			return "#";
		}
	}
	/**
	 * Get active menu
	 * @return array $result, the active menu in admin board
	 */
	public function findActiveMenu(){
		$list=$this->list_Categories;	
		$result=array();
		foreach ($list as $id=>$menu){
			if($menu['url']== Yii::app()->request->requestUri)
			{
				$current=Category::model()->findByPk($id);
				$result=$current->bread_crumb;
			}
		}
		return $result;
	}
}