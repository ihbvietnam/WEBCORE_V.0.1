<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị album ảnh</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Chỉnh sửa album <?php echo $model->title;?></span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
            	<input type="button" class="button" value="Thêm album mới" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/album/create')?>'"/>
                <input type="button" class="button" value="Danh sách album" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/album')?>'"/>
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
							<?php echo $form->dropDownList($model,'lang',array(Article::LANG_EN=>'English',Article::LANG_VI=>'Tiếng Việt'),array('style'=>'width:200px')); ?>
							<?php echo $form->error($model, 'lang'); ?>
                    	</li>
                    </div>	
					<div class="row">
                    	<li>
                        	<?php echo $form->labelEx($model,'list_special'); ?>
                        	<?php echo $form->dropDownList($model,'list_special',Album::getList_label_specials(),array('style'=>'width:150px','multiple' => 'multiple')); ?>
                  			<?php echo $form->error($model, 'list_special'); ?>
                    	</li>
                    </div>					
           			<div class="row">
					<li>
						<?php echo $form->labelEx($model,'description'); ?>
						<?php echo $form->textArea($model,'description',array('style'=>'width:280px;max-width:280px;','rows'=>6))?>
						<?php echo $form->error($model,'description'); ?>
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
							<?php echo $this->renderPartial('/image/_galleryupload', array('model'=>$model,'attribute'=>'images','type_image'=>'thumb_update')); ?>
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