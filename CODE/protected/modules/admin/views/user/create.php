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
							<?php echo $form->labelEx($model,'username'); ?>
							<?php echo $form->textField($model,'username',array('style'=>'width:280px;','maxlength'=>'32')); ?>	
							<?php echo $form->error($model, 'username'); ?>				
						</li>
					</div>
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
							<?php echo $form->labelEx($model,'email'); ?>
							<?php echo $form->textField($model,'email',array('style'=>'width:280px','maxlength'=>'32')); ?>					
							<?php echo $form->error($model, 'email'); ?>
						</li>
					</div>
					<div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'role'); ?>
                        <?php echo $form->dropDownList($model,'role',$model->list_label_roles,array('style'=>'width:150px','multiple' => 'multiple')); ?>
                  		<?php echo $form->error($model, 'role'); ?>
                    </li>
                    </div>
                   		<li>
                   		<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />
                    	<input type="submit" class="button" value="Tạo" style="margin-left:20px; width:125px;" />					 
                    	</li>
				</ul>
			</div>
			<!--end left content-->
			<div class="fl" style="width:480px;">
				<ul>
					 <div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'status'); ?>
                        	<?php echo $form->dropDownList($model,'status',$model->list_label_status,array('style'=>'width:100px')); ?>
                   			<?php echo $form->error($model, 'status'); ?>
                    	</li>
                    </div> 
                    <div class="row">
						<li>
							<?php echo $form->labelEx($model,'phone'); ?>
							<?php echo $form->textField($model,'phone',array('style'=>'width:280px;','maxlength'=>'16')); ?>
							<?php echo $form->error($model, 'phone'); ?>
						</li>
					</div>
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'address'); ?>
							<?php echo $form->textField($model,'address',array('style'=>'width:280px;','maxlength'=>'128')); ?>
							<?php echo $form->error($model, 'address'); ?>
						</li>     
					</div>
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'firstname'); ?>
							<?php echo $form->textField($model,'firstname',array('style'=>'width:280px;','maxlength'=>'32')); ?>
							<?php echo $form->error($model, 'firstname'); ?>
						</li>
					</div>
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'lastname'); ?>
							<?php echo $form->textField($model,'lastname',array('style'=>'width:280px;','maxlength'=>'32')); ?>
							<?php echo $form->error($model, 'lastname'); ?>
						</li>       
					</div>                
				</ul>
			</div>
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->