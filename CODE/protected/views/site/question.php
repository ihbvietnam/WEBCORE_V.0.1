<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>Yii::app()->createUrl('site/question'),'title'=>Language::t('Đặt câu hỏi')),
)
?>
<div class="contact-outer">
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'contact-form form','style'=>'display:block'))); ?>
                     <?php
    					foreach(Yii::app()->user->getFlashes() as $key => $message) {
        					echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    					}
					?>
                    <div class="row fix-inline">
                        <h3>(*) Phần thông tin bắt buộc:</h3>
                    </div>
                    <div class="row fix-inline">
                        <?php echo $form->labelEx($model,'fullname'); ?>
                        <?php echo $form->textField($model,'fullname',array('style'=>'width:288px;')); ?>	
						<?php echo $form->error($model, 'fullname'); ?>		
                    </div>
                    <div class="row fix-inline">
                   		<?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->textField($model,'email',array('style'=>'width:288px;')); ?>	
						<?php echo $form->error($model, 'email'); ?>	
                    </div>
                    <div class="row fix-inline">
                        <?php echo $form->labelEx($model,'phone'); ?>
                        <?php echo $form->textField($model,'phone',array('style'=>'width:288px;')); ?>	
						<?php echo $form->error($model, 'phone'); ?>
                    </div>
                    <div class="row fix-inline">
                        <?php echo $form->labelEx($model,'address'); ?>
                        <?php echo $form->textField($model,'address',array('style'=>'width:288px;')); ?>	
						<?php echo $form->error($model, 'address'); ?>
                    </div>
                    <div class="row fix-inline">
                     <?php echo $form->labelEx($model,'question'); ?>
                     <?php echo $form->textField($model,'question',array('style'=>'width:400px; min-height:150px;')); ?>	
					 <?php echo $form->error($model, 'question'); ?>
                     </div>              
                    <div class="row">
                        <input type="submit" value="Gửi đi" class="button" name="btn-submit" />
                    </div>
                <?php $this->endWidget(); ?>
            </div><!--contact-outer-->
