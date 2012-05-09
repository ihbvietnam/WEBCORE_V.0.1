<?php
$this->breadcrumbs=array(
    Language::t(Yii::app()->language,'Backend.Common.Menu','Import'),
);
?>

<h1><?php echo Language::t(Yii::app()->language,'Backend.Common.Menu','Import');?></h1>
<div class="form wide" id="form-language">
<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
 
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
        		ImportForm::getList_languages()        		
				)
        ?>
    </div>
    <div class="row">
    <?php echo CHtml::activeLabel($model,'file'); ?>
    <?php echo CHtml::activeFileField($model, 'file'); ?>
    </div>
    <div class="row submit">
        <?php echo CHtml::submitButton( Language::t(Yii::app()->language,'Backend.Common.Common','Upload'),array('class'=>'buttons')); ?>
    </div>
 
<?php echo CHtml::endForm(); ?>
</div>