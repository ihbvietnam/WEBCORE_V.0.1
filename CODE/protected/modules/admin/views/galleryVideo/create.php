<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị video</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thêm video mới</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
                <input type="button" class="button" value="Danh sách video" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/galleryVideo')?>'"/>
                <div class="line top bottom"></div>	
            </div>
		<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<!--begin left content-->
			<div class="fl" style="width:480px;">
				<ul>
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'title'); ?>
							<?php echo $form->textField($model,'title',array('style'=>'width:280px;','maxlength'=>'256')); ?>	
							<?php echo $form->error($model, 'title'); ?>				
						</li>
					</div>	
					<div class="row">
                    	<li>
							<?php echo $form->labelEx($model,'lang'); ?>
							<?php echo $form->dropDownList($model,'lang',LanguageForm::getList_languages_exist(),array('style'=>'width:200px')); ?>
							<?php echo $form->error($model, 'lang'); ?>
                    	</li>
                    </div>	
					<div class="row">
					<li>
						<?php echo $form->labelEx($model,'link'); ?>
						<?php echo $form->textField($model,'link',array('style'=>'width:280px;','maxlength'=>'256')); ?>	
						<?php echo $form->error($model, 'link'); ?>				
					</li>
					</div>	
					 <div class="row">
						<li>
							<?php echo $form->labelEx($model,'introimage'); ?>
							<?php echo $this->renderPartial('/image/_signupload', array('model'=>$model,'attribute'=>'introimage','type_image'=>'thumb_update')); ?>		
							<?php echo $form->error($model, 'introimage'); ?>
						</li>
					</div>		
					<div class="row">
                    	<li>
                        	<?php echo $form->labelEx($model,'list_special'); ?>
                        	<?php echo $form->dropDownList($model,'list_special',GalleryVideo::getList_label_specials(),array('style'=>'width:150px','multiple' => 'multiple')); ?>
                  			<?php echo $form->error($model, 'list_special'); ?>
                    	</li>
                    	</div>			  						
                    <li>
						<input type="submit" class="button" value="Thêm video" style="margin-left:153px; width:125px;" />						
					</li>
				</ul>
			</div>
			<!--end left content-->
						<!--begin right content-->
			<div class="fl menu-tree" style="width:470px;">
			<ul>
				<div class="row">
					<li>
						<?php echo $form->labelEx($model,'description'); ?>
						<?php echo $form->textArea($model,'description',array('style'=>'width:280px;','rows'=>6))?>
						<?php echo $form->error($model,'description'); ?>
					</li>	
					</div>	
			</ul>
			</div>
			<!--end right content-->			
			<?php $this->endWidget(); ?>
			<div class="clear"></div>          
		</div>
	</div>
	<!--end inside content-->