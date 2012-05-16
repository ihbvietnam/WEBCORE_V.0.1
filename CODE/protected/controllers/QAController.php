<?php

class SiteController extends Controller
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
	 * Displays qa
	 */
	public function actionQA($qa_alias="")
	{
		if ($qa_alias != "") {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'alias', $qa_alias );
			$qa = QA::model ()->find ( $criteria );
			if (isset ( $qa )) {
				$this->render ( 'qa', array ('cat' => $cat, 'qa' => $qa ) );
			}
		} else {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'status', QA::STATUS_ACTIVE );
			$criteria->order = 'id desc';
			$list_qa = new CActiveDataProvider ( 'QA', array ('pagination' => array ('pageSize' => Setting::s ( 'QA_PAGE_SIZE' ) ), 'criteria' => $criteria ) );
			$this->render ( 'list-qa', array ('list_qa' => $list_qa ) );
		}	
	}
	/**
	 * Create question
	 */
	public function actionQuestion()
	{
		$model=new QA('question');
		if(isset($_POST['QA'])){
			$model->attributes=$_POST['QA'];
			$model->title=$model->question;
			if($model->save())
				Yii::app()->user->setFlash('success', Language::t('Câu hỏi đã được gửi thành công'));
		}
		$this->render( 'question' ,array('model'=>$model));
	}
}
