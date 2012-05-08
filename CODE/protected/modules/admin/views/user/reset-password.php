	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị người dùng</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thêm người dùng</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->	
		<div class="folder-content form">
			<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<!--begin left content-->
			<div class="fl" style="width:480px;">
				<ul>
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'clear_password'); ?>
							<?php echo $form->passwordField($model,'clear_password',array('style'=>'width:280px;','maxlength'=>'32')); ?>
							<?php echo $form->error($model, 'clear_password'); ?>
						</li>
					</div>
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'retype_password'); ?>
							<?php echo $form->passwordField($model,'retype_password',array('style'=>'width:280px;','maxlength'=>'32')); ?>
							<?php echo $form->error($model, 'retype_password'); ?>
						</li>
					</div>					
                    <div class="row">
                   		<li>
                    		<?php 
							echo CHtml::submitButton('Cập nhật',
    						array(
    							'class'=>'button',
    							'style'=>'margin-left:153px; width:95px;',
    							''
    						)); 						
    						?>    
                    	</li>
                    </div>
				</ul>
			</div>
			<!--end left content-->			
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->
