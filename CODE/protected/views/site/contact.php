<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>'','title'=>Language::t('Liên hệ')),
)
?>
<?php  
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/front/contact.js', CClientScript::POS_END);
?>
<div class="contact-outer">
            	<div class="contact-detail">
                	<h2><?php echo Language::t(Setting::s('COMPANY'));?></h2>
                    <p><?php echo Language::t('Số TK');?>: <?php echo Language::t(Setting::s('BANK_ACCOUNT'));?></p>
                    <p><?php echo Language::t('MST');?>: <?php echo Language::t(Setting::s('MA_SO_THUE'));?></p>
                    <p><?php echo Language::t('Email');?>: <?php echo Language::t(Setting::s('EMAIL'));?></p>
                    <p><?php echo Language::t('Website');?>: <?php echo Language::t(Setting::s('WEBSITE'));?></p>
                </div><!--contact-detail-->	
                <div class="contact-tab">
                	<div class="tab-click1 active">
                    	<h3><?php echo Language::t('Văn phòng giao dịch');?></h3>
                        <p><?php echo Language::t(Setting::s('ADDRESS'));?></p>
                        <p><?php echo Language::t('ĐT');?>: <?php echo Language::t(Setting::s('MOBILE'));?></p>
                    </div><!--tab-click-->
                    <div class="tab-click2">
                    	<h3><?php echo Language::t('Showroom');?></h3>
                        <p><?php echo Language::t(Setting::s('ADDRESS_SHOWROOM'));?></p>
                        <p><?php echo Language::t('ĐT');?>: <?php echo Language::t(Setting::s('MOBILE_SHOWROOM'));?></p>
                    </div><!--tab-click-->
                </div><!--contact-tab-->
                <div class="contact-map">
                	<div class="tab-content1">
                    	Bản đồ 1
                    </div>
                    <div class="tab-content2">
                    	Bản đồ 2
                    </div>
                </div><!--contact-map-->
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
                     <?php echo $form->labelEx($model,'content'); ?>
                     <?php echo $form->textField($model,'content',array('style'=>'width:400px; min-height:150px;')); ?>	
					 <?php echo $form->error($model, 'content'); ?>
                     </div>              
                    <div class="row">
                        <input type="submit" value="Gửi đi" class="button" name="btn-submit" />
                    </div>
                <?php $this->endWidget(); ?>
            </div><!--contact-outer-->
