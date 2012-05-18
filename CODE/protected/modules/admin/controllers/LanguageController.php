<?php
/**
 * 
 * LanguageController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * LanguageController includes actions relevant to Laguage:
 *** create Language
 *** delete Language
 *** edit Language
 *** import Language
 *** export Language  
 */

class LanguageController extends Controller
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
				'actions'=>array('edit'),
				'roles'=>array('update'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create','delete','import','export'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * 
	 * create new Language in system
	 */
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
	
	/**
	 * 
	 * delete language
	 */
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
	/**
	 * 
	 * Edit exist language
	 */
	public function actionEdit() {
		$model = new LanguageForm ('edit');
		$model->lang = isset ( $_GET ['language'] ) ? $_GET ['language'] : Language::DEFAULT_LANGUAGE;
		if (isset ( $_POST ['LanguageForm'] )) {
			$model->lang=$_POST['LanguageForm']['lang'];
			if(in_array($_POST['LanguageForm']['module'], $model->list_modules))
				$model->module=$_POST['LanguageForm']['module'];
			else {
				$list_modules=array_keys($model->list_modules);
				$model->module=array_shift($list_modules);
			}
			if(in_array($_POST['LanguageForm']['controller'], $model->list_controllers))
				$model->controller=$_POST['LanguageForm']['controller'];
			else {
				$list_controllers=array_keys($model->list_controllers);
				$model->controller=array_shift($list_controllers);					
			}
			if(in_array($_POST['LanguageForm']['action'], $model->list_actions))
				$model->action=$_POST['LanguageForm']['action'];
			else {
				$list_actions=array_keys($model->list_actions);
				$model->action=array_shift($list_actions);	
			}	
			//Store 
			$store=new LanguageForm('edit');
			$store->lang=$_POST['LanguageForm']['lang'];
			$store->module=$_POST['LanguageForm']['module'];
			$store->controller=$_POST['LanguageForm']['controller'];
			$store->action=$_POST['LanguageForm']['action'];
			if(isset($_POST['LanguageForm']['records']))
				$store->saveLanguage($_POST['LanguageForm']['records']);
		} else {
			$list_modules=array_keys($model->list_modules);
			$model->module=array_shift($list_modules);
			$list_controllers=array_keys($model->list_controllers);
			$model->controller=array_shift($list_controllers);
			$list_actions=array_keys($model->list_actions);
			$model->action=array_shift($list_actions);		
		}
		//Store language, module, controller and action
		$model->store_lang=$model->lang;
		$model->store_module=$model->module;
		$model->store_controller=$model->controller;
		$model->store_action=$model->action;
		$list=$model->search();	
		$this->render ( 'edit', array ('model' => $model, 'list'=>$list ) );
	}
	/**
	 * 
	 * import new language into system
	 * news word are stored in excel file
	 */
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
	/**
	 * 
	 * Export language into excel file (MS 2007 - .xlsx)
	 */
	public function actionExport() {   
		$model = new LanguageForm ( 'export' );
		$model->lang=Yii::app()->language;
		if (isset ( $_POST ['LanguageForm'] )) {
			if($_POST ['LanguageForm']['lang'])
				$language=$_POST ['LanguageForm']['lang'];
			//Get data
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'lang', $language );
			$criteria->order = 'module,controller,action';
			$list = Language::model ()->findAll ( $criteria );
			
			//Set header for file excel
			$data [0] ['origin'] = 'ORIGIN';
			$data [0] ['translation'] = 'TRANSLATION';
			$data [0] ['module'] = 'MODULE';
			$data [0] ['controller'] = 'CONTROLLER';
			$data [0] ['action'] = 'ACTION';
			//Set content for file excel
			$index = 1;
			foreach ( $list as $record ) {
				$data [$index] ['origin'] = $record->origin;
				$data [$index] ['translation'] = $record->translation;
				$data [$index] ['module'] = $record->module;
				$data [$index] ['controller'] = $record->controller;
				$data [$index] ['action'] = $record->action;
				$index ++;
			}
			
			Yii::import ( 'admin.extensions.vendors.PHPExcel', true );
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel ();
			
			// Set properties
			$objPHPExcel->getProperties ()->setCreator ( "IHB Việt Nam" )->setLastModifiedBy ( "IHB Việt Nam" )->setTitle ( "Cấu hình ngôn ngữ" )->setSubject ( "Ngôn ngữ" )->setDescription ( "Xuất dữ liệu ra file excel" )->setKeywords ( "language,excel,export" )->setCategory ( "Ngôn ngữ" );
			foreach ( $data as $index => $item ) {
				$j = $index + 1;
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'A' . $j, isset ( $item ['origin'] ) ? $item ['origin'] : '' );
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'B' . $j, isset ( $item ['translation'] ) ? $item ['translation'] : '' );
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'C' . $j, isset ( $item ['module'] ) ? $item ['module'] : '' );
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'D' . $j, isset ( $item ['controller'] ) ? $item ['controller'] : '' );
				$objPHPExcel->setActiveSheetIndex ( 0 )->setCellValue ( 'E' . $j, isset ( $item ['action'] ) ? $item ['action'] : '' );
			}
			//Export file CSV
			$objWriter = PHPExcel_IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
			$file_path = Yii::getPathOfAlias ( 'webroot' ) . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'language-' . $language . '.xlsx';		
			$objWriter->save ( $file_path );
			// force to download a file
			header ( "Pragma: public" );
			header ( "Expires: 0" );
			header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
			header ( "Content-Type: application/force-download" );
			header ( "Content-Disposition: attachment; filename=" . basename ( $file_path ) );
			header ( "Content-Description: File Transfer" );
			@readfile ( $file_path );
		}
		$this->render ( 'export', array ('model' => $model ) );
	}
}

