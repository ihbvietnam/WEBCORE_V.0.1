	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị các tham số cấu hình</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Chỉnh sửa các tham số cấu hình</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->	
		<div class="folder-content form">
			<div>
                <input type="button" class="button" value="Thêm tham số cấu hình" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/setting/create')?>'"/>
                <input type="button" class="button" value="Danh sách tham số cấu hình" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/setting')?>'"/>
                <div class="line top bottom"></div>	
            </div>
			<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<!--begin left content-->
			<div class="fl" style="width:480px;">
				<ul>             
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'category'); ?>
                        <?php echo $form->dropDownList($model,'category',$model->list,array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'category'); ?>
                    </li>
                    </div>
				    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'name'); ?>
                        <?php echo $form->textField($model,'name',array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'name'); ?>
                    </li>
                    </div>
                       <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'value'); ?>
                        <?php echo $form->textField($model,'value',array('style'=>'width:150px')); ?>
                  		<?php echo $form->error($model, 'value'); ?>
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
                       		<?php echo $form->labelEx($model,'description',array('style'=>'width:200px;')); ?>
                        	<?php echo $form->textArea($model,'description',array('style'=>'width:300px;max-width:300px;','rows'=>6)); ?>
                   			<?php echo $form->error($model, 'description'); ?>
                    	</li>
                    </div>
			</ul>
			</div>		
			<?php $this->endWidget(); ?>
			<div class="clear"></div>
		</div>
	</div>
	<!--end inside content-->