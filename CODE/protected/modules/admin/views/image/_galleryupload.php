<?php
	echo CHtml::activeHiddenField($model,$attribute,array('id'=>'list_image')); 
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
               	var current_list_image=$('#list_image').val();
               	if (typeof responseJSON.id != 'undefined')  
        		{
               	if(current_list_image != ''){
               		$('#list_image').val(current_list_image+','+responseJSON.id);
               	}
               	else {
               		$('#list_image').val(responseJSON.id);
               	}
               	$('.qq-upload-list').hide();
               	$('#".$attribute."').append('<div class=\"item-image\" id=\"'+responseJSON.id+'\"><img style=\"height:".$h."px; width:".$w."px\" src=\"'+responseJSON.url+'\" /><a target=\"_blank\" class=\"edit\" href=\"/admin/image/update/id/'+responseJSON.id+'\"></a><a class=\"close\"></a></div>'); 
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
    		echo '<div class="item-image" id="'.$image_id.'"><img style="height:'.$h.'px; width:'.$w.'px" src="'.$image->getThumb($category,$type_image).'" /><a target="_blank" class="edit" href="'.Yii::app()->createUrl('admin/image/update',array('id'=>$image_id)).'"></a><a class="close"></a></div>';
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
  				\"Bạn muốn xóa ảnh này này?\",
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
							var list=$('#list_image').val();
  						 	var list_image = list.split(',');
  						 	list_image = jQuery.grep(list_image, function(value) {
								return value != data.id;
							});
							$('#list_image').val(list_image.join(',')
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

