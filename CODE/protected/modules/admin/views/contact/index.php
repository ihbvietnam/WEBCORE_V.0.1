	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị liên hệ</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
             <!--begin box search-->
         <?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#contact-search').submit(function(){
				$.fn.yiiGridView.update('contact-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'contact-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                         <?php 
					$list=array(''=>'Tất cả',Contact::STATUS_PENDING=>'Chưa giải quyết',Contact::STATUS_ACTIVE=>'Đã giải quyết');
					?>
					<li>
						<label>Thuộc nhóm:</label>
						<?php echo $form->dropDownList($model,'status',$list,array('style'=>'width:200px')); ?>
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
			$this->widget('iPhoenixGridView', array(
  				'id'=>'contact-list',
  				'dataProvider'=>$model->search(),
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-contact-list"])'
    				),	
    				array(
						'name'=>'fullname',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 
					array(
						'name'=>'email',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					),
					array(
						'name'=>'content',
						'value'=>'iPhoenixString::createIntrotext($data->content,Contact::SIZE_INTRO_CONTENT)',
						'headerHtmlOptions'=>array('width'=>'40%','class'=>'table-title'),		
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
            					'label'=>'Đổi trạng thái câu hỏi',
            					'imageUrl'=>'$data->imageStatus',
            					'url'=>'Yii::app()->createUrl("admin/contact/reverseStatus", array("id"=>$data->id))',
    							'click'=>'function(){
									var th=this;									
									jQuery.ajax({
										type:"POST",
										dataType:"json",
										url:$(this).attr("href"),
										success:function(data) {
											if(data.success==true){
												$(th).find("img").attr("src",data.src);
												}
											else {
												jAlert("Câu hỏi chưa được trả lời");
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
    					'template'=>'{view}{delete}',
						'deleteConfirmation'=>'Bạn muốn xóa câu hỏi này?',
						'afterDelete'=>'function(link,success,data){ if(success) jAlert("Bạn đã xóa thành công"); }',
    					'buttons'=>array
    					(
    						'view' => array(
    							'label'=>'Xem chi tiết',
    						),
        					'delete' => array(
    							'label'=>'Xóa bài viết',
    						),
        				),
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
					),    				
 	 			),
 	 			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} câu hỏi',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
 	 			'actions'=>array(
					'delete'=>array(
						'action'=>'delete',
						'label'=>'Delete all',
						'imageUrl' => '/images/admin/delete.png',
						'url'=>'admin/contact/checkbox'
					),
				),
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