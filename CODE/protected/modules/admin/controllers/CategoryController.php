<?php
/**
 * 
 * CategoryController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * CategoryController includes actions relevant to Category:
 *** create new Category
 *** update information of a Category
 *** delete Category
 *** validate category
 *** index category
 *** write 
 *** update list order view
 *** load model Banner from banner's id
 *** perform action to list of selected banner from checkbox  
 */
class CategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '/protected/modules/admin/view/layouts/main'. 
	 * See '/protected/modules/admin/view/layouts/main.php'.
	 */
	public $layout='main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','write','update','create','delete','validateCategory','updateListOrderView','configUrl'),
				'roles'=>array('admin'),
			),	
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('setActiveAdminMenu'),
				'users'=>array('@'),
			),		
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @param $group group of category, like below constant
	 */
	public function actionCreate($group)
	{
			$action="create";
			$model=new Category();			
			//Define group of category
			$model->group=$group;
			switch ($group){
				case 
				Category::GROUP_ADMIN_MENU: 
				$model->scenario='menu';	
				$form='_form_menu';
				break;
				case 
				Category::GROUP_USER_MENU: 
				$model->scenario='menu';	
				$form='_form_menu';
				break;
				case Category::GROUP_ROOT: 
				$model->scenario='root';	
				$form="_form_root";
				break;
				case				
				Category::GROUP_NEWS: 
				$model->scenario='news';	
				$form="_form_news";
				break;
				case				
				Category::GROUP_GALLERYVIDEO: 
				$model->scenario='video';	
				$form="_form_video";
				break;
				case				
				Category::GROUP_ALBUM: 
				$model->scenario='album';	
				$form="_form_album";
				break;
				case				
				Category::GROUP_STATICPAGE: 
				$model->scenario='staticPage';	
				$form="_form_static_page";
				break;
				case
				Category::GROUP_PRODUCT: 
				$model->scenario='product';	
				$form="_form_product";
				break;
				case
				Category::GROUP_MANUFACTURER: 
				$model->scenario='manufacturer';	
				$form="_form_manufacturer";
				break;
				
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list'=>$model->list_categories,
			),true);
			
			$html_form = $this->renderPartial($form,array(
					'model'=>$model,'group'=>$group,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$group)
	{
			$action="update";
			$model=$this->loadModel($id);
			//Define group of category
			$model->group=$group;
			switch ($group){
				case 
				Category::GROUP_ADMIN_MENU: 
				$model->scenario='menu';	
				$form='_form_menu';
				break;
				case 
				Category::GROUP_USER_MENU: 
				$model->scenario='menu';	
				$form='_form_menu';
				break;
				case Category::GROUP_ROOT: 
				$model->scenario='root';	
				$form="_form_root";
				break;
				case				
				Category::GROUP_NEWS: 
				$model->scenario='news';	
				$form="_form_news";
				break;
				case				
				Category::GROUP_GALLERYVIDEO: 
				$model->scenario='video';	
				$form="_form_video";
				break;
				case				
				Category::GROUP_ALBUM: 
				$model->scenario='album';	
				$form="_form_album";
				break;
				case				
				Category::GROUP_STATICPAGE: 
				$model->scenario='staticPage';	
				$form="_form_static_page";
				break;
				case
				Category::GROUP_PRODUCT: 
				$model->scenario='product';	
				$form="_form_product";
				break;
				case
				Category::GROUP_MANUFACTURER: 
				$model->scenario='manufacturer';	
				$form="_form_manufacturer";
				break;
				
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list'=>$model->list_categories,
			),true);
			$html_form = $this->renderPartial($form,array(
					'model'=>$model,'group'=>$group,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$current_id,$group)
	{
			$result=array();
			$model=$this->loadModel($id);
			//Define group of category
			$model->group=$group;
			switch ($group){
				case 
				Category::GROUP_ADMIN_MENU: 
				$model->scenario='menu';	
				$form='_form_menu';
				break;
				case 
				Category::GROUP_USER_MENU: 
				$model->scenario='menu';	
				$form='_form_menu';
				break;
				case Category::GROUP_ROOT: 
				$model->scenario='root';	
				$form="_form_root";
				break;
				case				
				Category::GROUP_NEWS: 
				$model->scenario='news';	
				$form="_form_news";
				break;
				case				
				Category::GROUP_GALLERYVIDEO: 
				$model->scenario='video';	
				$form="_form_video";
				break;
				case				
				Category::GROUP_ALBUM: 
				$model->scenario='album';	
				$form="_form_album";
				break;
				case				
				Category::GROUP_STATICPAGE: 
				$model->scenario='staticPage';	
				$form="_form_staticPage";
				break;
				case
				Category::GROUP_PRODUCT: 
				$model->scenario='product';	
				$form="_form_product";
				break;
				case
				Category::GROUP_MANUFACTURER: 
				$model->scenario='manufacturer';	
				$form="_form_manufacturer";
				break;
				
			}
			switch ($model->checkDelete($id))	{
				case Category::DELETE_OK:		
					if($model->delete()) {
						$result['status']=true;
						if($id!=$current_id && $current_id!=0){
							$model=$this->loadModel($current_id);
							//Define group of category
							$model->group=$group;
							if($group==0) $model->scenario = 'root';
							$action="update";
						}
						else {
							$model=new Category();
							//Define group of category
							$model->group=$group;
							if($group==0) $model->scenario = 'root';
							$action="create";
						}
						Yii::app()->clientScript->scriptMap['jquery.js'] = false;
						$model->group=$group;
						$html_tree=$this->renderPartial('_tree',array(
							'list'=>$model->list_categories,
							),true);
						$html_form = $this->renderPartial($form,array(
							'model'=>$model,'group'=>$group,'action'=>$action
							),true,true); 
						$result['content']=$html_form.$html_tree;	
					}
					else {
						$result['status']='false';
						$action['content']='Hệ thống đang quá tải';
					}
					break;
				case Category::DELETE_HAS_CHILD:
					$result['status']= false;
					$result['content'] = "Bạn phải xóa hết các thư mục con.";
					break;
				case Category::DELETE_HAS_ITEMS:
					$result['status']= false;
					$result['content'] = "Thư mục không rỗng.";
					break;
				default:
					$result['status']='false';
					$action['content']='Hệ thống đang quá tải';
					break;
			}
			echo CJSON::encode($result);
	}

	/**
	 * Validate category
	 * @param Group $group of category
	 * @return 
	 */
	public function actionValidateCategory($group)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest())
		{
			if($_POST['id']>0){
				$model=Category::model()->findByPk($_POST['id']);
			}
			else {
				$model=new Category();
			}
			$model->group=$group;
			switch ($group){
				case 
				Category::GROUP_ADMIN_MENU: 
				$model->scenario='menu';	
				break;
				case 
				Category::GROUP_USER_MENU: 
				$model->scenario='menu';	
				break;
				case Category::GROUP_ROOT: 
				$model->scenario='root';	
				break;
				case				
				Category::GROUP_NEWS: 
				$model->scenario='news';	
				break;
				case				
				Category::GROUP_GALLERYVIDEO: 
				$model->scenario='video';	
				break;
				case				
				Category::GROUP_ALBUM: 
				$model->scenario='album';	
				break;
				case				
				Category::GROUP_STATICPAGE: 
				$model->scenario='staticPage';	
				break;
				case
				Category::GROUP_PRODUCT: 
				$form="_form_product";
				break;
				case
				Category::GROUP_MANUFACTURER: 	
				$form="_form_manufacturer";
				break;
				
			}
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Display list of category.
	 * @param integer $group, id of menu group
	 * @return
	 */
	public function actionIndex($group)
	{
		$model=new Category();
		$model->group=$group;
		switch ($group){
				case 
				Category::GROUP_ADMIN_MENU: 
				$model->scenario='menu';	
				break;
				case 
				Category::GROUP_USER_MENU: 
				$model->scenario='menu';	
				break;
				case Category::GROUP_ROOT: 
				$model->scenario='root';	
				break;
				case				
				Category::GROUP_NEWS: 
				$model->scenario='news';	
				break;
				case				
				Category::GROUP_GALLERYVIDEO: 
				$model->scenario='video';	
				break;
				case				
				Category::GROUP_ALBUM: 
				$model->scenario='album';	
				break;
				case				
				Category::GROUP_STATICPAGE: 
				$model->scenario='staticPage';	
				break;
				case
				Category::GROUP_PRODUCT: 
				$model->scenario='product';	
				break;
				case
				Category::GROUP_MANUFACTURER: 
				$form="_form_manufacturer";
				break;
				
			}
		$this->render('index',array(
			'model'=>$model,
			'group'=>$group,
			'action'=>'create'
		));
	}
	/**
	 * Creates and updates a new Category model.
	 * @param integer $group, id of menu group
	 * @return 
	 */
	public function actionWrite($group)
	{	
		if(isset($_POST['Category']))
		{
			$id=(int)$_POST['id'];
			if ( is_int($id) && $id>0){
				$action="update";
				$model=$this->loadModel($id);
			}
			else {
				$action="create";
				$model=new Category();
			}
			$model->group=$group;
			switch ($group){
				case 
				Category::GROUP_ADMIN_MENU: 
				$model->scenario='menu';	
				$form='_form_menu';
				break;
				case 
				Category::GROUP_USER_MENU: 
				$model->scenario='menu';	
				$form='_form_menu';
				break;
				case Category::GROUP_ROOT: 
				$model->scenario='root';	
				$form="_form_root";
				break;
				case				
				Category::GROUP_NEWS: 
				$model->scenario='news';	
				$form="_form_news";
				break;
				case				
				Category::GROUP_GALLERYVIDEO: 
				$model->scenario='video';	
				$form="_form_video";
				break;
				case				
				Category::GROUP_ALBUM: 
				$model->scenario='album';	
				$form="_form_album";
				break;
				case				
				Category::GROUP_STATICPAGE: 
				$model->scenario='staticPage';	
				$form="_form_static_page";
				break;
				case
				Category::GROUP_PRODUCT: 
				$model->scenario='product';	
				$form="_form_product";
				break;
				case
				Category::GROUP_MANUFACTURER: 
				$model->scenario='manufacturer';	
				$form="_form_manufacturer";
				break;
				
			}
			$model->attributes=$_POST['Category'];
			if(!isset($_POST['Category']['params']) &&  $model->scenario=="menu"){
				$model->params="";
			}
			if(!isset($_POST['Category']['list_special']) && ($model->scenario=="staticPage" || $model->scenario=="news" || $model->scenario=="product")) $model->list_special=array();
			if(!isset($model->parent_id)){
					$model->parent_id=$group;
			}
			if($model->save()){
				if(($model->scenario == "menu" || $model->scenario=="staticPage" || $model->scenario == 'news' || $model->scenario == 'product') && $action!="create")
				{	
					$model->changeOrderView();
				}
				if($action=="create"){
					$model=new Category();
					$model->group=$group;
				}
			}
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$html_tree=$this->renderPartial('_tree',array(
					'list'=>$model->list_categories,
				),true)
				;
			$html_form = $this->renderPartial($form,array(
					'model'=>$model,'group'=>$group,'action'=>$action
				),true,true); 
			echo $html_form.$html_tree;
		}
	}
	
	/**
	 * Updates list order view.
	 * @param integer $parent_id id of parent category
	 */
	public function actionUpdateListOrderView($parent_id)
	{	
		$list=Category::model()->findAll('parent_id='.$parent_id);
		$max_order=sizeof($list)+1;
		echo $max_order;
	}
	/**
	 * Updates list params that create url for menus
	 * @param integer $id, id of model
	 * @param controller $controller, controller of url
	 * @param action $action, action of url
	 */
	public function actionConfigUrl($id,$controller,$action)
	{
		$model= new Category();
		if(isset($_GET['group']))
			$model->group=$_GET['group'];
		$list_action = $model->codeUrl ( 'action', array ('controller' => $controller ) );
		$result ['list_action'] = $list_action;
		$key = array_keys ( $list_action );
		$select_action = $key ['0'];
		$select_param="";
		if ($id > 0) {
			$model = Category::model ()->findByPk ( $id );
			if (isset ( $model->controller ) && $model->controller == $controller) {
				if (isset ( $model->action )) {
					if($action == "")
					{
						$select_action = $model->action;
						$action=$select_action;
					}
					else {
						if ($model->action == $action) {
							$select_param = $model->params;
						} 
					}
				} 
			}
		}
		if($action == "") $action=$key['0'];
		$list_params = Category::getListParams ( $controller, $action );
		$result = array ();
		$result ['count'] = sizeof ( $list_params );
		$result ['list_params'] = $list_params;
		$result ['list_action'] = $list_action;
		$result ['selected_params'] = $select_param;
		$result ['selected_action'] = $select_action;
		echo json_encode ( $result );
	}
	
	/**
	 * 
	 * action set menu active in the admin cp 
	 * @param integer $id, id of the menu
	 */
	public function actionSetActiveAdminMenu($id)
	{
		if(Yii::app()->session['active_admin_menu'] = $id)
			echo json_encode ( array('success'=>true) );
		else 
			echo json_encode ( array('success'=>false) );
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
