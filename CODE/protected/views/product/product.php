<?php 
if(isset($cat))
	$this->bread_crumbs=array(
		array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
		array('url'=>Yii::app()->createUrl('product/list',array('cat_alias'=>$cat->alias)),'title'=>Language::t($cat->name)),
		array('url'=>'','title'=>Language::t($product->name)),
	);
else
	$this->bread_crumbs=array(
		array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
		array('url'=>'','title'=>Language::t($product->name)),
	);
?>
<?php  
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/front/productdetail.js', CClientScript::POS_END);
?>
			<?php $this->widget('wSearch');?> 
            <div class="product-detail">
            	<div class="pd-left">
                	<div class="pd-image">
               	    	<?php echo $product->getThumb_url('detail_introimage');?>
                    </div><!--pd-image-->
                    <?php 
                    $list_id = array_diff ( explode ( ',', $product->otherimage ), array ('' ) );
                    ?>
                    <div class="pd-view">
                    	<?php if(sizeof($list_id)>=1):?>
                    	<?php $image=Image::model ()->findByPk ( $list_id[0] );?>
                    	<a class="pd-viewall" rel="viewall_group" href="<?php echo $image->urlOrigin?>"><?php echo Language::t('Xem thêm ảnh')?></a>
                        <?php endif;?>
                        <div class="image-hidden">
                        <?php for ($i=1;$i<sizeof($list_id);$i++):?>	
  						<?php 
  							$image = Image::model ()->findByPk ( $list_id[$i] );
  						?>				
             			<a rel="viewall_group" href="<?php echo $image->urlOrigin?>"></a>           
           				<?php endfor;?>
                        </div>
                    </div><!--pd-view-->
                </div><!--pd-left-->
                <div class="pd-right">
                	<div class="pd-title">
                    	<h2><?php echo $product->name?></h2>
                    	<?php echo CHtml::ajaxLink(Language::t('Cho vào giỏ'),Yii::app()->createUrl('cart/addCart',array('id'=>$product->id)), array('success'=>'function(data){$("#qty_cart").html(" "+data);jAlert("'.Language::t('Đã thêm sản phẩm vào giỏ hàng').'");}'), array('id'=>'add-cart','class'=>'pd-cart'));?>
                        <h5><?php echo Language::t('Mã SP')?>: <span><?php echo $product->code?></span></h5>
                        <h5><?php echo Language::t('Giá')?>: <span><?php if($product->num_price!='') echo number_format($product->num_price, 0, ',', '.')?></span> <?php echo $product->unit_price?></h5>
                        <h5><?php echo Language::t('Tình trạng')?>: <span><?php if($product->amount_status == 0) echo Language::t('Hết hàng'); else echo Language::t('Còn hàng');?></span></h5>
                        
                    </div><!--pd-title-->
                	<div class="pd-intro">
                        <p><b><?php echo Language::t('Tính năng nổi bật')?>:</b></p>
                        <?php echo $product->description?>
                    </div><!--pd-intro-->
                    <div class="pd-share">
                       <g:plusone size="medium"></g:plusone>
                    </div><!--pd-share--> 
                </div><!--pd-right-->	
            </div><!--product-detail-->
            <div class="tab-outer">
                <div class="tab-title">
                    <a href="#tab1"><?php echo Language::t('Thông số kỹ thuật')?></a>
                </div><!-- tab-title -->
                <div class="tab-container">
                    <div id="tab1" class="tab-content">
                        <?php 
                        if($product->parameter != '') 
                        	echo $product->parameter;
                        else
                        	echo Language::t('Chưa có thông tin cập nhật!');                      
                        ?>
                        <br />                        
                    </div><!-- content-1 -->
                </div><!-- tab-container -->
            </div><!-- tab-outer -->
            <div class="big-title"><label><?php echo Language::t('Sản phẩm tương tự')?></label></div>
            <?php 
            $list_similar=$product->list_similar;
            ?>
            <div class="product-list">
            	<?php foreach ($list_similar as $similar_product):?>
            	<div class="box-item">
                	<div class="b-title"><?php echo $similar_product->name?></div>
                	<a class="b-image" href="<?php echo $similar_product->url?>">
                   		<?php echo $similar_product->getThumb_url('introimage');?>
                    </a>
                   <div class="b-detail">
                      	<h5><?php echo Language::t('Giá')?>: <?php if($similar_product->num_price!='') echo number_format($similar_product->num_price, 0, ',', '.').' '.$similar_product->unit_price?></h5>
                        <a class="b-viewmore" href="<?php echo $similar_product->url?>"><?php echo Language::t('Chi tiết')?></a>
                  	</div>
                </div><!--box-item-->
                <?php endforeach;?>              
            </div><!--product-list-->
<?php 
$cs = Yii::app()->getClientScript(); 
$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/common/jquery.alerts.js');
$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/css/common/jquery.alerts.css');
// Script delete
?>
