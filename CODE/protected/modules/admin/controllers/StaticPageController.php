<?php

class StaticPageController extends Controller
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
				'actions'=>array('index','create','copy','suggestTitle','dynamicCat','checkbox','updateSuggest'),
				'roles'=>array('create'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('reverseStatus'),
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
		$model=new StaticPage('write');
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StaticPage']))
		{
			$model->attributes=$_POST['StaticPage'];
			if(!isset($_POST['StaticPage']['list_special'])) $model->list_special=array();
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}
		//Group categories that contains staticPage
		$group=new Category();		
		$group->group=Category::GROUP_STATICPAGE;
		$list_category=$group->list_categories;
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest ())
				Yii::app ()->session ['checked-suggest-list'] = array();
		//Handler list suggest staticPage		
		$this->initCheckbox('checked-suggest-list');
		$suggest=new StaticPage('search');
		$suggest->unsetAttributes();  // clear any default values
		if(isset($_GET['catid'])) $suggest->catid=$model->catid;
		if(isset($_GET['SuggestStaticPage']))
			$suggest->attributes=$_GET['SuggestStaticPage'];
			
		$this->render('create',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'suggest'=>$suggest
			
		));
	}
	/**
	 * Copy a new model
	 */
	public function actionCopy($id)
	{
		$copy=StaticPage::copy($id);
		if(isset($copy))
		{
				$this->redirect(array('update','id'=>$copy->id));
		}
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(Yii::app()->user->checkAccess('update', array('post' => $model)))	
		{	
		$model->scenario = 'write';
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['StaticPage']))
		{
			if(!isset($_POST['StaticPage']['list_special'])) $model->list_special=array();
			$model->attributes=$_POST['StaticPage'];
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}
		//Group categories that contains staticPage
		$group=new Category();		
		$group->group=Category::GROUP_STATICPAGE;
		$list=$group->list_categories;
		$list_category=array();
		foreach ($list as $id=>$cat){
			$list_category[$id]=$cat;
		}
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest ())
				Yii::app ()->session ['checked-suggest-list'] = array_diff ( explode ( ',', $model->list_suggest ), array ('' ) );
		//Handler list suggest staticPage
		$this->initCheckbox('checked-suggest-list');
		$suggest=new StaticPage('search');
		$suggest->unsetAttributes();  // clear any default values
		if(isset($_GET['catid'])) $suggest->catid=$model->catid;
		if(isset($_GET['SuggestStaticPage']))
			$suggest->attributes=$_GET['SuggestStaticPage'];
		$this->render('update',array(
			'model'=>$model,
			'list_category'=>$list_category,
			'suggest'=>$suggest
		));		
		}
		else 
			throw new CHttpException(403,Yii::t('yii','You are not authorized to perform this action.'));
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
		$this->initCheckbox('checked-staticPage-list');
		$list_checked = Yii::app()->session["checked-staticPage-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'update')) {
					foreach ( $list_checked as $id ) {
						$item = StaticPage::model ()->findByPk ( (int)$id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
				} else {
					echo 'false';
					Yii::app ()->end ();
				}
				break;
			case 'copy' :
				foreach ( $list_checked as $id ) {
					$copy=StaticPage::copy((int)$id);
					if(!isset($copy))
					{
						echo 'false';
						Yii::app ()->end ();
					}
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
		$this->initCheckbox('checked-staticPage-list');
		$model=new StaticPage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['catid'])) $model->catid=$_GET['catid'];
		$model->lang=Language::DEFAULT_LANGUAGE;
		if(isset($_GET['StaticPage']))
			$model->attributes=$_GET['StaticPage'];	
		//Group categories that contains staticPage
		$group=new Category();		
		$group->group=Category::GROUP_STATICPAGE;
		$list=$group->list_categories;
		$list_category=$list;	
		$this->render('index',array(
			'model'=>$model,
			'list_category'=>$list_category
		));
	}
	/**
	 * Reverse status of staticPage
	 */
	public function actionReverseStatus($id)
	{
		$src=StaticPage::reverseStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	/**
	 * Suggests title of staticPage.
	 */
	public function actionSuggestTitle()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$titles=StaticPage::model()->suggestTitle($keyword);
			if($titles!==array())
				echo implode("\n",$titles);
		}
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
	/*
	 * List staticPage suggest 
	 */
	public function actionUpdateSuggest()
	{
		$this->initCheckbox('checked-suggest-list');
		$list_checked = Yii::app()->session["checked-suggest-list"];
		echo implode(',',$list_checked);
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=StaticPage::model()->findByPk($id);
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
		if( !isset($_GET['ajax'] )  || ($_GET['ajax'] != 'staticPage-list-suggest' && $_GET['ajax'] != 'staticPage-list')){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		}
	}
}
