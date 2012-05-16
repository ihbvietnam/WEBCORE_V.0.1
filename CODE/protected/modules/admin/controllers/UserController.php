<?php
/**
 * 
 * UserController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * UserController includes actions relevant to User
 *** view
 *** create
 *** update
 *** delete
 *** index
 *** reverse status
 *** reset password
 *** load model
 *** suggest name
 *** suggest email
 *** perform action to list of selected models from checkbox   
 */
class UserController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('changePassword'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','delete','suggestUsername','suggestEmail','resetPassword','reverseStatus','checkbox'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User('create');
		// Ajax validate
		$this->performAjaxValidation($model);				
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];	
			//Create password and salt
			if($model->validate()){
				$model->salt=$model->generateSalt();
				$model->password=$model->hashPassword($model->clear_password,$model->salt);
			}
			if($model->save())
				$this->redirect(array('index'));			
		}
		$this->render('create',array(
			'model'=>$model,
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
		$model->scenario = 'update';
		// Ajax validate
		$this->performAjaxValidation($model);				
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];	
			//Fix bug situation no set role
			if(!isset($_POST['User']['role']))$model->role=array();
			if($model->save())
				$this->redirect(array('index'));			
		}
		$this->render('update',array(
			'model'=>$model,
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->initCheckbox('checked-user-list');
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];
		$this->render('index',array(
			'model'=>$model,
		));
	}
	/**
	 * Reverse status of news
	 * @param integer $id the ID of model to be reversed
	 */
	public function actionReverseStatus($id)
	{
		$src=User::reverseStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	/**
	 * Reset User password
	 * @param integer $id the ID of user to reset password
	 */
	public function actionResetPassword($id)
	{
		$model = $this->loadModel ( $id );
		$model->scenario = 'reset_password';
		// Ajax validate
		$this->performAjaxValidation($model);
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];		
			//Create password and salt
			if($model->validate()){
				$model->salt=$model->generateSalt();
				$model->password=$model->hashPassword($model->clear_password,$model->salt);
			}
			if($model->save())
				$this->redirect(array('index'));			
		}
		$this->render('reset-password',array(
			'model'=>$model,
		));
	}
	/**
	 * Change password
	 */
	public function actionChangePassword()
	{
		$model = $this->loadModel ( Yii::app()->user->id );		
		$model->scenario = 'change_password';
		// Ajax validate
		$this->performAjaxValidation($model);
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];		
			//Create password and salt
			if($model->validate()){
				$model->salt=$model->generateSalt();
				$model->password=$model->hashPassword($model->clear_password,$model->salt);
			}
			if($model->save())
				$this->redirect(array('index'));			
		}
		$this->render('change-password',array(
			'model'=>$model,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
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
	 * Suggests username on the current user input.
	 * This is called via AJAX when the user is entering the email input.
	 */
	public function actionSuggestUsername()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$owners=User::model()->suggestUsername($keyword);
			if($owners!==array())
				echo implode("\n",$owners);
		}
	}
	/**
	 * Suggests email on the current user input.
	 * This is called via AJAX when the user is entering the email input.
	 */
	public function actionSuggestEmail()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$owners=User::model()->suggestEmail($keyword);
			if($owners!==array())
				echo implode("\n",$owners);
		}
	}
	
	/**
	 * Performs the action with multi-selected users from checked models in section
	 * @param string action to perform
	 * @return boolean, true if the action is procced successfully, otherwise return false
	 */
	public function actionCheckbox($action)
	{
		$this->initCheckbox('checked-user-list');
		$list_checked = Yii::app()->session["checked-user-list"];
		switch ($action) {
			case 'delete' :
				if (Yii::app ()->user->checkAccess ( 'update')) {
					foreach ( $list_checked as $id ) {
						$item = User::model ()->findByPk ( $id );
						if (isset ( $item ))
							if (! $item->delete ()) {
								echo 'false';
								Yii::app ()->end ();
							}
					}
					Yii::app ()->session ["checked-user-list"] = array ();
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
