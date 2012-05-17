<?php

class StaticPageController extends Controller
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
	 * Displays static page
	 */
	public function actionIndex($cat_alias)
	{	
		$criteria=new CDbCriteria;
		$criteria->compare('alias',$cat_alias);
		$list_cat=Category::model()->findAll($criteria);
		foreach ($list_cat as $category) {
			if($category->findGroup() == Category::GROUP_STATICPAGE) $cat=$category;
		}
		if(isset($cat)) {
				$child_categories=$cat->child_categories;
 				$list_child_id=array();
 				//Set itself
 				$list_child_id[]=$cat->id;
 				foreach ($child_categories as $id=>$child_cat){
 					$list_child_id[]=$id;
 				}
				$criteria=new CDbCriteria;
				$criteria->addInCondition('catid',$list_child_id);
				$criteria->compare('status',StaticPage::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_page=new CActiveDataProvider('StaticPage', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('STATICPAGE_PAGE_SIZE','StaticPage'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-page',array(
					'cat'=>$cat,
					'list_page'=>$list_page
				));
		}	
	}	
	public function actionView($cat_alias,$staticPage_alias="")
	{
		$criteria = new CDbCriteria ();
		$criteria->compare ( 'alias', $cat_alias );
		$list_cat = Category::model ()->findAll ( $criteria );
		foreach ( $list_cat as $category ) {
			if ($category->findGroup () == Category::GROUP_STATICPAGE)
				$cat = $category;
		}
		$criteria = new CDbCriteria ();
		if (isset ( $cat ))
			$criteria->compare ( 'catid', $cat->id );
		$criteria->compare ( 'alias', $staticPage_alias );
		$page = StaticPage::model ()->find ( $criteria );
		if (isset ( $page )) {
			$this->render ( 'page', array ('cat' => $cat, 'page' => $page ) );
		}
	}			
}
