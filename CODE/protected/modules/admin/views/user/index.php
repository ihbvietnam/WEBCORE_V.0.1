	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị người dùng</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách người dùng</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
            <div>
            	<input type="button" class="button" value="Thêm người dùng" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/user/create')?>'"/>
                <div class="line top bottom"></div>	
            </div>
             <!--begin box search-->
         <?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#user-search').submit(function(){
				$.fn.yiiGridView.update('user-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'user-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                        <li>
                         	<?php echo $form->labelEx($model,'username'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'username',
							'url'=>array('user/suggestUsername'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>								
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
                        <li>
                          	<?php echo $form->labelEx($model,'email'); ?>
							<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'email',
							'url'=>array('user/suggestEmail'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>	
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
  				'id'=>'user-list',
  				'dataProvider'=>$model->search(),
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-user-list"])'
    				),	
    				array(
						'name'=>'username',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 
					array(
						'name'=>'email',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					), 
					array(
						'name'=>'fullname',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					),		
					array(
						'name'=>'role',
						'value'=>'implode(", ",$data->label_role)',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					),
					array(
						'name'=>'last_visit_date',
						'value'=>'date("H:i - d/m/Y",$data->last_visit_date)',
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
            					'label'=>'Đổi trạng thái người dùng',
            					'imageUrl'=>'$data->imageStatus',
            					'url'=>'Yii::app()->createUrl("admin/user/reverseStatus", array("id"=>$data->id))',
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
    					'template'=>'{password}{update}{delete}',
    					'buttons'=>array
    					(
    						'update' => array(
    							'label'=>'Chỉnh sửa thông tin của user',
								'imageUrl'=>Yii::app()->request->getBaseUrl(true).'/images/admin/edit.png',
    						),
        					'password' => array
    						(
            					'label'=>'Reset password of user',
            					'imageUrl'=>Yii::app()->request->getBaseUrl(true).'/images/admin/reset_pwd.png',
            					'url'=>'Yii::app()->createUrl("admin/user/resetPassword", array("id"=>$data->id))',
        					),
        					'copy' => array
    						(
            					'label'=>'Copy user',
            					'imageUrl'=>Yii::app()->request->getBaseUrl(true).'/images/admin/copy.gif',
            					'url'=>'Yii::app()->createUrl("admin/news/copy", array("id"=>$data->id))',
        					),
        				),
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),
					),    				
 	 			),
 	 			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} user',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
 	 			'actions'=>array(
					'delete'=>array(
						'action'=>'delete',
						'label'=>'Delete all',
						'imageUrl' => '/images/admin/delete.png',
						'url'=>'admin/user/checkbox'
					),
				),
				)); ?>
		</div>
	</div>
	<!--end inside content-->