	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1><?php echo Language::t('quản trị ngôn ngữ');?></h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span><?php echo Language::t('Nhập dữ liệu từ file excel');?></span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->	
		<div class="folder-content form">
			<?php
    			foreach(Yii::app()->user->getFlashes() as $key => $message) {
        			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    			}
			?>
			<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false,'htmlOptions' => array('enctype' => 'multipart/form-data'),)); ?>	
			<!--begin left content-->
			<div class="fl" style="width:480px;">
				<ul>
				    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'lang'); ?>
                        <?php echo $form->dropDownList($model,'lang',LanguageForm::getList_all_languages(),array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'lang'); ?>
                    </li>
                    </div>
					<div class="row">
                    <li>
                     <div class="row">
                        <?php echo $form->labelEx($model,'file'); ?>
                        <?php echo $form->fileField($model,'file'); ?>
                  		<?php echo $form->error($model, 'file'); ?>
                    </li>
                    </div>
                   		<li>
                   		<input type="reset" class="button" value="<?php echo Language::t('Hủy thao tác')?>" style="margin-left:153px; width:125px;" />
                    	<input type="submit" class="button" value="<?php echo Language::t('Nhập')?>" style="margin-left:20px; width:125px;" />					 
                    	</li>
				</ul>
			</div>
			<!--end left content-->			
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->