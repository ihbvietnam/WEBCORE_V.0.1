<div class="search-product">
            	<label>Tùy chọn</label>
            	<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false,'action'=>Yii::app()->createUrl('site/search'))); ?>	
                <?php echo $form->textField($search,'name'); ?>	
                <?php 
						$list=array(''=>'Tất cả');
						foreach ($list_category as $id=>$cat){
							$view = "";
							for($i=1;$i<$cat['level'];$i++){
								$view .='---';
							}
							$list[$id]=$view.' '.$cat['name'].' '.$view;
						}
						?>
              	<?php echo $form->dropDownList($search,'catid',$list,array('style'=>'width:140px')); ?>
              	<?php echo $form->dropDownList($search,'start_price',array(''=>'Giá từ')+$search->list_start_price,array('style'=>'width:140px')); ?>
              	<?php echo $form->dropDownList($search,'end_price',array(''=>'Đến giá')+$search->list_end_price,array('style'=>'width:140px')); ?>
                <input name="" type="submit" value="Tìm kiếm" class="btn-filter" />
               <?php $this->endWidget(); ?>
            </div><!--search-product-->
