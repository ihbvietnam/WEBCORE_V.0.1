<?php $this->widget('wSearch');?> 
 <div class="big-title"><label><?php echo Language::t($cat->name)?></label></div>
            	<?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$list_product,
					'itemView'=>'_view',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'product-list',
            		'pagerCssClass'=>'pages-inner',
				)); ?>    