<?php

class SiteController extends Controller
{
	/**
	 * @var string the default layout for the views. 
	 */
	public $layout='main';
	public $bread_crumbs=array();

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
	public function actionContact()
	{
		$model=new Contact('create');
		if(isset($_POST['Contact'])){
			$model->attributes=$_POST['Contact'];
			if($model->save())
				Yii::app()->user->setFlash('success', Language::t('Liên hệ đã được gửi thành công'));
		}
		$this->render( 'contact' ,array('model'=>$model));
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
		$criteria->addNotInCondition('catid', array(News::PRESENT_CATEGORY,News::GUIDE_CATEGORY));
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
	public function actionProduct($cat_alias="",$product_alias="")
	{
		if ($cat_alias != "") {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'alias', $cat_alias );
			$list_cat = Category::model ()->findAll ( $criteria );
			foreach ( $list_cat as $category ) {
				if ($category->findGroup () == Category::GROUP_PRODUCT)
					$cat = $category;
			}
			if (isset ( $cat )) {
				if ($product_alias != "") {
					$criteria = new CDbCriteria ();
					$criteria->compare ( 'catid', $cat->id );
					$criteria->compare ( 'alias', $product_alias );
					$product = Product::model ()->find ( $criteria );
					if (isset ( $product )) {
						$this->render ( 'product', array ('cat' => $cat, 'product' => $product ) );
					}
				} else {
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
					$list_product = new CActiveDataProvider ( 'Product', array ('pagination' => array ('pageSize' => Setting::s ( 'PRODUCT_PAGE_SIZE' ) ), 'criteria' => $criteria ) );
					$this->render ( 'list-product', array ('cat' => $cat, 'list_product' => $list_product ) );
				}
			}
		} else {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'status', Product::STATUS_ACTIVE );
			$criteria->order = 'id desc';
			$list_product = new CActiveDataProvider ( 'Product', array ('pagination' => array ('pageSize' => Setting::s ( 'PRODUCT_PAGE_SIZE' ) ), 'criteria' => $criteria ) );
			$this->render ( 'list-product', array ('list_product' => $list_product ) );
		}		
	}
	/**
	 * Displays news
	 */
	public function actionNews($cat_alias,$news_alias="")
	{	
		$criteria=new CDbCriteria;
		$criteria->compare('alias',$cat_alias);
		$list_cat=Category::model()->findAll($criteria);
		foreach ($list_cat as $category) {
			if($category->findGroup() == Category::GROUP_NEWS) $cat=$category;
		}
		if(isset($cat)) {
			if($news_alias != ""){			
			$criteria=new CDbCriteria;
			$criteria->compare('catid', $cat->id);	
			$criteria->compare('alias', $news_alias);		
			$news=News::model()->find($criteria);
				if(isset($news)) {
					$this->render('news',array(
					'cat'=>$cat,
					'news'=>$news,
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
				$criteria->compare('status',News::STATUS_ACTIVE);
				$criteria->order='id desc';
				$list_news=new CActiveDataProvider('News', array(
					'pagination'=>array(
						'pageSize'=>Setting::s('NEWS_PAGE_SIZE'),
					),
					'criteria'=>$criteria,
				));
				$this->render('list-news',array(
					'cat'=>$cat,
					'list_news'=>$list_news
				));
			}
		}
		
	}
	/**
	 * Displays qa
	 */
	public function actionQA($qa_alias="")
	{
		if ($qa_alias != "") {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'alias', $qa_alias );
			$qa = QA::model ()->find ( $criteria );
			if (isset ( $qa )) {
				$this->render ( 'qa', array ('cat' => $cat, 'qa' => $qa ) );
			}
		} else {
			$criteria = new CDbCriteria ();
			$criteria->compare ( 'status', QA::STATUS_ACTIVE );
			$criteria->order = 'id desc';
			$list_qa = new CActiveDataProvider ( 'QA', array ('pagination' => array ('pageSize' => Setting::s ( 'QA_PAGE_SIZE' ) ), 'criteria' => $criteria ) );
			$this->render ( 'list-qa', array ('list_qa' => $list_qa ) );
		}	
	}
	/**
	 * Create question
	 */
	public function actionQuestion()
	{
		$model=new QA('question');
		if(isset($_POST['QA'])){
			$model->attributes=$_POST['QA'];
			$model->title=$model->question;
			if($model->save())
				Yii::app()->user->setFlash('success', Language::t('Câu hỏi đã được gửi thành công'));
		}
		$this->render( 'question' ,array('model'=>$model));
	}
		/**
	* Add Product to Cart
	*/
	public function actionAddCart($id)	
	{
		if(!isset(Yii::app()->session['cart']))
			Yii::app()->session['cart']=array();
		$old=Yii::app()->session['cart'];
		$new=Yii::app()->session['cart'];
		if(isset($old[$id]))
		{
		 	$new[$id] = $old[$id] + 1;
		}
		else
		{
		 	$new[$id]=1;
		}
		Yii::app()->session['cart']=$new;
		if(Yii::app()->getRequest()->getUrlReferrer())
			Yii::app()->request->redirect(Yii::app()->getRequest()->getUrlReferrer());
		else
			Yii::app()->request->redirect(Yii::app()->createUrl('site/product')); 
	}
	
	public function actionCart()
	{
		if(isset(Yii::app()->session['cart']))
		{
			$list_product=Yii::app()->session['cart'];		
			$this->render('cart',array(
				'list_product'=>$list_product	
			));
		}
	}
	/**
	* Product Plus/ Minus Cart
	*/
	public function actionPlusMinusCart($id,$sign)	
	{
		$old=Yii::app()->session['cart'];
		$new=Yii::app()->session['cart'];
		if(isset($old[$id]))
		{
		 	$new[$id] = $old[$id] + $sign;
		}
		if ($new[$id] <= 0) {unset($new[$id]);}
		Yii::app()->session['cart']=$new;
		Yii::app()->request->redirect(Yii::app()->getRequest()->getUrlReferrer());
	}
	/**
	* Remove Selected Product Cart
	*/
	public function actionRemoveCart($id)	
	{
		$new=Yii::app()->session['cart'];
		unset($new[$id]);
		Yii::app()->session['cart']=$new;
		Yii::app()->request->redirect(Yii::app()->getRequest()->getUrlReferrer());
	}
	/**
	 * This is action for add information when customer checkout
	 */
	public function actionAddInfo()
	{
		$model = new Order('create');
		$this->performAjaxValidation($model);	
		if(isset($_POST['Order']) AND empty($_POST['Order']))
		{
			var_dump($_POST['Order']);
			$model->attributes=$_POST['Order'];
			if($model->save()){
				$model=new Order('create');
			}
		}
		$this->render('addinfo',array(
			'model'=>$model	
		));
	} 
}