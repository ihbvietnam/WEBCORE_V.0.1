<?php $form=$this->beginWidget('CActiveForm', array('id'=>'category-form','enableAjaxValidation'=>true,'clientOptions'=>array('validationUrl'=>$this->createUrl('category/validateCategory',array('group'=>$group))))); ?>	
<input type="hidden" name="id" id="current_id" value="<?php echo isset($model->id)?$model->id:'0';?>" /> 
<input type="hidden" name="group" id="group" value="<?php echo $group?>" /> 
			<div class="fl" style="width:580px;">
				<ul>
					<?php if($model->id > 0):?>
                    <div class="row">
						<li>
                       		<label>Mã danh mục</label>
                       		<?php echo $model->id;?>
                    	</li>
                    </div>
                    <?php endif;?>
					<div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'name'); ?>
                        	<?php echo $form->textField($model,'name',array('style'=>'width:300px;','maxlength'=>'256')); ?>
                   			<?php echo $form->error($model, 'name'); ?>
                    	</li>
                    </div>               
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'parent_id'); ?>
                        <?php
                        	$view_parent_categories=array();
                        	 foreach ($model->parent_categories as $id=>$cat){
								$view = "";
								for($i=1;$i<$cat['level'];$i++){
									$view .="--";
								}
								$view_parent_categories[$id]=$view." ".$cat['name']." ".$view;
							}
                        	echo $form->dropDownList($model,'parent_id',$view_parent_categories,array('style'=>'width:200px'));
                        ?>
                  		<?php echo $form->error($model, 'parent_id'); ?>
					</li>
                    </div>
                    <div class="row">
                    	<li>
                        	<?php echo $form->labelEx($model,'list_special'); ?>
                        	<?php echo $form->dropDownList($model,'list_special',Category::getList_label_specials(),array('style'=>'width:150px','multiple' => 'multiple')); ?>
                  			<?php echo $form->error($model, 'list_special'); ?>
                    	</li>
                    	</div> 
                   <div class="row">
						<li>
                       		<?php echo $form->labelEx($model,'description'); ?>
                        	<?php echo $form->textArea($model,'description',array('style'=>'width:300px;','rows'=>6)); ?>
                   			<?php echo $form->error($model, 'description'); ?>
                    	</li>
                    </div>
                   	<li>
                    	<?php 
                    	if($action=="update") 
                    	{ 
                    		$label_button="Cập nhật danh mục";     
                    	}
                    	else $label_button="Thêm danh mục";
                    	
						echo '<input type="submit" value="'.$label_button.'" style="margin-left:153px; width:125px;" id="write-category" class="button">';  
    					if($action=="update") 
                    	{   
    						echo '<input type="submit" value="Tạo danh mục mới" style="margin-left:10px; width:125px;" id="create-category" class="button">'; 
                    	}
    					?>  
                    </li>
				</ul>
			</div>
			<?php $this->endWidget(); ?>
