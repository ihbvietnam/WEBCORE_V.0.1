<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>Yii::app()->createUrl('site/product'),'title'=>Language::t('Sản phẩm')),
	array('url'=>'','title'=>Language::t($cat->name)),
)
?>
<?php $this->widget('wSearch');?> 
 <div class="big-title"><label><?php if(isset($cat))echo Language::t($cat->name); else echo Language::t('Toàn bộ sản phẩm');?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$list_product,
					'itemView'=>'_product',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
				)); ?>    