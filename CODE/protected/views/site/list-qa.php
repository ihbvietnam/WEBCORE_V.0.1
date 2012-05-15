<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>'','title'=>Language::t('Danh sách câu hỏi')),
)
?>
<div class="news-outer">
            	<div class="news-left">
                <?php $this->widget('iPhoenixListView', array(
					'dataProvider'=>$list_qa,
					'itemView'=>'_qa',
					'template'=>"{items}\n{pager}",
            		'pager'=>array('class'=>'iPhoenixLinkPager'),
            		'itemsCssClass'=>'news-list',
            		'pagerCssClass'=>'pages-inner',
				)); 
				?> 
                </div><!--news-left-->
              	<div class="news-right">
                	<div class="winget">
                		<?php $this->widget('wBestSeller');?>                     	
                  </div><!--winget-->
                  <div class="ad-right">
                  		<?php $this->widget('wBannerRight');?> 
                  </div><!--ad-right-->
                </div><!--news-right-->
            </div><!--news-outer-->