<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>Yii::app()->createUrl('album/list',array('cat_alias'=>$cat->alias)),'title'=>Language::t($cat->name)),
	array('url'=>'','title'=>$album->title),
)
?>
<div class="news-outer">
            	<div class="news-left">
                	<div class="news-detail">
                    	<a class="news-link" href="<?php echo $album->url?>"><?php echo $album->title?></a>
                        <h6><?php echo date("(d/m/Y)",$album->created_date); ?></h6>        
                        <div class="news-content">
                        </div><!--news-content-->
                    </div><!--news-detail-->
                    <?php 
            			$list_similar=$album->list_similar;
            		?>
                    <div class="other-list">
                        <h2><?php echo Language::t('Các tin khác');?>:</h2>
                        <ul>
                        <?php foreach ($list_similar as $similar_album):?>
                            <li><a href="<?php echo $similar_album->url?>"><?php echo $similar_album->title?></a><span>(<?php echo date("d/m/Y",$similar_news->created_date); ?>)</span></li>
                       <?php endforeach;?> 
                       </ul>
                    </div><!--other-list-->
                </div><!--news-left-->
              	<div class="news-right">
                	<div class="winget">
                		<?php $this->widget('wProduct',array('view'=>'best-seller','special'=>Product::SPECIAL_BESTSELLER,'limit'=>Setting::s('SIZE_BESTSELLER_PRODUCT','Product')));?>                    	
                  </div><!--winget-->
                  <div class="ad-right">
                  		<?php $this->widget('wBanner',array('code'=>Banner::CODE_RIGHT,'view'=>'banner-right'))?>
                  </div><!--ad-right-->
                </div><!--news-right-->
            </div><!--news-outer-->
