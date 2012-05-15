	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị sản phẩm</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách các sản phẩm</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
            <div>
            	<input type="button" class="button" value="Thêm sản phẩm mới" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/product/create')?>'"/>
                <div class="line top bottom"></div>	
            </div>
             <!--begin box search-->
         <?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#product-search').submit(function(){
				$.fn.yiiGridView.update('product-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'product-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                        <li>
                         	<?php echo $form->labelEx($model,'name'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
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
						<?php echo $form->labelEx($model,'catid'); ?>
                        <?php echo $form->dropDownList($model,'catid', $list );?>
                    </li> 										
						<li>
                        <?php 
							echo CHtml::submitButton('Lọc kết quả',
    						array(
    							'class'=>'button',
    							'style'=>'margin-left:153px; width:95px;',
    							''
    						)); 						
    					?>
                        </li>                                             
                    </ul>
                </div>
                <!--end left content-->     
                <!--begin right content-->
                <div class="fl" style="width:480px;">
                   <ul>
                     <?php 
							$list=array(''=>'Không lọc');
							$list +=Product::getList_label_specials();
						?>	
						<li>
							<?php echo $form->labelEx($model,'special'); ?>
							<?php echo $form->dropDownList($model,'special',$list,array('style'=>'width:200px')); ?>
						</li>	
						 <?php 
							$list=array(''=>'Tất cả');
							$list +=array(Order::STATUS_PENDING=>'Hết hàng',Order::STATUS_ACTIVE=>'Còn hàng trong kho');
						?>	
						<li>
							<?php echo $form->labelEx($model,'amount_status'); ?>
							<?php echo $form->dropDownList($model,'amount_status',$list,array('style'=>'width:200px')); ?>
						</li>	              	                   	
                   </ul>
                </div>
                <!--end right content-->           
                <?php $this->endWidget(); ?>
                <div class="clear"></div>
                <div class="line top bottom"></div>
            </div>
            <!--end box search-->		
           <?php 
			$this->widget('iPhoenixGridView', array(
  				'id'=>'product-list',
  				'dataProvider'=>$model->search(),
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-product-list"])'
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
						'header'=>'Trạng thái',
						'class'=>'iPhoenixButtonColumn',
    					'template'=>'{reverse}',
    					'buttons'=>array
    					(
        					'reverse' => array
    						(
            					'label'=>'Đổi trạng thái sản phẩm',
            					'imageUrl'=>'$data->imageStatus',
            					'url'=>'Yii::app()->createUrl("admin/product/reverseStatus", array("id"=>$data->id))',
    							'click'=>'function(){
									var th=this;									
									jQuery.ajax({
										type:"POST",
										dataType:"json",
										url:$(this).attr("href"),
										success:function(data) {
											if(data.success){
												$(th).find("img").attr("src",data.src);
												}
										},
										});
								return false;}',
        					),        					
        				),
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
					),  
					array(
						'header'=>'Trạng thái hàng trong kho',
						'class'=>'iPhoenixButtonColumn',
    					'template'=>'{reverse_amount}',
    					'buttons'=>array
    					(
        					'reverse_amount' => array
    						(
            					'label'=>'Đổi trạng thái số lượng sản phẩm',
            					'imageUrl'=>'$data->imageAmountStatus',
            					'url'=>'Yii::app()->createUrl("admin/product/reverseAmountStatus", array("id"=>$data->id))',
    							'click'=>'function(){
									var th=this;									
									jQuery.ajax({
										type:"POST",
										dataType:"json",
										url:$(this).attr("href"),
										success:function(data) {
											if(data.success){
												$(th).find("img").attr("src",data.src);
												}
										},
										});
								return false;}',
        					),
        				),
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
					),     											   	   
					array(
						'header'=>'Công cụ',
						'class'=>'CButtonColumn',
    					'template'=>'{update}{delete}',
						'deleteConfirmation'=>'Bạn muốn xóa sản phẩm này?',
						'afterDelete'=>'function(link,success,data){ if(success) jAlert("Bạn đã xóa thành công"); }',
    					'buttons'=>array
    					(
    						'update' => array(
    							'label'=>'Chỉnh sửa bài viết',
    						),
        					'delete' => array(
    							'label'=>'Xóa bài viết',
    						),
        				),
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
					),    				
 	 			),
 	 			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} sản phẩm',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
				'actions'=>array(
					'delete'=>array(
						'action'=>'delete',
						'label'=>'Delete all',
						'imageUrl' => '/images/admin/delete.png',
						'url'=>'admin/product/checkbox'
					),
				),
 	 			)); ?>
		</div>
	</div>
	<!--end inside content-->
	<?php 
$cs = Yii::app()->getClientScript(); 
$cs->registerScriptFile('js/common/jquery.alerts.js');
$cs->registerCssFile('css/common/jquery.alerts.css');
// Script delete
?>