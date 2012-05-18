<div class="login-wrapper">
		<!--begin admin list-->
		<div id="adminBox" class="fl">
			<div class="icon fl" style="background-position:-46px -92px;"></div>
			<div class="listContent fr">
				<h1>Đăng nhập</h1>				
			</div>
			<?php
    		foreach(Yii::app()->user->getFlashes() as $key => $message) {
        		echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    		}
			?>
			<div class="form">
				<?php $form=$this->beginWidget('CActiveForm', array(
				'htmlOptions'=>array(
					'name'=>'login_form',		
				),
				)); ?>
            	<div class="row fl">
            		<label>Username:</label><?php echo $form->textField($model,'username',array('style'=>'width:150px;')); ?>
            	</div>
            	<div class="row fl">
            		<label>Password:</label><?php echo $form->passwordField($model,'password',array('style'=>'width:150px;')); ?>
            	</div>
            	<div class="row fl">
            		<input name="login_submit" type="submit" value="Đăng nhập" class="button btn-login"/>
            	</div>
            <?php $this->endWidget(); ?>
		</div>
		<!--end admin list-->
	</div>
	<!--end login-wrapper-->
