<?php

class DefaultController extends Controller
{
	/**
	 * @var string the default layout for the views.
	 */
	public $layout='board';
	
	public function actionIndex()
	{
		$this->redirect(array('news/index'));
	}
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest) $this->redirect(array('news/index'));
		if(!isset(Yii::app()->session['login_incorrect'])){
			Yii::app()->session['login_incorrect']=1;
		}
		$model=new LoginForm;
		if(Yii::app()->session['login_incorrect'] <= User::LIMIT_INCORRECT){
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				$this->redirect(array('news/index'));
			}
			else {
				$login_incorrect=Yii::app()->session['login_incorrect'];
				$login_incorrect++;
				Yii::app()->session['login_incorrect']=$login_incorrect;
				Yii::app ()->user->setFlash ( 'error', 'Username/Password không chính xác.' );
			}
		}
		}
		else {
			Yii::app ()->user->setFlash ( 'error', 'Bạn đã đăng nhập sai 5 lần liên tiếp. Vui lòng thử lại sau.' );
		}
		//The username or password that you entered is incorrect.
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('default/login'));
	}
}