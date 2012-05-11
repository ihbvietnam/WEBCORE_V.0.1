<?php

class SiteController extends Controller
{
	/**
	 * @var string the default layout for the views. 
	 */
	public $layout='main';

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
			$this->layout="error";
			if ($error = Yii::app ()->errorHandler->error) {
				if (Yii::app ()->request->isAjaxRequest)
					echo $error ['message'];
				else
					$this->render( 'error', $error );
			}
	}
	/**
	 * This is the action to handle view home page
	 */
	public function actionHome()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status', Product::STATUS_ACTIVE);
		$criteria->order='id desc';
		$criteria->limit=Setting::s('SIZE_REMARK_PRODUCT');
		$list_product=Product::model()->findAll($criteria);
		
		$criteria=new CDbCriteria;
		$criteria->compare('status', Product::STATUS_ACTIVE);
		$criteria->order='id desc';
		$criteria->limit=Setting::s('SIZE_HOME_NEWS');
		$list_news=News::model()->findAll($criteria);
		$this->render( 'home' ,array('list_news'=>$list_news,'list_product'=>$list_product));
	}	
	/**
	 * This is the action to handle view search page
	 */
	public function actionSearch()
	{
		$search=new SearchForm();
		$criteria = new CDbCriteria ();
		if(isset($_POST['SearchForm'])){
			$search->attributes=$_POST['SearchForm'];
			$criteria->compare ( 'name', $search->name, true );
			$criteria->compare ( 'catid', $search->catid );
			if($search->end_price != '')
				$criteria->addCondition('num_price <= '.$search->end_price);
			if($search->start_price != '')
				$criteria->addCondition('num_price >= '. $search->start_price);
		}
		$criteria->order = "id DESC";
		$result=new CActiveDataProvider ( 'Product', array ('criteria' => $criteria, 'pagination' => array ('pageSize' => Setting::s('SEARCH_PAGE_SIZE' ) ) ) );
		$this->render( 'search',array('result'=>$result) );
	}	
/**
	 * Displays product
	 */
	public function actionProduct($cat_alias,$product_alias="")
	{	
		$criteria=new CDbCriteria;
		$criteria->compare('alias',$cat_alias);
		$list_cat=Category::model()->findAll($criteria);
		foreach ($list_cat as $category) {
			if($category->findGroup() == Category::GROUP_PRODUCT) $cat=$category;
		}
		if(isset($cat)) {
			if($product_alias != ""){			
			$criteria=new CDbCriteria;
			$criteria->compare('catid', $cat->id);	
			$criteria->compare('alias', $product_alias);		
			$product=Product::model()->find($criteria);
				if(isset($product)) {
					$this->render('product',array(
					'cat'=>$cat,
					'product'=>$product,
					));
				}
			}
			else {
				$child_categories=$cat->child_categories;
 				$list_child_id=array();
 				//Set itself
 				$list_child_id[]=$cat->id;
 				foreach ($child_categories as $id=>$child_cat){
 					$list_child_id[]=$id;
 				}
				$criteria=new CDbCriteria;
				$criteria->addInCondition('catid',$list_child_id);
				$criteria->compare('status',Product::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_product=new CActiveDataProvider('Product', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('PRODUCT_PAGE_SIZE'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-product',array(
					'cat'=>$cat,
					'list_product'=>$list_product
				));
			}
		}
		
	}
}