<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị sản phẩm</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thêm sản phẩm <?php echo $model->name;?></span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
                <input type="button" class="button" value="Danh sách sản phẩm" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/product')?>'"/>
                <div class="line top bottom"></div>	
            </div>
		<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true)); ?>	
			<div class="fl">
				<ul>
				<div id="above_row">
				<div id="left_row">
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'name'); ?>
							<?php echo $form->textField($model,'name',array('style'=>'width:280px;','maxlength'=>'256')); ?>	
							<?php echo $form->error($model, 'name'); ?>		
						</li>		
					</div>	
					<div class="row">
						<li>
							<?php echo $form->labelEx($model,'code'); ?>
							<?php echo $form->textField($model,'code',array('style'=>'width:100px;','maxlength'=>'256')); ?>	
							<?php echo $form->error($model, 'code'); ?>	
						</li>			
					</div>
					<div class="row">
					<li>
                        	<?php echo $form->labelEx($model,'list_special'); ?>
                        	<?php echo $form->dropDownList($model,'list_special',Product::getList_label_specials(),array('style'=>'width:250px','multiple' => 'multiple')); ?>
                  			<?php echo $form->error($model, 'list_special'); ?>
                    </li>
                    </div>
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
							<?php echo $form->labelEx($model,'catid'); ?>
							<?php echo $form->dropDownList($model,'catid',$list,array('style'=>'width:200px')); ?>
							<?php echo $form->error($model, 'catid'); ?>
							</li>
						</div>				
					<?php 
						$list=array();
						foreach ($list_manufacturer as $id=>$manufacturer){
							$view = "";
							for($i=1;$i<$manufacturer['level'];$i++){
								$view .="---";
							}
							$list[$id]=$view." ".$manufacturer['name']." ".$view;
						}
						?>
						<div class="row">
							<li>
							<?php echo $form->labelEx($model,'manufacturer_id'); ?>
							<?php echo $form->dropDownList($model,'manufacturer_id',$list,array('style'=>'width:200px')); ?>
							<?php echo $form->error($model, 'manufacturer_id'); ?>
							</li>
						</div>	
						<div class="row">
							<li>
							<?php echo $form->labelEx($model,'price'); ?>
							<?php echo $form->textField($model,'num_price',array('style'=>'width:100px;','maxlength'=>'256')); ?>
							<?php echo $form->error($model, 'price'); ?>	
							</li>	
						</div>	
							<div class="row">
							<li>
							<?php echo $form->labelEx($model,'unit_price'); ?>
							<?php echo $form->dropDownList($model,'unit_price',Product::$config_unit_price,array('style'=>'width:60px')); ?>	
							<?php echo $form->error($model, 'unit_price'); ?>	
							</li>	
						</div>									
					</div><!--end left above content-->	
					<div id="right_row">
					<div class="row">
							<li>
								<?php echo $form->labelEx($model,'introimage'); ?>
								<?php echo $this->renderPartial('/image/_signupload', array('model'=>$model,'attribute'=>'introimage','type_image'=>'thumb_update')); ?>		
								<?php echo $form->error($model, 'introimage'); ?>
							</li>
					</div>	
					<div class="row">
							<li>
								<?php echo $form->labelEx($model,'otherimage'); ?>
								<?php echo $this->renderPartial('/image/_multiupload', array('model'=>$model,'attribute'=>'otherimage','type_image'=>'thumb_update')); ?>		
								<?php echo $form->error($model, 'otherimage'); ?>
							</li>
					</div>	
					</div><!--end right above content-->							
					</div><!--end above content-->
						 <div class="row">
                    		<li>
                    		<div id="tabContainer">
                        		<div id="tabMenu">
                            		<ul class="menu">
                                		<li><a id="select1" class="active">Mô tả sản phẩm</a></li>
                                    	<li><a id="select2"><span>Thông số kĩ thuật</span></a></li>
                                	</ul>
                            	</div>
                            	<div id="tabContent">
                                	<div id="tab1" class="content active">
                                    <div class="clear"></div>
										<?php  
                        					$this->widget('application.extensions.tinymce.ETinyMce',array('model'=>$model,'attribute'=>'description','editorTemplate'=>'full','htmlOptions'=>array('style'=>'width:800px;height:550px'))); 
                        				?>
                                	</div>
                                	<div id="tab2" class="content">
                                    <div class="clear"></div>
                                    <?php  
                        				$this->widget('application.extensions.tinymce.ETinyMce',array('model'=>$model,'attribute'=>'parameter','editorTemplate'=>'full','htmlOptions'=>array('style'=>'width:800px;height:550px'))); 
                        			?>
                                	</div>
                            	</div>
                        	</div><!--end tabContainer-->
                        	</li>
                    	</div>
						<li>						  						
						<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />	
						<input type="submit" class="button" value="Thêm mới" style="margin-left:20px; width:125px;" />	
						</li>						
				</ul>
			</div>	
			<?php $this->endWidget(); ?>
			<div class="clear"></div>          
		</div>
	</div>
	<!--end inside content-->
<script type="text/javascript">
$('#select1').click(function () {
	$("#select1").attr("class","active");	
	$("#select2").attr("class","");	
	$("#select3").attr("class","");	
    $('#tab1').attr("class","content active");	
    $('#tab2').attr("class","content");	
    $('#tab3').attr("class","content");	
});
$('#select2').click(function () {
	$("#select2").attr("class","active");	
	$("#select1").attr("class","");	
	$("#select3").attr("class","");	
    $('#tab2').attr("class","content active");	
    $('#tab1').attr("class","content");	
    $('#tab3').attr("class","content");	
});
</script>
<?php  
$cs = Yii::app()->getClientScript(); 
$cs->registerScriptFile('js/admin/popup.js');
?>