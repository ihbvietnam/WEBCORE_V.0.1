<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>Thông tin chi tiết của liên hệ</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thông tin chi tiết của liên hệ</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
			<!--begin left content-->
			<div class="fl">
				<ul>
					<div class="row">
						<li>
							<label><?php echo $model->getAttributeLabel('fullname'); ?>:</label>
							<?php echo $model->fullname;?>			
						</li>
					</div>	
					<div class="row">
					<li>
							<label><?php echo $model->getAttributeLabel('email'); ?>:</label>
							<?php echo $model->email;?>	
					</li>	
					</div>
					<div class="row">
					<li>
							<label><?php echo $model->getAttributeLabel('phone'); ?>:</label>
							<?php echo $model->phone;?>	
					</li>	
					</div>	
					<div class="row">
						<li>
							<label><?php echo $model->getAttributeLabel('content'); ?>:</label>
							<?php echo $model->content;?>			
						</li>
					</div>
				</ul>
			</div>
			<!--end left content-->			
			<div class="clear"></div>          
		</div>
	</div>
	<!--end inside content-->
		<?php 
$cs = Yii::app()->getClientScript(); 
$cs->registerScriptFile('js/admin/jquery-1.7.1.min.js');
?>