<?php

class SiteController extends Controller
{
	/**
	 * @var string the default layout for the views. 
	 */
	public $layout='main';

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
			$this->layout="error";
			if ($error = Yii::app ()->errorHandler->error) {
				if (Yii::app ()->request->isAjaxRequest)
					echo $error ['message'];
				else
					$this->render( 'error', $error );
			}
	}
}