<?php

class ProductController extends Controller {
	/**
	 * @var string the default layout for the views. 
	 */
	public $layout = 'main';
	public $bread_crumbs = array ();
	public function init(){
		parent::init();
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
	}
	/**
	 * Displays all product
	 */
	public function actionIndex() {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'status', Product::STATUS_ACTIVE );
			$criteria->order = 'id desc';
			$list_product = new CActiveDataProvider ( 'Product', array ('pagination' => array ('pageSize' => Setting::s ( 'PRODUCT_PAGE_SIZE','Product' ) ), 'criteria' => $criteria ) );
			$this->render ( 'list-product', array ('cat' => $cat, 'list_product' => $list_product ) );
	}
	/**
	 * Displays a category product
	 */
	public function actionList($cat_alias) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$list_cat = Category::model ()->findAll ( $criteria );
		foreach ( $list_cat as $category ) {
			if ($category->findGroup () == Category::GROUP_PRODUCT)
				$cat = $category;
		}
		if (isset ( $cat )) {
			$child_categories = $cat->child_categories;
			$list_child_id = array ();
			//Set itself
			$list_child_id [] = $cat->id;
			foreach ( $child_categories as $id => $child_cat ) {
				$list_child_id [] = $id;
			}
			$criteria = new CDbCriteria ();
			$criteria->addInCondition ( 'catid', $list_child_id );
			$criteria->compare ( 'status', Product::STATUS_ACTIVE );
			$criteria->order = 'id desc';
			$list_product = new CActiveDataProvider ( 'Product', array ('pagination' => array ('pageSize' => Setting::s ( 'PRODUCT_PAGE_SIZE','Product' ) ), 'criteria' => $criteria ) );
			$this->render ( 'list-product', array ('cat' => $cat, 'list_product' => $list_product ) );
		}
	}
	/**
	 * Displays product
	 */
	public function actionView($cat_alias, $product_alias) {
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$list_cat = Category::model ()->findAll ( $criteria );
		foreach ( $list_cat as $category ) {
			if ($category->findGroup () == Category::GROUP_PRODUCT)
				$cat = $category;
		}
		if (isset ( $cat )) {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'catid', $cat->id );
			$criteria->compare ( 'alias', $product_alias );
			$product = Product::model ()->find ( $criteria );
			if (isset ( $product )) {
				$this->render ( 'product', array ('cat' => $cat, 'product' => $product ) );
			}
		}
	}
}
