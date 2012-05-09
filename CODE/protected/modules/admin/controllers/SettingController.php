<?php

class SettingController extends Controller
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
				'actions'=>array('update','create','delete','index','delete','checkbox','suggestName'),
				'roles'=>array('admin'),
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
		$model=new Setting('write');
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Setting']))
		{
			$model->attributes=$_POST['Setting'];
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}
			
		$this->render('create',array(
			'model'=>$model			
		));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Setting']))
		{
			$model->attributes=$_POST['Setting'];
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}
			
		$this->render('update',array(
			'model'=>$model			
		));
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-setting-list');
		$list_checked = Yii::app()->session["checked-setting-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'update')) {
					foreach ( $list_checked as $id ) {
						$item = Setting::model ()->findByPk ( $id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
					Yii::app ()->session ["checked-setting-list"] = array ();
				} else {
					echo 'false';
					Yii::app ()->end ();
				}
				break;
		}
		echo 'true';
		Yii::app()->end();
		
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->initCheckbox('checked-setting-list');
		$model=new Setting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Setting']))
			$model->attributes=$_GET['Setting'];			
		$this->render('index',array(
			'model'=>$model
		));
	}
	/**
	 * Suggests title of setting.
	 */
	public function actionSuggestName()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$titles=Setting::model()->suggestName($keyword);
			if($titles!==array())
				echo implode("\n",$titles);
		}
	}
	/*
	 * Init checkbox
	 */
	public function initCheckbox($name_params){
		if(!isset(Yii::app()->session[$name_params]))
			Yii::app()->session[$name_params]=array();	
		if(isset($_POST['list-checked'])){
			$list_new=array_diff ( explode ( ',', $_POST['list-checked'] ), array ('' ));
		 	$list_old=Yii::app()->session[$name_params];
		 	$list=$list_old;
          	foreach ($list_new as $id){
          		if(!in_array($id, $list_old))
               		$list[]=$id;
          	}
          	Yii::app()->session[$name_params]=$list;
		 }
		if(isset($_POST['list-unchecked'])){
			$list_unchecked=array_diff ( explode ( ',', $_POST['list-unchecked'] ), array ('' ));
		 	$list_old=Yii::app()->session[$name_params];
		 	$list=array();
          	foreach ($list_old as $id){
          		if(!in_array($id, $list_unchecked)){
               		$list[]=$id;
          		}
          	}
          	Yii::app()->session[$name_params]=$list;
		 }
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Setting::model()->findByPk($id);
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
		if(Yii::app()->getRequest()->getIsAjaxRequest() )
		{
		if( !isset($_GET['ajax'] )  || $_GET['ajax'] != 'setting-list'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		}
	}
}
