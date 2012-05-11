<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị Banner ảnh</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thêm Banner</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
                <input type="button" class="button" value="Danh sách banner" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/banner')?>'"/>
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
						<?php echo $form->labelEx($model,'description'); ?>
						<?php echo $form->textArea($model,'description',array('style'=>'width:280px;','rows'=>6))?>
						<?php echo $form->error($model,'description'); ?>
					</li>	
					</div>				
                    <li>
						<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />	
						<input type="submit" class="button" value="Tạo" style="margin-left:20px; width:125px;" />					
					</li>
				</ul>
			</div>
			<!--end left content-->
			<!--begin right content-->
			<div class="fl menu-tree" style="width:470px;">
			<ul>
				<div class="row">
						<li>
							<?php echo $this->renderPartial('/image/_galleryupload', array('model'=>$model,'attribute'=>'images','type_image'=>'thumb_headline')); ?>
							<?php echo $form->error($model, 'images'); ?>				
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