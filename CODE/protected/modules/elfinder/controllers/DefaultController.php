<?php

class DefaultController extends Controller
{
    public function actionConnector()
	{
        $this->layout=false;
        
        Yii::import('elfinder.vendors.*');
        require_once('elFinder.class.php');
		
        //Create folder year/month/day
		$path=Image::createDir('upload');
		$origin =$path."/origin_editor";
		if(!file_exists($origin)){
			mkdir($origin);
		}
        $opts=array(
            'root'=>Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$origin,
            'URL'=>Yii::app()->request->getBaseUrl(true).'/'.$origin.'/',
            'rootAlias'=>'Home',
        	'uploadAllow' => array('image/*','video/*','audio/*'),
        	'uploadDeny'  => array('text', 'application'),
        	'uploadOrder' => 'deny,allow',
        	'archivers' => array(
		 		'create' => array(
		 			'application/x-gzip' => array(
		 				'cmd' => 'tar',
		 				'argc' => '-czf',
		 				'ext'  => 'tar.gz'
		 				)
		 			),
		 		'extract' => array(
		 			'application/x-gzip' => array(
		 				'cmd'  => 'tar',
		 				'argc' => '-xzf',
		 				'ext'  => 'tar.gz'
		 				),
		 			'application/x-bzip2' => array(
		 				'cmd'  => 'tar',
		 				'argc' => '-xjf',
		 				'ext'  => 'tar.bz'
		 				)
		 			)
		 		)
        	);
        $fm=new elFinder($opts);
        $fm->run();
	}
}