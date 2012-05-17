<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>'','title'=>Language::t('Kết quả tìm kiếm')),
)
?>
<?php $this->widget('wSearch');?> 
 <div class="big-title"><label><?php echo Language::t('Kết quả tìm kiếm')?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$result,
					'itemView'=>'_product',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
				)); ?>          	               