<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>Yii::app()->createUrl('site/qa'),'title'=>Language::t('Danh sách câu hỏi')),
	array('url'=>'','title'=>Language::t($qa->question)),
)
?>
<div class="news-outer">
            	<div class="news-left">
                    <div class="faq-detail">
                        <label class="faq-title"><?php echo $qa->question?></label>
                        <div class="faq-h6"><?php echo Language::t('Câu trả lời')?>:</div>
                        <div class="faq-maindetail">
                        <?php echo $qa->answer;?>
                        </div><!--faq-maindetail--> 
                    </div><!--faq-detail-->
                   <?php 
            			$list_similar=$qa->list_similar;
            		?>
                    <div class="other-list">
                        <h2><?php echo Language::t('Câu hỏi khác')?>:</h2>
                        <ul>
                        <?php foreach ($list_similar as $similar_qa):?>
                            <li><a href="<?php echo $similar_qa->url;?>"><?php echo $similar_qa->question;?></a></li>
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