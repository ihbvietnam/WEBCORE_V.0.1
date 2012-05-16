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
		/*
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'video/<video_alias>'=>array('site/video','urlSuffix'=>'.html'),
				'video'=>'site/video',
				'hoi-dap/<qa_alias>'=>array('site/qa','urlSuffix'=>'.html'),
				'hoi-dap'=>'site/qa',
				'trang-chu'=>'site/home',
				'lien-he'=>array('site/contact'),
				'dat-cau-hoi'=>array('site/question'),
				'tin-tuc/<cat_alias>/<news_alias>'=>array('site/news','urlSuffix'=>'.html'),
				'tin-tuc/<cat_alias>'=>array('site/news'),
				'san-pham/<cat_alias>/<product_alias>'=>array('site/product','urlSuffix'=>'.html'),
				'san-pham/<cat_alias>'=>array('site/product'),
				'san-pham'=>array('site/product'),
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dogo',
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