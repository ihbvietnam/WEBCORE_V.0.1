<?php
/**
 * 
 * ImageController class file 
 * @author ihbvietnam <hotro@ihbvietnam.com>
 * @link http://iphoenix.vn
 * @copyright Copyright &copy; 2012 IHB Vietnam
 * @license http://iphoenix.vn/license
 *
 */

/**
 * ImageController includes actions relevant to Image:
 *** upload image
 *** delete image
 *** update image
 *** list image
 *** clear image
 *** reverse model's status
 *** suggest model's title
 *** load model from id  
 */
class ImageController extends Controller
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
				'actions'=>array('update','delete','upload','list','reverseStatus','suggestTitle'),
				'roles'=>array('create'),
			),		
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('clear'),
				'roles'=>array('admin'),
			),	
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * 
	 * upload image into server
	 */
	public function actionUpload()
	{
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		//Create folder year/month/day
		$folder=Image::createDir('upload');
        $allowedExtensions = array("jpg","gif","png");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;// it's array
	}
	
	/**
	 * 
	 * delete model
	 * @param integer $id the ID of model to be deleted
	 */
	public function actionDelete($id)
	{
			if($this->loadModel($id)->delete()) 
				echo '{"status":true,"id":'.$id.'}';
			else 
				echo '{"status":false}';
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
			$model = $this->loadModel ( $id );	
			$model->scenario = 'update';
			if (isset ( $_POST ['Image'] )) {
				$model->attributes = $_POST ['Image'];
				if ($model->save ())
					$this->redirect ( array ('update', 'id' => $model->id ) );
			}
			$zoom=(int)Image::MAX_WIDTH_THUMB_IMAGE_UPDATE/$model->width;
			$size['w']=$zoom*$model->width;
			$size['h']=$zoom*$model->height;
			$thumb_url=Yii::app()->request->getBaseUrl(true).'/'.$model->src.'/origin/'.$model->filename.'.'.$model->extension;			
			$this->renderPartial('update', array ('model' => $model,'thumb_url'=> $thumb_url, 'size'=>$size ) );
	}
	
	/**
	 * 
	 * List all images belong to a object (banner or album)
	 * @param $catid
	 * @param $params_size_1
	 * @param $params_size_2
	 */
	public function actionList($category,$parent_id) {
		$model=new Image('search');		
		$model->unsetAttributes();  // clear any default values
		$model->parent_id=$parent_id;
		$model->category=$category;
		$model->attributes=$_GET['Image'];
		$this->render('list',array(
			'model'=>$model,
		));
	}
	
	/**
	 * 
	 * Clear all image in the list of object (album or banner)
	 */
	public function actionClear()
	{
		$list_images=Image::model()->findAll('parent_id = 0');
		foreach($list_images as $image){
			if(!$image->delete()) {
				echo json_encode(array('success'=>false));
				Yii::app()->end();
			}
		}
		echo json_encode(array('success'=>true));
	}
	
	/**
	 * Reverse status of image
	 * @param integer $id, the ID of model to be reversed
	 */
	public function actionReverseStatus($id)
	{
		$src=Image::reverseStatus($id);
			if($src) 
				echo json_encode(array('success'=>true,'src'=>$src));
			else 
				echo json_encode(array('success'=>false));		
	}
	
	/**
	 * Suggests title of image.
	 */
	public function actionSuggestTitle()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$titles=Image::model()->suggestTitle($keyword);
			if($titles!==array())
				echo implode("\n",$titles);
		}
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Image $model, the model has ID
	 */
	public function loadModel($id)
	{
		$model=Image::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
