<?php

class LanguageController extends Controller
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
				'actions'=>array('edit'),
				'roles'=>array('update'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create','delete','import'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionCreate() {
		$model=new LanguageForm('create');
		if (isset ( $_POST ['LanguageForm'] )) {
			$model->attributes=$_POST['LanguageForm'];				
			if(LanguageForm::copyLanguage ( $model->origin_lang, $model->lang ))
			{
				$this->redirect ( array ('edit', 'language' => $model->lang ) );
			}			
			}
		$this->render ( 'create', array ('model' => $model ) );
	}
	public function actionDelete() {
		$model=new LanguageForm('delete');
		if (isset ( $_POST ['LanguageForm'] )) {
			$model->attributes=$_POST['LanguageForm'];	
			if(LanguageForm::deleteLanguage ($model->lang ))
				{
					Yii::app()->user->setFlash('success', Language::t('Ngôn ngữ đã được xóa'));
				}		
			}
		$this->render ( 'delete', array ('model' => $model ) );
	}
	public function actionEdit() {
		$model = new LanguageForm ('edit');
		$model->lang = isset ( $_GET ['language'] ) ? $_GET ['language'] : Language::DEFAULT_LANGUAGE;
		if (isset ( $_POST ['LanguageForm'] )) {
			$model->lang=$_POST['LanguageForm']['lang'];
			if(in_array($_POST['LanguageForm']['module'], $model->list_modules))
				$model->module=$_POST['LanguageForm']['module'];
			else 
				$store->module=array_shift(array_keys($model->list_modules));
			if(in_array($_POST['LanguageForm']['controller'], $model->list_controllers))
				$model->controller=$_POST['LanguageForm']['controller'];
			else 
				$store->controller=array_shift(array_keys($model->list_controllers));	
			if(in_array($_POST['LanguageForm']['action'], $model->list_actions))
				$model->action=$_POST['LanguageForm']['action'];
			else 
				$store->action=array_shift(array_keys($model->list_actions));	
			//Store 
			$store=new LanguageForm('edit');
			$store->lang=$_POST['LanguageForm']['lang'];
			$store->module=$_POST['LanguageForm']['module'];
			$store->controller=$_POST['LanguageForm']['controller'];
			$store->action=$_POST['LanguageForm']['action'];
			if(isset($_POST['LanguageForm']['records']))
				$store->saveLanguage($_POST['LanguageForm']['records']);
		} else {
			$model->module=array_shift(array_keys($model->list_modules));
			$model->controller=array_shift(array_keys($model->list_controllers));
			$model->action=array_shift(array_keys($model->list_actions));		
		}
		//Store language, module, controller and action
		$model->store_lang=$model->lang;
		$model->store_module=$model->module;
		$model->store_controller=$model->controller;
		$model->store_action=$model->action;
		$list=$model->search();	
		$this->render ( 'edit', array ('model' => $model, 'list'=>$list ) );
	}
	public function actionImport() {
		$model=new ImportForm();
		$model->lang=Language::DEFAULT_LANGUAGE;
	 	if(isset($_POST['ImportForm'])&&CUploadedFile::getInstance($model,'file') != null)
        {
            $model->file=CUploadedFile::getInstance($model,'file');
            $file=$model->file->getTempName();
            $model->lang=$_POST['ImportForm']['lang'];
			Yii::import('admin.extensions.vendors.PHPExcel',true);					
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($file); //$file --> your filepath and filename          
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
            for ($row = 2; $row <= $highestRow; ++$row) {
                $origin=$objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                $translation=$objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                $module=$objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                $controller=$objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
                $action=$objWorksheet->getCellByColumnAndRow(4, $row)->getValue();    
               	$criteria = new CDbCriteria ();
				$criteria->compare ( 'lang', $model->lang );
				$criteria->compare ( 'module', $module );
				$criteria->compare ( 'controller', $controller);
				$criteria->compare ( 'action', $action );
				$criteria->compare ( 'origin', $origin );
				$list = Language::model ()->findAll ( $criteria );
				if(sizeof($list)>0){
					foreach ($list as $item){
						$item->translation=$translation;
						$item->save();
					}
				}
				else {
					$item=new Language();
					$item->lang = $model->lang;
					$item->origin = $origin;
					$item->translation = $translation;
					$item->module = $module;
					$item->controller = $controller;
					$item->action = $action;
					$item->save();
				}
            }
            Yii::app()->user->setFlash('success', Language::t('Bạn đã nhập dữ liệu thành công'));
		}
		$this->render('import',array('model'=>$model));
	}
}

