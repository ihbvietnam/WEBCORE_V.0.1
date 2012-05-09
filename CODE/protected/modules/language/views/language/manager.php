<?php
$this->breadcrumbs=array(
    Language::t(Yii::app()->language,'Backend.Common.Menu','Add/Delete'),
);
?>

<h1><?php echo Language::t(Yii::app()->language,'Backend.Common.Menu','Add/Delete');?></h1>
<div class="form wide">
<?php echo CHtml::beginForm(); ?>
 <div class="form-group-heading"><?php echo Language::t(Yii::app()->language,'Backend.Language.Message','Add a language');?></div>
    <?php echo CHtml::errorSummary($model); ?>
     <?php
    		foreach(Yii::app()->user->getFlashes() as $key => $message) {
        		echo '<div class="'. $key . 'Message">' . $message . "</div>\n";
    		}
			?>
    <div class="row">
        <?php echo CHtml::activeLabel($model,'lang'); ?>
        <?php 
        echo CHtml::activeDropDownList(
        		$model,
        		'lang',
        		LanguageForm::getList_languages_not_exist(),
        		array(
        			'style'=>'width:200px',					
				)
        	) 
        ?>
    </div>  
     <div class="row">
        <?php echo CHtml::activeLabel($model,'origin_lang'); ?>
        <?php 
        echo CHtml::activeDropDownList(
        		$model,
        		'origin_lang',
        		LanguageForm::getList_languages_exist(),
        		array(
        			'style'=>'width:200px',					
				)
        	) 
        ?>
    </div>  
    <div class="row submit">
        <?php echo CHtml::submitButton(Language::t(Yii::app()->language,'Backend.Common.Common','Create'),array('class'=>'buttons','name'=>'create')); ?>
    </div>
 
<?php echo CHtml::endForm(); ?>
</div>
<div class="form wide">
<?php echo CHtml::beginForm(); ?>
 <div class="form-group-heading"><?php echo Language::t(Yii::app()->language,'Backend.Language.Message','Delete a language');?></div>
    <?php echo CHtml::errorSummary($model); ?>
     <?php
    		foreach(Yii::app()->user->getFlashes() as $key => $message) {
        		echo '<div class="'. $key . 'Message">' . $message . "</div>\n";
    		}
			?>
    <div class="row">
        <?php echo CHtml::activeLabel($model,'lang'); ?>
        <?php 
        echo CHtml::activeDropDownList(
        		$model,
        		'lang',
        		LanguageForm::getList_delete_languages(),
        		array(
        			'style'=>'width:200px',					
				)
        	) 
        ?>
    </div>  
    <div class="row submit">
        <?php echo CHtml::submitButton(Language::t(Yii::app()->language,'Backend.Common.Common','Delete'),array('class'=>'buttons','name'=>'delete')); ?>
    </div>
 
<?php echo CHtml::endForm(); ?>
</div>
<script type="text/javascript">
function viewAttributes(){
	$(".group").hide();
	$(".module").hide();	
	var index_group=$("#LanguageForm_group").val();
	var index_module=$("#LanguageForm_module").val();
	$(".group-"+index_group).show();
	$(".module-"+index_module).show();
}
</script>