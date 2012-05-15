<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị hỏi đáp</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Trả lời câu hỏi <?php echo $model->title;?></span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
                <input type="button" class="button" value="Danh sách câu hỏi" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/qA')?>'"/>
                <div class="line top bottom"></div>	
            </div>
		<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<!--begin left content-->
			<div class="fl">
				<ul>	
					<div class="row">
					<li>
						<?php echo $form->labelEx($model,'fullname'); ?>
						<?php echo $form->textField($model,'fullname',array('style'=>'width:280px;','maxlength'=>'128'))?>
						<?php echo $form->error($model,'fullname'); ?>
					</li>	
					</div>
					<div class="row">
					<li>
						<?php echo $form->labelEx($model,'phone'); ?>
						<?php echo $form->textField($model,'phone',array('style'=>'width:280px;','maxlength'=>'13'))?>
						<?php echo $form->error($model,'phone'); ?>
					</li>	
					</div>
					<div class="row">
					<li>
						<?php echo $form->labelEx($model,'email'); ?>
						<?php echo $form->textField($model,'email',array('style'=>'width:280px;'))?>
						<?php echo $form->error($model,'email'); ?>
					</li>	
					</div>
           			<div class="row">
					<li>
						<?php echo $form->labelEx($model,'question'); ?>
						<?php echo $form->textArea($model,'question',array('style'=>'width:280px;','rows'=>6))?>
						<?php echo $form->error($model,'question'); ?>
					</li>	
					</div>	
					<div class="right_row">
						<li>
							<?php echo $form->labelEx($model,'lang'); ?>
							<?php echo $form->dropDownList($model,'lang',LanguageForm::getList_languages_exist(),array('style'=>'width:200px')); ?>
							<?php echo $form->error($model, 'lang'); ?>
						</li>
						</div>
					<div class="row">
					<li>
						<?php echo $form->labelEx($model,'answer'); ?>
						<?php                         
                        $this->widget('application.extensions.tinymce.ETinyMce',array('model'=>$model,'attribute'=>'answer','editorTemplate'=>'full','htmlOptions'=>array('style'=>'width:700px;height:500px'))); 
                        ?>
						<?php echo $form->error($model,'answer'); ?>
					</li>	
					</div>			
                    <li>
						<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />	
						<input type="submit" class="button" value="Thêm mới" style="margin-left:20px; width:125px;" />						
					</li>
				</ul>
			</div>
			<!--end left content-->
			<?php $this->endWidget(); ?>
			<div class="clear"></div>          
		</div>
	</div>
	<!--end inside content-->