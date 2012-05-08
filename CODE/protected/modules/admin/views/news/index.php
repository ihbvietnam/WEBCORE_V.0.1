	<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>quản trị tin tức</h1>
			<div class="header-menu">
				<ul>
					<li class="ex-show"><a class="activities-icon" href=""><span>Danh sách tin tức</span></a></li>
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content">
            <div>
            	<input type="button" class="button" value="Thêm tin" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/news/create')?>'"/>
                <div class="line top bottom"></div>	
            </div>
             <!--begin box search-->
         <?php 
			Yii::app()->clientScript->registerScript('search', "
				$('#news-search').submit(function(){
				$.fn.yiiGridView.update('news-list', {
					data: $(this).serialize()});
					return false;
				});");
		?>
            <div class="box-search">            
                <h2>Tìm kiếm</h2>
                <?php $form=$this->beginWidget('CActiveForm', array('method'=>'get','id'=>'news-search')); ?>
                <!--begin left content-->
                <div class="fl" style="width:480px;">
                    <ul>
                        <li>
                         	<?php echo $form->labelEx($model,'title'); ?>
                         	<?php $this->widget('CAutoComplete', array(
                         	'model'=>$model,
                         	'attribute'=>'title',
							'url'=>array('news/suggestTitle'),
							'htmlOptions'=>array(
								'style'=>'width:230px;',
								),
						)); ?>								
                        </li>
                         <li>
							<?php echo $form->labelEx($model,'lang'); ?>
							<?php echo $form->dropDownList($model,'lang',array(''=>'Tất cả',Article::LANG_EN=>'English',Article::LANG_VI=>'Tiếng Việt'),array('style'=>'width:200px')); ?>
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
					$list=array(''=>'Tất cả các thư mục');
					foreach ($list_category as $id=>$cat){
						$view = "";
						for($i=1;$i<$cat['level'];$i++){
							$view .="---";
						}
						$list[$id]=$view." ".$cat['name']." ".$view;
					}
					?>
					<li>
						<label>Thuộc danh mục:</label>
						<?php echo $form->dropDownList($model,'catid',$list,array('style'=>'width:200px')); ?>
					</li>
					  <?php 
					$list=array(''=>'Không lọc');
					$list +=News::getList_label_specials();
					?>
					<li>
						<?php echo $form->labelEx($model,'special'); ?>
						<?php echo $form->dropDownList($model,'special',$list,array('style'=>'width:200px')); ?>
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
  				'id'=>'news-list',
  				'dataProvider'=>$model->search(),		
  				'columns'=>array(
					array(
      					'class'=>'CCheckBoxColumn',
						'selectableRows'=>2,
						'headerHtmlOptions'=>array('width'=>'2%','class'=>'table-title'),
						'checked'=>'in_array($data->id,Yii::app()->session["checked-news-list"])'
    				),			
    				array(
						'name'=>'title',
						'headerHtmlOptions'=>array('width'=>'20%','class'=>'table-title'),		
					),
					array(
						'name'=>'category',
						'value'=>'$data->label_category',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 
					/*		
					array(
						'name'=>'list_special',
						'value'=>'implode(", ",$data->label_specials)',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					),
					*/
					array(
						'name'=>'order_view',
						'value'=>'$data->order_view',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					),
					array(
						'name'=>'author',
						'value'=>'$data->author->username',
						'headerHtmlOptions'=>array('width'=>'5%','class'=>'table-title'),		
					), 						
					array(
						'name'=>'created_date',
						'value'=>'date("H:i d/m/Y",$data->created_date)',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),		
					), 		
					array(
						'header'=>'Trạng thái',
						'class'=>'iPhoenixButtonColumn',
    					'template'=>'{reverse}',
    					'buttons'=>array
    					(
        					'reverse' => array
    						(
            					'label'=>'Đổi trạng thái bài viết',
            					'imageUrl'=>'$data->imageStatus',
            					'url'=>'Yii::app()->createUrl("admin/news/reverseStatus", array("id"=>$data->id))',
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
    					'template'=>'{copy}{update}{delete}',
						'deleteConfirmation'=>'Bạn muốn xóa bài viết này?',
						'afterDelete'=>'function(link,success,data){ if(success) jAlert("Bạn đã xóa thành công"); }',
    					'buttons'=>array
    					(
    						'update' => array(
    							'label'=>'Chỉnh sửa bài viết',
    						),
        					'delete' => array(
    							'label'=>'Xóa bài viết',
    						),
    						'copy' => array
    						(
            					'label'=>'Copy bài viết',
            					'imageUrl'=>Yii::app()->request->getBaseUrl(true).'/images/admin/copy.gif',
            					'url'=>'Yii::app()->createUrl("admin/news/copy", array("id"=>$data->id))',
        					),
        				),
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
					),    				
 	 			),
 	 			'template'=>'{displaybox}{checkbox}{summary}{items}{pager}',
  				'summaryText'=>'Có tổng cộng {count} tin',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr')),
				'actions'=>array(
					'delete'=>array(
						'action'=>'delete',
						'label'=>'Delete all',
						'imageUrl' => '/images/admin/delete.png',
						'url'=>'admin/news/checkbox'
					),
					'copy'=>array(
						'action'=>'copy',
						'label'=>'Copy all',
						'imageUrl' => '/images/admin/copy.gif',
						'url'=>'admin/news/checkbox'
					)
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