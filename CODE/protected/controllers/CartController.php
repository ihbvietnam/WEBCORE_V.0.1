<?php

class CartController extends Controller {
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
		echo sizeof(Yii::app()->session['cart']);
	}
	
	public function actionCart()
	{
		if(isset(Yii::app()->session['cart']))
		{
			$model=new Order('create');
			if(isset($_POST['Order'])){
				$model->attributes=$_POST['Order'];
				$list_product=Yii::app()->session['cart'];
				$list_item=array();
				foreach ($list_product as $id=>$amount){
					$product=Product::model()->findByPk($id);
					$content=array('amount'=>$amount,'num_price'=>$product->num_price,'unit_price'=>$product->unit_price);
					$list_item[$id]=$content;
				}
				$model->list_item=$list_item;
				if($model->save()){
					Yii::app()->session['cart']=array();
					$model->unsetAttributes();
					Yii::app()->user->setFlash('success', Language::t('Đơn hàng đã được ghi nhận'));
				}
			}			
			$list_product=Yii::app()->session['cart'];		
			$this->render('cart',array(
				'list_product'=>$list_product,
				'model'=>$model	
			));
		}
	}
	/**
	* Product Plus/ Minus Cart
	*/
	public function actionPlusMinusCart($id,$sign)	
	{
		$model=new Order('create');
		$old=Yii::app()->session['cart'];
		$new=Yii::app()->session['cart'];
		if(isset($old[$id]))
		{
		 	$new[$id] = $old[$id] + $sign;
		}
		if ($new[$id] <= 0) {unset($new[$id]);}
		Yii::app()->session['cart']=$new;
		$result=array();
		$result['qty']=sizeof(Yii::app()->session['cart']);
		$result['cart']=$this->renderPartial('cart',array(
				'list_product'=>Yii::app()->session['cart'],
				'model'=>$model
			),true);
		echo json_encode($result);
	}
	/**
	* Remove Selected Product Cart
	*/
	public function actionRemoveCart($id)	
	{
		$model=new Order('create');
		$new=Yii::app()->session['cart'];
		unset($new[$id]);
		Yii::app()->session['cart']=$new;
		$result=array();
		$result['qty']=sizeof(Yii::app()->session['cart']);
		$result['cart']=$this->renderPartial('cart',array(
				'list_product'=>Yii::app()->session['cart'],
				'model'=>$model
			),true);
		echo json_encode($result);
	}
}
