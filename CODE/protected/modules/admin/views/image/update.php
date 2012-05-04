<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị ảnh</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Chỉnh sửa ảnh</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
            <input type="button" class="button" value="Các ảnh cùng nhóm" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/image/list',array('category'=>$model->category,'parent_id'=>$model->parent_id))?>'"/>
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
							<?php echo $form->labelEx($model,'url'); ?>
							<?php echo $form->textField($model,'url',array('style'=>'width:280px;','maxlength'=>'256')); ?>	
							<?php echo $form->error($model, 'url'); ?>				
						</li>
					</div>				
                    <li>
                    	<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />
						<input type="submit" class="button" value="Cập nhật" style="margin-left:20px; width:125px;" />						
					</li>
				</ul>
			</div>
			<!--end left content-->
			<!--begin right content-->
			<div class="fl menu-tree" style="width:470px;">
			<ul>
				<div class="row">
						<li>
							<img alt="<?php echo $model->title?>" src="<?php echo $thumb_url?>" height=<?php echo $size['h']?> width=<?php echo $size['w']?>>				
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