<li>
<label>Gợi ý sản phẩm đi kèm:</label>
<input type="button" id="btn-add-product" class="button" value="Chọn sản phẩm" style="width:125px;" />
</li>
<?php 
if($id>0)
   $model_suggest=News::model()->findByPk($id);
else 
	$model_suggest=new News;
?>
<div class="bg-overlay"></div>
<div class="main-popup">
	<a href="#" class="popup-close"></a>
    <div class="content-popup">
    	<div class="folder-content">
            <ul>
                <li>
                    <label>Bài viết:</label>
                    <?php echo CHtml::textField('suggest_title','',array('style'=>'width:300px;'))?>					
                </li>
                <li>
                    <label>Thuộc danh mục:</label>
                    <?php echo CHtml::dropDownList('suggest_category', array($model_suggest->catid), $list)?>
                </li>
                 <li>
                    <label>&nbsp;</label>
                    <input type="button" id="btn-add-product" class="button" value="Lọc sản phẩm" style="width:125px;" />
                </li>
                <li>
                	<div class="table popup-table">
                       <?php 
			$this->widget('zii.widgets.grid.CGridView', array(
  				'id'=>'list-news-suggest',
  				'dataProvider'=>$model_suggest->search(),
  				'columns'=>array(
					array(
						'name'=>'introimage',
						'value'=>'$data->getImage("thumb_list_admin")',
						'type'=>'html',
						'headerHtmlOptions'=>array('width'=>'10%','class'=>'table-title'),
					),
    				array(
						'name'=>'title',
						'headerHtmlOptions'=>array('width'=>'25%','class'=>'table-title'),		
					),
					array(
						'name'=>'category',
						'value'=>'$data->label_category',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					), 		
					array(
						'name'=>'author',
						'value'=>'$data->author->username',
						'headerHtmlOptions'=>array('width'=>'15%','class'=>'table-title'),		
					),						  											   	   		
 	 			),
  				'summaryText'=>'Có tổng cộng {count} kết quả',
 	 			'pager'=>array('class'=>'CLinkPager','header'=>'','prevPageLabel'=>'< Trước','nextPageLabel'=>'Sau >','htmlOptions'=>array('class'=>'pages fr'))
				)); ?>
                    </div>
                    <!--end table data-->
                </li>
                <li>
                	<input type="button" class="fl button" value="Xóa đã chọn" style="width:100px; margin-top:10px;" />
                    <input type="button" class="fr button p-close" value="Hủy" style="width:70px; margin-top:10px;" />
                    <input type="submit" class="fr button p-close" value="Thêm sản phẩm" style="width:100px; margin-top:10px; margin-right:5px;" />
                </li>
            </ul>
        </div>
    </div><!--content-popup-->
</div><!--main-popup-->