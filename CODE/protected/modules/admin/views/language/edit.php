	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1><?php echo Language::t('quản trị ngôn ngữ');?></h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span><?php echo Language::t('Chỉnh sửa ngôn ngữ');?></span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->	
		<div class="folder-content form">
		<?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'form-edit-language')); ?>
		<!--begin box search-->
            <div class="box-search">            
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                        <li>
                        <?php echo $form->labelEx($model,'lang'); ?>
                        <?php echo $form->dropDownList($model,'lang',LanguageForm::getList_languages_exist(),array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'lang'); ?>
                    	</li>           
                         <li>
                        <?php echo $form->labelEx($model,'module'); ?>                        
                        <?php echo $form->dropDownList($model,'module',$model->getList_modules(),array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'module'); ?>
                     </li>
                    </ul>
                </div>
                <!--end left content-->
                <!--begin right content-->
                <div class="fl" style="width:480px;">
                    <ul>                    
                      <li>
                        <?php echo $form->labelEx($model,'controller'); ?>           	 			
                        <?php echo $form->dropDownList($model,'controller',$model->getList_controllers(),array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'controller'); ?>
                     </li>
                      <li>
                        <?php echo $form->labelEx($model,'action'); ?>                        
                        <?php echo $form->dropDownList($model,'action',$model->getList_actions(),array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'action'); ?>
                     </li>
                    </ul>
                </div>
                <!--end right content-->
                <div class="clear"></div>
                <div class="line top bottom"></div>
            </div>
            <!--end box search-->
			<!--begin left content-->
			<div class="fl" id='language-list'>
				<ul>
				<?php echo $form->hiddenField($model,'store_lang'); ?>
				<?php echo $form->hiddenField($model,'store_module'); ?>
				<?php echo $form->hiddenField($model,'store_controller'); ?>
				<?php echo $form->hiddenField($model,'store_action'); ?>
				<?php foreach ($list as $record):?>
				    <div class="row">
                    <li>
                        <?php echo CHtml::label($record->origin,$record->id,array('style'=>'width:450px')); ?>
                        <?php echo CHtml::textField('LanguageForm[records]['.$record->id.']',$record->translation,array('style'=>'width:450px','id'=>$record->origin)); ?>
                    </li>
                    </div>	
                 <?php endforeach;?>   				
                   		<li>
                   		<input type="reset" class="button" value="<?php echo Language::t('Hủy')?>" style="margin-left:153px; width:125px;" />
                    	<input type="submit" class="button" value="<?php echo Language::t('Cập nhật')?>" style="margin-left:20px; width:125px;" />					 
                    	</li>
				</ul>
			</div>
			<!--end left content-->			
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->
        	 <?php 
				Yii::app()->clientScript->registerScript('update', "
				$('#form-edit-language').find('select').change(function(){
					jQuery.ajax({
						data: $('#form-edit-language').serialize(),
						success:function(data){
							var \$data = $('<div>' + data + '</div>');
							var updateId = '#language-list';
							$(updateId).html($(updateId, \$data));
						},
						type:'POST',
						url:'".$this->createUrl('language/edit')."',
						});
				});");
			?>