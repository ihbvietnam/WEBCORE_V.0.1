<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị tin tức</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Chỉnh sửa tin <?php echo $model->title;?></span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
            	<input type="button" class="button" value="Thêm tin" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/news/create')?>'"/>
                <input type="button" class="button" value="Danh sách bài viết" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/news')?>'"/>
                <div class="line top bottom"></div>	
            </div>
		<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<!--begin left content-->
			<div class="fl">
				<ul>
					<div id="above_row">
					<div id="left_row">
						<div class="row">
							<li>
								<?php echo $form->labelEx($model,'title'); ?>
								<?php echo $form->textField($model,'title',array('style'=>'width:280px;','maxlength'=>'256')); ?>	
								<?php echo $form->error($model, 'title'); ?>				
							</li>
						</div>					
					   <div class="row">
							<li>
								<?php echo $form->labelEx($model,'introimage'); ?>
								<?php echo $this->renderPartial('/image/_signupload', array('model'=>$model,'attribute'=>'introimage','type_image'=>'thumb_update')); ?>		
								<?php echo $form->error($model, 'introimage'); ?>
							</li>
						</div>
					</div>
					<div class="right_row">
						<li>
							<?php echo $form->labelEx($model,'order_view'); ?>
							<?php
							echo $form->dropDownList(
									$model,
									'order_view',
									$model->list_order_view,
									array(		
										'style'=>'width:200px'
									)
								); ?>
							<?php echo $form->error($model, 'order_view'); ?>
						</li>
					</div>
					<div class="right_row">
						<li>
							<?php echo $form->labelEx($model,'lang'); ?>
							<?php echo $form->dropDownList(
									$model,
									'lang',
									array(Article::LANG_EN=>'English',Article::LANG_VI=>'Tiếng Việt'),
									array(
										'ajax' => array(
											'type'=>'POST', 
											'url'=>CController::createUrl('news/dynamicCat'), 
											'data'=>'js:{lang:$(this).val()}',
											'update'=>'#News_catid', 
										),
										'style'=>'width:200px'
									)
								); ?>
							<?php echo $form->error($model, 'lang'); ?>
						</li>
					</div>
					<div id="right_row">	
						<?php 
						$list=array();
						foreach ($list_category as $id=>$cat){
							$view = "";
							for($i=1;$i<$cat['level'];$i++){
								$view .="---";
							}
							$list[$id]=$view." ".$cat['name']." ".$view;
						}
						?>
						<div class="row">
						<li>
							<?php echo $form->labelEx($model,'category'); ?>
							<?php echo $form->dropDownList($model,'catid',$list,array('style'=>'width:200px')); ?>
							<?php echo $form->error($model, 'catid'); ?>
						</li>
						</div>
						<div class="row">
                    	<li>
                        	<?php echo $form->labelEx($model,'list_special'); ?>
                        	<?php echo $form->dropDownList($model,'list_special',News::getList_label_specials(),array('style'=>'width:250px','multiple' => 'multiple')); ?>
                  			<?php echo $form->error($model, 'list_special'); ?>
                    	</li>
                    	</div>
					</div>
					</div>		
                    <div class="row">
                    <li>
                        <?php echo $form->labelEx($model,'fulltext'); ?>
                        <?php  
                        $this->widget('application.extensions.tinymce.ETinyMce',array('model'=>$model,'attribute'=>'fulltext','editorTemplate'=>'full','htmlOptions'=>array('style'=>'width:800px;height:550px'))); 
                        ?>
                        <?php echo $form->error($model,'fulltext'); ?>
                    </li>
                    </div>
                    <li>
                    	<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />	
						<input type="submit" class="button" value="Cập nhật" style="margin-left:20px; width:125px;" />						
					</li>
				</ul>
			</div>
			<!--end left content-->
			<?php $this->endWidget(); ?>
			<div class="clear"></div>          
		</div>
	</div>
	<!--end inside content-->
<?php  
$cs = Yii::app()->getClientScript(); 
$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/admin/popup.js');
?>