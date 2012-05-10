<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị sản phẩm</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Cập nhật sản phẩm <?php echo $model->name;?></span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
		<div>
            	<input type="button" class="button" value="Thêm sản phẩm" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/product/create')?>'"/>
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
								<?php echo $form->dropDownList($model,'catid',$list,array('style'=>'width:250px')); ?>
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
							<?php echo $form->dropDownList($model,'unit_price',Product::$config_unit_price,array('style'=>'width:58px;margin-top:-5px;height:22px;')); ?>	
							<?php echo $form->error($model, 'unit_price'); ?>	
							</li>	
						</div>									
						</div><!--end left above content-->	
						<div id="right_row">
							<div class="row" style="min-height:100px;">
								<li>
									<?php echo $form->labelEx($model,'introimage'); ?>
									<?php echo $this->renderPartial('/image/_signupload', array('model'=>$model,'attribute'=>'introimage','type_image'=>'thumb_update')); ?>		
									<?php echo $form->error($model, 'introimage'); ?>
								</li>
							</div>	
							<div class="row" style="min-height:100px;">
								<li>
									<?php echo $form->labelEx($model,'otherimage'); ?>
									<?php echo $this->renderPartial('/image/_multiupload', array('model'=>$model,'attribute'=>'otherimage','type_image'=>'thumb_update')); ?>		
									<?php echo $form->error($model, 'otherimage'); ?>
								</li>
							</div>	
							<div class="row">
								<li>
									<?php echo $form->labelEx($model,'list_suggest'); ?>
									<?php echo $form->textField($model,'list_suggest',array('readonly'=>'readonly','style'=>'width:160px')); ?>				
									<a title="Chọn sản phẩm" href="#" onclick="showPopUp();" id="btn-add-product" class="button" style="width: 100px;padding:1px;margin-top:-5px;text-decoration:none;">Chọn sản phẩm</a>								
								</li>
							</div>
						</div><!--end right above content-->
					</div><!--end above content-->
					<div class="row">
                    	<li>
	                    	<div id="tabContainer">
	                        	<div id="tabMenu">
	                            	<ul class="menu">
	                                	<li><a id="select1" class="active"><span>Mô tả sản phẩm</span></a></li>
	                                    <li><a id="select2"><span>Thông số kĩ thuật</span></a></li>
	                                </ul>
	                            </div>
	                            <div id="tabContent">
	                                <div id="tab1" class="content active">
	                                    <div class="clear"></div>
										<?php  
                        					$this->widget('application.extensions.tinymce.ETinyMce',array('model'=>$model,'attribute'=>'description','editorTemplate'=>'full','htmlOptions'=>array('style'=>'width:950px;height:500px'))); 
                        				?>
                                	</div>
                                	<div id="tab2" class="content">
	                                    <div class="clear"></div>
	                                    <?php  
	                        				$this->widget('application.extensions.tinymce.ETinyMce',array('model'=>$model,'attribute'=>'parameter','editorTemplate'=>'full','htmlOptions'=>array('style'=>'width:950px;height:500px'))); 
	                        			?>
                                	</div>
                            	</div>
                        	</div><!--end tabContainer-->
                        </li>
                    </div>
					<li>						  						
						<input type="reset" class="button" value="Hủy thao tác" style="margin-left:153px; width:125px;" />	
						<input type="submit" class="button" value="Cập nhật" style="margin-left:20px; width:125px;" />	
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
<!-- Main popup -->
<div class="bg-overlay"></div>
<div class="main-popup"><a class="popup-close" onclick="hidenPopUp();return false;"></a>
<div class="content-popup">
<div class="folder-content">
<ul>
		<?php 
			Yii::app()->clientScript->registerScript('search-product-suggest', "
				$('#product-search').submit(function(){
				$.fn.yiiGridView.update('product-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
	 <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'product-search')); ?>
	 <li>
                   <?php echo $form->labelEx($suggest,'name'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$suggest,
                         	'attribute'=>'name',
							'url'=>array('product/suggestName'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>
						</li>
						 <?php 
					$list=array(''=>'Tất cả các nhóm');
					foreach ($list_category as $id=>$cat){
						$view = "";
						for($i=1;$i<$cat['level'];$i++){
							$view .="---";
						}
						$list[$id]=$view." ".$cat['name']." ".$view;
					}
					?>            
                   	<li>
						<?php echo $form->labelEx($suggest,'catid'); ?>
                        <?php echo $form->dropDownList($suggest,'catid', $list );?>
                    </li>
                       <?php 
					$list=array(''=>'Tất cả các nhà sản xuất');
					foreach ($list_manufacturer as $id=>$cat){
						$view = "";
						for($i=1;$i<$cat['level'];$i++){
							$view .="---";
						}
						$list[$id]=$view." ".$cat['name']." ".$view;
					}
					?>  
                    <li>
						<?php echo $form->labelEx($suggest,'manufacturer_id'); ?>
                        <?php echo $form->dropDownList($suggest,'manufacturer_id', $list);?>														
                    </li>  		  
	<li>
	<label>&nbsp;</label> 
	<input type="submit" class="button" value="Lọc bài viết">
	</li>
	<?php $this->endWidget(); ?>	
	<li>
	  <?php 
			$this->widget('iPhoenixGridView', array(
  				'id'=>'product-list',
  				'dataProvider'=>$suggest->search(),		
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-suggest-list"])'
    				),			
    				array(
						'name'=>'name',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					), 	
					array(
						'name'=>'catid',
						'value'=>'$data->category->name',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					), 	
					array(
						'name'=>'manufacturer_id',
						'value'=>'$data->manufacturer->name',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					), 	
					array(
						'name'=>'created_date',
						'value'=>'date("H:i d/m/Y",$data->created_date)',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 	
				),			
 	 			'template'=>'{displaybox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} tin',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
 	 			)); ?>
	</li>
	<li>
	<input  class="fr button" id="update_suggest" type="submit" value="Cập nhật" style="width:100px; margin-top:10px; margin-right:5px;" />
	<input type="reset" class="fr button p-close" value="Hủy" style="width:100px; margin-top:10px; margin-right:5px;" onclick="hidenPopUp();return false;"/>
</li>
</ul>
</div>
</div>
<!--content-popup--></div>
<!--main-popup-->
<script type="text/javascript">
$("#update_suggest").click(
  		function(){  	
  			name=$("thead :checkbox").attr("name");
			name=name.substring(0, name.length - 4) + "[]";	
  			list_checked=new Array();
			$('input[name="'+name+'"]:checked').each(function(i){
				list_checked[i] = $(this).val();
			});	
			list_unchecked = new Array();
            $('input[name="'+name+'"]').not(':checked').each(function(i){
            	list_unchecked[i]=$(this).val();
			});	
			jQuery.ajax({
				data: {'list-checked':list_checked.toString(), 'list-unchecked':list_unchecked.toString(),},
				success:function(data){
					$('#Product_list_suggest').val(data);
					hidenPopUp();
				},
				type:'POST',
				url:'<?php echo $this->createUrl('product/updateSuggest');?>',
				'cache':'false'});
			return false;
		});
</script>