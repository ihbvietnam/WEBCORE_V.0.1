<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'language'=> 'vi',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.modules.admin.models.*',
		'application.components.core.*',
		'application.components.*',
		'application.models.*',
	),
	'defaultController'=>'site/home',
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'thanhdaica',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin',
		'elfinder'
	),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
			'loginUrl'=>array('admin/default/login'),
		),
		'counter' => array(
            'class' => 'ext.UserCounter',
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(				
				'hien-thi-san-pham/<cat_alias>/<product_alias>'=>array('product/view','urlSuffix'=>'.html'),
				'list-san-pham/<cat_alias>'=>'product/list',
				'tat-ca-san-pham'=>'product/index',
		
				'hien-thi-tin-tuc/<cat_alias>/<news_alias>'=>array('news/view','urlSuffix'=>'.html'),
				'list-tin-tuc/<cat_alias>'=>'news/list',
				'tat-ca-tin-tuc'=>'news/index',
		
				'hien-thi-trang-tinh<cat_alias>/<staticPage_alias>'=>array('staticPage/view','urlSuffix'=>'.html'),
				'list-trang-tinh/<cat_alias>'=>'staticPage/list',
				'tat-ca-trang-tinh'=>'staticPage/index',
		
				'hien-thi-cau-hoi/<qa_alias>'=>array('qA/view','urlSuffix'=>'.html'),
				'tat-ca-cau-hoi'=>'qA/index',
		
				'hien-thi-album/<cat_alias>/<album_alias>'=>array('album/view','urlSuffix'=>'.html'),
				'list-album/<cat_alias>'=>'album/list',
				'tat-ca-album'=>'album/index',
		
				'hien-thi-video/<cat_alias>/<video_alias>'=>array('video/view','urlSuffix'=>'.html'),
				'list-video/<cat_alias>'=>'video/list',
				'tat-ca-video'=>'video/index',
		
				'gio-hang'=>'cart/cart',
				
				'dat-cau-hoi'=>'qA/question',
				'trang-chu'=>'site/home',
				'lien-he'=>'site/contact',
		
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=cms',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'thanhdaica',
			'charset' => 'utf8',
		),
		'authManager'=>array(
			'class' => 'CDbAuthManager',
			'connectionID' => 'db',
		),		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'admin@iphoenix.vn',
		'webRoot' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
	),
	'params'=>array (
	'defaultPageSize'=>10,)
);