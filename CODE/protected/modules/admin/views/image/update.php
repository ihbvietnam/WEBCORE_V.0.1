		<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>false, 'id'=>'form_image')); ?>	
			<!--begin left content-->
			<div class="fl" style="width:480px;">
				<ul>
					<div class="row" style="text-align:center;">
						<li>
							<img alt="<?php echo $model->title?>" src="<?php echo $thumb_url?>" height=<?php echo $size['h']?> width=<?php echo $size['w']?>>				
						</li>
					</div>
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'title',array('style'=>'width:100px !important')); ?>
							<?php echo $form->textField($model,'title',array('style'=>'width:280px;','maxlength'=>'256')); ?>	
							<?php echo $form->error($model, 'title'); ?>				
						</li>
					</div>					
           			<div class="row">
						<li>
							<?php echo $form->labelEx($model,'url',array('style'=>'width:100px !important')); ?>
							<?php echo $form->textField($model,'url',array('style'=>'width:280px;','maxlength'=>'256')); ?>	
							<?php echo $form->error($model, 'url'); ?>				
						</li>
					</div>		
				</ul>
			</div>		
           <a id="update_image" style="margin-bottom:10px; margin-left:10px;width:125px;" class="button" title="Cập nhật" onclick="update_image(this);return false;">Cập nhật</a>
		   <a style= "margin-bottom:10px; width:125px;" class="button" title="Hủy thao tác" onclick="popup('popUpDiv')">Hủy thao tác</a>
			<!--end left content-->			
			<?php $this->endWidget(); ?>