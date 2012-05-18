<?php
class RbacController extends CController {
	public function filters() {
		return array ('accessControl' );
	}
	public function accessRules() {
		return array (
			array (
				'allow', 
				'actions' => array ('init') 
			), 
			array ('deny' ) );
	}
	public function actionInit() {
		$auth = Yii::app ()->authManager;
		$auth->createOperation ( 'createPost', 'create a post' );
		$auth->createOperation ( 'updatePost', 'update a post' );
		$auth->createOperation ( 'deletePost', 'delete a post' );

		$bizRule = 'return Yii::app()->user->id==$params["post"]->created_by;';
		
		$task = $auth->createTask ( 'updateOwnPost', 'update a post by author himself', $bizRule );
		$task->addChild ( 'updatePost' );
		
		$role = $auth->createRole ( 'author' );
		$role->addChild ( 'createPost' );
		$role->addChild ( 'updateOwnPost' );
		
		$role = $auth->createRole ( 'editor' );
		$role->addChild ( 'updatePost' );
		
		$role = $auth->createRole ( 'admin' );
		$role->addChild ( 'editor' );
		$role->addChild ( 'author' );
		$role->addChild ( 'deletePost' );
	}	
}
?>