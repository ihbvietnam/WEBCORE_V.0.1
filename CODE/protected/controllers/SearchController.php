<?php

class SearchController extends Controller
{
	/**
	 * @var string the default layout for the views. 
	 */
	public $layout='main';
	public $bread_crumbs=array();

	public function init(){
		parent::init();
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
	}
	/**
	 * This is the action to handle view search page
	 */
	public function actionProduct()
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
		$result=new CActiveDataProvider ( 'Product', array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Setting::s('SEARCH_PAGE_SIZE','Product' ) ) ) );
		$this->render( 'product',array('result'=>$result) );
	}		
}