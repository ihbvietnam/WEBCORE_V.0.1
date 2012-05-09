<?php echo CHtml::beginForm(); ?>
 
    <?php echo CHtml::errorSummary($model); ?>
     <?php
    		foreach(Yii::app()->user->getFlashes() as $key => $message) {
        		echo '<div class="'. $key . 'Message">' . $message . "</div>\n";
    		}
			?>
	  <div class="row">
		<input class="buttons" type="button" value="<?php echo Language::t(Yii::app()->language,'Backend.Language.Export','Export file')?>" onClick="parent.location='<?php echo Yii::app()->createUrl('Language/language/exportFile')?>';return false;"/>
	</div>
    <div class="row">
        <?php echo CHtml::activeLabel($model,'lang'); ?>
        <?php 
        echo CHtml::activeDropDownList(
        		$model,
        		'lang',
        		LanguageForm::getList_languages_not_exist(),
        		array(
        			'style'=>'width:100px',
					'ajax' => array(
						'type'=>'POST', 
						'url'=>CController::createUrl('Language/changeLanguage',array('action'=>'create')), 
						'update'=>'#form-language', 
						'data'=>'js:{language:$("#LanguageForm_lang").val()}'  
					)
				)
        	) 
        ?>
    </div>
    
     <div class="row">
        <?php echo CHtml::activeLabel($model,'group'); ?>
        <?php echo CHtml::activeDropDownList(
        				$model,
        				'group',
        				$model->getList_groups(),
        				array(
        					'style'=>'width:100px',
        				)
        			) ?>
    </div>
    
    <div class="row">
        <?php echo CHtml::activeLabel($model,'module'); ?>
        <?php echo CHtml::activeDropDownList(
        				$model,
        				'module',
        				$model->getList_modules(),
        				array(
        					'style'=>'width:100px',
        				)
        				) ?>
    </div>
 
 	<?php 
 	$list=$model->list_records;
 	foreach ($list as $index_group=>$list_groups) {
 		if($index_group != $model->group)
 			echo "<div class='group group-$index_group' style='display:none;'>";
 		else 	
 			echo "<div class='group group-$index_group'>";
 			
 		foreach ($list_groups as $index_module=>$list_modules){
 			if($index_module != $model->module)
 				echo "<div class='module module-$index_module' style='display:none;'>";
 			else 	
 				echo "<div class='module module-$index_module'>";
 			/*	
 			if($index_module !="")
 				echo '<div class="form-group-heading">'.$index_module.'</div>';
 			else 	
 				echo '<div class="form-group-heading">Common</div>';
 			*/	
 			foreach ($list_modules as $index_type=>$list_type){
 				echo "<div class='type type-$index_type'>";
 				
 				echo '<div class="form-group-heading">'.$index_type.'</div>';
 					
 				foreach ($list_type as $index=>$record){ 					 				
 					echo '<div class="row">';
 					echo CHtml::label($index,'LanguageForm[list_records]['.$index_group.']['.$index_module.']['.$index_type.']['.$index.']');
 					echo CHtml::textField('LanguageForm[list_records]['.$index_group.']['.$index_module.']['.$index_type.']['.$index.']',$record,array('style'=>'width:600px;'));
 					echo '</div>';
 				}
 				
 				echo "</div>";
 			}
 			
 			echo "</div>";
 		}
 		
 		echo "</div>";
 	}
 	?> 
<?php echo CHtml::endForm(); ?>
