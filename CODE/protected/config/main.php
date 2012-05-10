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
	),
	'defaultController'=>'site',
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
				'album/<album_alias>'=>array('site/album','urlSuffix'=>'.html'),
				'album'=>'site/album',
				'q-a/<qa_alias>'=>array('site/qa','urlSuffix'=>'.html'),
				'q-a'=>'site/qa',
				'home'=>'site/index',
				'language/<lang:\w+>'=>'site/language',
				'contact'=>array('site/contact'),
				'sitemap'=>array('site/sitemap'),
				'news/<cat_alias>/<news_alias>'=>array('site/news','urlSuffix'=>'.html'),
				'news/<cat_alias>'=>array('site/news'),
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
			'connectionString' => 'mysql:host=localhost;dbname=core',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
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