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
	/**
	 * This is the action to handle view home page
	 */
	public function actionHome()
	{
		$this->render( 'home' );
	}	
		/**
	 * This is the action to handle view home page
	 */
	public function actionSearch()
	{
		$search=new SearchForm();
		$criteria = new CDbCriteria ();
		if(isset($_POST['SearchForm'])){
			$search->attributes=$_POST['SearchForm'];
			$criteria->compare ( 'name', $search->name, true );
			$criteria->compare ( 'catid', $search->catid );
			if($search->end_price != '')
				$criteria->addCondition('num_price <= '.$search->end_price);
			if($search->start_price != '')
				$criteria->addCondition('num_price >= '. $search->start_price);
		}
		$criteria->order = "id DESC";
		$result=new CActiveDataProvider ( 'Product', array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Setting::s('SEARCH_PAGE_SIZE' ) ) ) );
		$this->render( 'search',array('result'=>$result) );
	}	
}