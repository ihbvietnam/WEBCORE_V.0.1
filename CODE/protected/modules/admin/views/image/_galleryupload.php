<?php
	echo CHtml::activeHiddenField($model,$attribute,array('id'=>'list_image_'.$attribute)); 
    $category=get_class($model);
    $h=Image::$config_thumb_size[$category][$type_image]['h'];
    $w=Image::$config_thumb_size[$category][$type_image]['w'];
	$this->widget('ext.EAjaxUpload.EAjaxUpload',
	array(
        'id'=>'galleryupload_image',
        'config'=>array(
               'action'=>$this->createUrl('image/upload'),
               'allowedExtensions'=>array("jpg","gif","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
               'sizeLimit'=>10*1024*1024,// maximum file size in bytes
               //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
               //'onSubmit'=>"js:function(id, fileName){ $('.qq-upload-list').hide()}",
               'onComplete'=>"js:function(id, fileName, responseJSON){ 
               	var current_list_image=$('#list_image_".$attribute."').val();
               	if (typeof responseJSON.id != 'undefined')  
        		{
               	if(current_list_image != ''){
               		$('#list_image_".$attribute."').val(current_list_image+','+responseJSON.id);
               	}
               	else {
               		$('#list_image_".$attribute."').val(responseJSON.id);
               	}
               	$('.qq-upload-list').hide();
               	$('#".$attribute."').append('<div class=\"item-image\" id=\"'+responseJSON.id+'\"><img style=\"height:".$h."px; width:".$w."px\" src=\"'+responseJSON.url+'\" /><a target=\"_blank\" class=\"edit\" href=\"'+responseJSON.link_update+'\" onclick=\"image_select=$(this);update_form_image();return false;\"></a><a class=\"close\"></a></div>'); 
               	}
               	}",
               'messages'=>array(
                                 'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                 'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                 'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                 'emptyError'=>"{file} is empty, please select files again without it.",
                                 'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                ),
               'showMessage'=>"js:function(message){ jAlert(message); }",
               'template'=> '<div class="qq-uploader">
                			<div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>
                			<div class="qq-upload-button">Chọn ảnh</div>
                			<ul class="qq-upload-list"></ul>
             				</div>',  
               'multiple'=>true,              
              ),
        'postParams'=>array(
              'category'=>$category,
              'parent_id'=>isset($model->id)?$model->id:0,
              'attribute'=>$attribute,
              'type_image'=>$type_image
              )
	)); 
	?>
    <div class="slider-folder" id="<?php echo $attribute;?>">
    <?php 
    foreach (array_diff(explode(',',$model->$attribute),array('')) as $image_id){
    	$image=Image::model()->findByPk($image_id);
    	if(isset($image))
    		echo '<div class="item-image" id="'.$image_id.'"><img style="height:'.$h.'px; width:'.$w.'px" src="'.$image->getThumb($category,$type_image).'" /><a target="_blank" class="edit" href="'.Yii::app()->createUrl('admin/image/update',array('id'=>$image_id)).'" onclick="image_select=$(this);update_form_image();return false;"></a><a class="close"></a></div>';
    }
    ?>
    </div>
    <div type="hidden" value="" id="popup_value"></div>
    <?php 
    $cs = Yii::app()->getClientScript(); 
    $cs->registerScriptFile(Yii::app()->request->getBaseUrl(true).'/js/common/jquery.alerts.js');
	$cs->registerCssFile(Yii::app()->request->getBaseUrl(true).'/css/common/jquery.alerts.css');
    $cs->registerScript('',
    "$('.slider-folder').delegate('.close', 'click', function() {
  			$('#popup_value').val($(this).parent().attr('id'));
  			jConfirm(
  				\"Bạn muốn xóa ảnh này?\",
  				\"Xác nhận xóa ảnh\",
  				function(r){
  					if(r){
  					jQuery.ajax({
  						'data':{id : $(\"#popup_value\").val()},
  						'dataType':'json',
  						'success':function(data){
  							if(data.status == true){
								$('#'+data.id).remove();
							}
							else {
								jAlert('Không thể xóa ảnh');
							}
							var list=$('#list_image_".$attribute."').val();
  						 	var list_image = list.split(',');
  						 	list_image = jQuery.grep(list_image, function(value) {
								return value != data.id;
							});
							$('#list_image_".$attribute."').val(list_image.join(',')
							);
        				},
        				'type':'GET',
        				'url':'".$this->createUrl('image/delete')."',
        				'cache':false});
        			}
        		}
        	);
        	return false;
	});");
	?>
<!-- For Display Popup to Update Image -->
    <div id="popUpDiv" style="z-index:10000;display: none;">
    	<div class="sendMarkOutline" style="border:2px solid #21629B;border-radius:8px;">
	        <div class="sendMark">
	            <a style= "float:right;margin-top:-20px" onclick="popup('popUpDiv')"><img src="<?php echo Yii::app()->request->getBaseUrl(true)?>/images/admin/close.png"></a>
			    <h1 align='center'>Cập nhật thông tin ảnh</h1>
			    <div id='form_update_image'>	
			     	 <a id="update_image" style="margin-bottom:10px; margin-left:10px;width:125px;" class="button" title="Cập nhật" onclick="update_image();return false;">Cập nhật</a>
		  			 <a style= "margin-bottom:10px; width:125px;" class="button" title="Hủy thao tác" onclick="popup('popUpDiv');return false;">Hủy thao tác</a>		    	
			    </div>
			</div>
		</div>
    </div>
<script type="text/javascript">
var image_select;
function update_form_image(){
  jQuery.ajax({
	'success':function(data){
		$("#form_update_image").html(data);
		popup('popUpDiv');
		},
	'type':'GET',
	'url':image_select.attr("href"),
	'cache':false});
  return false;
};
function update_image(){
	jQuery.ajax({
		'data': $("#form_image").serialize(),
		'success':function(data){
			popup('popUpDiv');
			},
		'type':'POST',
		'url':image_select.attr("href"),
		'cache':false});
	  return false;
}
</script>
