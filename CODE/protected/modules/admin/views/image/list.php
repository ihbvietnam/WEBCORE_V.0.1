	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị ảnh</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách ảnh</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
             <!--begin box search-->
         <?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#image-search').submit(function(){
				$.fn.yiiGridView.update('image-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'image-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                        <li>
                         	<?php echo $form->labelEx($model,'title'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'title',
							'url'=>array('image/suggestTitle'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>								
                        </li>                       
                    </ul>
                </div>
                <!--end left content-->     
                <!--begin right content-->
                <div class="fl" style="width:480px;">
                    <ul>
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
                <!--end right content-->           
                <?php $this->endWidget(); ?>
                <div class="clear"></div>
                <div class="line top bottom"></div>
            </div>
            <!--end box search-->		
           <?php 
			$this->widget('zii.widgets.grid.CGridView', array(
  				'id'=>'image-list',
  				'dataProvider'=>$model->search(),
  				'columns'=>array( 	
    				array(
						'name'=>'title',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					), 	
					array(
						'name'=>'thumb',
						'value'=>'$data->getAutoThumb()',
						'type'=>'html',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					), 	
					array(
						'name'=>'url',
						'headerHtmlOptions'=>array('width'=>'25%','class'=>'table-title'),		
					), 
					array(
						'name'=>'created_date',
						'value'=>'date("H:i d/m/Y",$data->created_date)',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					), 	
					array(
						'header'=>'Trạng thái',
						'class'=>'iPhoenixButtonColumn',
    					'template'=>'{reverse}',
    					'buttons'=>array
    					(
        					'reverse' => array
    						(
            					'label'=>'Đổi trạng thái album',
            					'imageUrl'=>'$data->imageStatus',
            					'url'=>'Yii::app()->createUrl("admin/image/reverseStatus", array("id"=>$data->id))',
    							'click'=>'function(){
									var th=this;									
									jQuery.ajax({
										type:"POST",
										dataType:"json",
										url:$(this).attr("href"),
										success:function(data) {
											if(data.success){
												$(th).find("img").attr("src",data.src);
												$.fn.yiiGridView.update("image-list");
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
						'deleteConfirmation'=>'Bạn muốn xóa ảnh này?',
						'afterDelete'=>'function(link,success,data){ if(success) jAlert("Bạn đã xóa thành công"); }',
    					'buttons'=>array
    					(
    						'update' => array(
    							'label'=>'Chỉnh sửa',
    						),
        					'delete' => array(
    							'label'=>'Xóa',
    						),
        				),
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
					),    				
 	 			),
  				'summaryText'=>'Có tổng cộng {count} ảnh',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr'))
				)); ?>
		</div>
	</div>
	<!--end inside content-->
	<?php 
$cs = Yii::app()->getClientScript(); 
$cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/common/jquery.alerts.js');
$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/css/common/jquery.alerts.css');
// Script delete
?>
