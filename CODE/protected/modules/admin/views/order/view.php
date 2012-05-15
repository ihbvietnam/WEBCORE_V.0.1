<!--begin inside content-->
	<div class="folder top">
		<!--begin title-->
		<div class="folder-header">
			<h1>Thông tin chi tiết của Đơn hàng</h1>
			<div class="header-menu">
				<ul>
					<li><a class="header-menu-active new-icon" href=""><span>Thông tin chi tiết của đơn hàng</span></a></li>					
				</ul>
			</div>
		</div>
		<!--end title-->
		<div class="folder-content form">
			<div>
            	<input type="button" class="button" value="Danh sách đơn hàng" style="width:180px;" onClick="parent.location='<?php echo Yii::app()->createUrl('admin/order/index')?>'"/>
                <div class="line top bottom"></div>	
            </div>
			<!--begin left content-->
			<div class="fl">
				<ul>
					<div class="row">						
							<b><label><?php echo $model->getAttributeLabel('fullname'); ?>:</label></b>
							<?php echo $model->fullname;?>									
					</div>	
						<div class="row">
						<li>
							<b><label><?php echo $model->getAttributeLabel('order_value'); ?></label></b>
							<?php echo $model->order_value;?>			
						</li>
					</div>
					<div class="row">
						<li>
							<b><label><?php echo $model->getAttributeLabel('order_content'); ?></label></b>
							</br>
							<?php echo $model->order_content;?>			
						</li>
					</div>
					<div class="row">						
							<b><label><?php echo $model->getAttributeLabel('address'); ?>:</label></b>
							<?php echo $model->address;?>									
					</div>	
					<div class="row">					
							<b><label><?php echo $model->getAttributeLabel('phone'); ?>:</label></b>
							<?php echo $model->phone;?>						
					</div>	
					<div class="row">					
							<b><label><?php echo $model->getAttributeLabel('email'); ?>:</label></b>
							<?php echo $model->email;?>						
					</div>
					<div class="row">					
							<b><label><?php echo $model->getAttributeLabel('note'); ?>:</label></b>
							</br>
							<?php echo $model->note;?>						
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