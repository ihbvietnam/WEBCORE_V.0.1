<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
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
				'actions'=>array('index','create','suggestName','updateSuggest'),
				'roles'=>array('create'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('reverseStatus','reverseAmountStatus','delete','checkbox'),
				'roles'=>array('update'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Product('write');		
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if(!isset($_POST['Product']['list_special'])) $model->list_special=array();
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}
		
		//List category product
		$group=new Category();		
		$group->group=Category::GROUP_PRODUCT;
		$list=$group->list_categories;
		$list_category=array();
		foreach ($list as $id=>$cat){
			$list_category[$id]=$cat;
		}
		
		//List manufacturer
		$group=new Category();		
		$group->group=Category::GROUP_MANUFACTURER;
		$list=$group->list_categories;
		$list_manufacturer=array();
		foreach ($list as $id=>$manufacturer){
			$list_manufacturer[$id]=$manufacturer;
		}
		
		//Handler list suggest product
		if(!Yii::app()->getRequest()->getIsAjaxRequest())
			Yii::app ()->session ["checked-suggest-list"]=array_diff ( explode ( ',', $model->list_suggest ), array ('' ) );
		$this->initCheckbox('checked-suggest-list');
		$suggest=new Product('search');
		$suggest->unsetAttributes();  // clear any default values
		if(isset($_GET['catid'])) $suggest->catid=$model->catid;
		if(isset($_GET['SuggestProduct']))
		$suggest->attributes=$_GET['SuggestProduct'];
		$this->render('create',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'list_manufacturer'=>$list_manufacturer,
			'suggest'=>$suggest
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel ( $id );
		if (Yii::app ()->user->checkAccess ( 'update', array ('post' => $model ) )) {
			$model->scenario = 'write';
			// Ajax validate
			$this->performAjaxValidation ( $model );
			
			if (isset ( $_POST ['Product'] )) {
				$model->attributes = $_POST ['Product'];
				if(!isset($_POST['Product']['list_special'])) $model->list_special=array();
				if ($model->save ())
					$this->redirect ( array ('update', 'id' => $model->id ) );
			}
			//List category product
		$group=new Category();		
		$group->group=Category::GROUP_PRODUCT;
		$list=$group->list_categories;
		$list_category=array();
		foreach ($list as $id=>$cat){
			$list_category[$id]=$cat;
		}
		
		//List manufacturer
		$group=new Category();		
		$group->group=Category::GROUP_MANUFACTURER;
		$list=$group->list_categories;
		$list_manufacturer=array();
		foreach ($list as $id=>$manufacturer){
			$list_manufacturer[$id]=$manufacturer;
		}
			
		//Handler list suggest Product
		if(!Yii::app()->getRequest()->getIsAjaxRequest())
			Yii::app ()->session ["checked-suggest-list"]=array_diff(explode(',',$model->list_suggest),array(''));
		$this->initCheckbox('checked-suggest-list');
		$suggest=new Product('search');
		$suggest->unsetAttributes();  // clear any default values
		if(isset($_GET['catid'])) $suggest->catid=$model->catid;
		if(isset($_GET['SuggestProduct']))
			$suggest->attributes=$_GET['SuggestProduct'];
			
			$this->render ( 'update', array ('model' => $model,
			'list_category'=>$list_category,
			'list_manufacturer'=>$list_manufacturer,
			'suggest'=>$suggest ) );
		}		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->initCheckbox('checked-product-list');
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];
		//Group categories 
		$group=new Category();		
		$group->group=Category::GROUP_PRODUCT;
		$list=$group->list_categories;
		$list_category=$list;
		//Group manufacture
		$group=new Category();		
		$group->group=Category::GROUP_MANUFACTURER;
		$list=$group->list_categories;
		$list_manufacturer=$list;
		$this->render('index',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'list_manufacturer'=>$list_manufacturer
		));
	}
	/**
	 * Reverse status of product
	 */
	public function actionReverseStatus($id)
	{
		$src=Product::reverseStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	/**
	 * Reverse amount status of product
	 */
	public function actionReverseAmountStatus($id)
	{
		$src=Product::reverseAmountStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	/**
	 * Suggests name of product.
	 */
	public function actionSuggestName()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$names=Product::model()->suggestName($keyword);
			if($names!==array())
				echo implode("\n",$names);
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest())
		{
			if( !isset($_GET['ajax'] )  || ($_GET['ajax'] != 'list-product-suggest' && $_GET['ajax'] != 'product-list')){
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
	}
	/*
	 * List Product suggest 
	 */
	public function actionUpdateSuggest()
	{
		$this->initCheckbox('checked-suggest-list');
		$list_checked = Yii::app()->session["checked-suggest-list"];
		echo implode(',',$list_checked);
	}
public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-product-list');
		$list_checked = Yii::app()->session["checked-product-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'update')) {
					foreach ( $list_checked as $id ) {
						$item = Product::model ()->findByPk ( $id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
					Yii::app ()->session ["checked-product-list"] = array ();
				} else {
					echo 'false';
					Yii::app ()->end ();
				}
				break;
		}
		echo 'true';
		Yii::app()->end();
		
	}
	/*
	 * Init checkbox
	 */
	public function initCheckbox($name_params){
		if (! isset ( Yii::app ()->session [$name_params] ))
			Yii::app ()->session [$name_params] = array ();
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest () && $name_params != 'checked-suggest-list')
			Yii::app ()->session [$name_params] = array ();
		else {
			if (isset ( $_POST ['list-checked'] )) {
				$list_new = array_diff ( explode ( ',', $_POST ['list-checked'] ), array ('' ) );
				$list_old = Yii::app ()->session [$name_params];
				$list = $list_old;
				foreach ( $list_new as $id ) {
					if (! in_array ( $id, $list_old ))
						$list [] = $id;
				}
				Yii::app ()->session [$name_params] = $list;
			}
			if (isset ( $_POST ['list-unchecked'] )) {
				$list_unchecked = array_diff ( explode ( ',', $_POST ['list-unchecked'] ), array ('' ) );
				$list_old = Yii::app ()->session [$name_params];
				$list = array ();
				foreach ( $list_old as $id ) {
					if (! in_array ( $id, $list_unchecked )) {
						$list [] = $id;
					}
				}
				Yii::app ()->session [$name_params] = $list;
			}
		}
	}
}

