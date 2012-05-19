<?php
/**
 * 
 * QAController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * QAController includes actions relevant to Question & Answer activities:
 *** update
 *** delete
 *** index
 *** reverse status
 *** suggest title
 *** load model
 *** perform action to list of selected models from checkbox   
 */
class QAController extends Controller
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
				'actions'=>array('index','create','suggestTitle'),
				'roles'=>array('create'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('reverseStatus','delete','checkbox'),
				'roles'=>array('update'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Create a particular model.
	 */
	public function actionCreate()
	{
		$model=new QA('create');	
		if(Yii::app()->user->checkAccess('update', array('post' => $model)))	
		{
		$model->scenario = 'create';
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['QA']))
		{
			$model->attributes=$_POST['QA'];
			if(!isset($_POST['QA']['list_special'])) $model->list_special=array();
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}		
		$this->render('create',array(
			'model'=>$model
		));	
		}		
		else 
			throw new CHttpException(403,Yii::t('yii','You are not authorized to perform this action.'));
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
		$model->scenario = 'answer';
		// Ajax validate
		$this->performAjaxValidation($model);	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['QA']))
		{
			$model->attributes=$_POST['QA'];
			if(!isset($_POST['QA']['list_special'])) $model->list_special=array();
			if($model->save())
				$this->redirect(array('update','id'=>$model->id));
		}		
		$this->render('update',array(
			'model'=>$model
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->initCheckbox('checked-qa-list');
		$model=new QA('search');
		$model->unsetAttributes();  // clear any default values
		$model->status_answer=0;
		if(isset($_GET['QA']))
			$model->attributes=$_GET['QA'];
		$this->render('index',array(
			'model'=>$model
		));
	}
	/**
	 * Reverse status of qa
	 * @param integer $id, the ID of model to be reversed
	 */
	public function actionReverseStatus($id)
	{
		$src=QA::reverseStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	/**
	 * Suggests title of news.
	 */
	public function actionSuggestTitle()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$titles=QA::model()->suggestTitle($keyword);
			if($titles!==array())
				echo implode("\n",$titles);
		}
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=QA::model()->findByPk($id);
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
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Performs the action with multi-selected qas from checked models in section
	 * @param string action to perform
	 * @return boolean, true if the action is procced successfully, otherwise return false
	 */
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-qa-list');
		$list_checked = Yii::app()->session["checked-qa-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'update')) {
					foreach ( $list_checked as $id ) {
						$item = QA::model ()->findByPk ( $id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
					Yii::app ()->session ["checked-qa-list"] = array ();
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
	 * Init checkbox selection
	 * @param string $name_params, name of section to work	 
	 */
	public function initCheckbox($name_params){
		if (! isset ( Yii::app ()->session [$name_params] ))
			Yii::app ()->session [$name_params] = array ();
		if (! Yii::app ()->getRequest ()->getIsAjaxRequest ())
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
