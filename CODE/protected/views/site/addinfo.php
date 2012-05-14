				<div class="box">
					<div class="box-title"><label>Thông tin tài khoản</label></div>
                    <div class="box-content">
						<div class="row">
							<br>
							<p><b>Quý khách vui lòng điền đầy đủ thông tin trước khi đặt hàng</b></p>
							<br>
						</div>
						<div>
							<table border="0" cellpadding="0" cellspacing="0" width="740px">
								<tbody>
									<tr>
									<div valign="top" style="border: 1px solid #D1D7E7;padding:5px;"><strong>Khách hàng</strong><br>
										<br>
										Họ và tên: <span id = "fullname"><?php echo Yii::app()->user->fullname;?></span><br>
										<br>
										Địa chỉ: <span id = "address"><?php echo Yii::app()->user->address;?></span><br>
										<br>
										Email: <span id = "email"><?php echo Yii::app()->user->email;?></span><br>
										<br>
										Phone: <span id = "phone"><?php echo Yii::app()->user->phone;?></span><br><br>
									</div>
									</tr>
								</tbody>
							</table>
						</div>
						<br>
						<br>
						<?php $form=$this->beginWidget('CActiveForm', array('method'=>'post','enableAjaxValidation'=>true,'htmlOptions'=>array('class'=>"order-form form"))); ?>
						<?php
							foreach(Yii::app()->user->getFlashes() as $key => $message) {
								echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
							}
						?>

						<div style="width:360px;display:block;overflow:hidden;float:left" id="PaymentForm">
							<div class="cus_title1"><p>Thông tin thanh toán</p></div>

							<div style="color: #4F81BC; font-weight: bold;">
								<input id="iPayCheck"
								name="iPayCheck" value="1"
								onclick="javascript:doReLoadPaymentForm(this.name);"
								type="checkbox"> Thông tin thanh toán giống thông tin tài khoản<br><br>
							</div>

							<div class="row fix-inline">
                                <?php echo $form->labelEx($model,'PaySex',array('style'=>'width:80px !important;')); ?>
								<?php echo $form->dropDownList($model,'PaySex', array('Ông'=>'Ông','Bà'=>'Bà'), array('style'=>'width:215px;','maxlength'=>'256')); ?>
                                <?php echo $form->error($model, 'PaySex'); ?>
							</div>

                            <div class="row fix-inline">
                                <?php echo $form->labelEx($model,'PayFullname',array('style'=>'width:80px !important;')); ?>
                                <?php echo $form->textField($model,'PayFullname',array('style'=>'width:215px;','maxlength'=>'256')); ?>
                                <?php echo $form->error($model, 'PayFullname'); ?>
                            </div>
							
                            <div class="row fix-inline">
                                <?php echo $form->labelEx($model,'PayAddress',array('style'=>'width:80px !important;')); ?>
								<?php echo $form->textArea($model,'PayAddress',array('style'=>'width:215px;','rows'=>6)); ?>	
								<?php echo $form->error($model, 'PayAddress'); ?>
                            </div>
							
                            <div class="row fix-inline">
                                <?php echo $form->labelEx($model,'PayPhone',array('style'=>'width:80px !important;')); ?>
                                <?php echo $form->textField($model,'PayPhone',array('style'=>'width:215px;','maxlength'=>'256')); ?>
                                <?php echo $form->error($model, 'PayPhone'); ?>
                            </div>
						</div>
							
						<div id="DeliveryForm" style="width:360px; display:block; overflow:hidden; margin-right:-5px;">
							<div class="cus_title1"><p>Thông tin giao hàng<p></div>
							<div style="color: #4F81BC; font-weight: bold;"><input id="iDelCheck"
									name="iDelCheck" value="1"
									onclick="javascript:doReLoadDeliveryForm(this.name);"
									type="checkbox"> Thông tin giao hàng giống thông tin thanh toán<br><br>
							</div>

							<div class="row fix-inline">
                                <?php echo $form->labelEx($model,'DelSex',array('style'=>'width:80px !important;')); ?>
								<?php echo $form->dropDownList($model,'DelSex',array('Ông'=>'Ông','Bà'=>'Bà'), array('style'=>'width:215px;','maxlength'=>'256')); ?>
                                <?php echo $form->error($model, 'DelSex'); ?>
							</div>

                            <div class="row fix-inline">
                                <?php echo $form->labelEx($model,'DelFullname',array('style'=>'width:80px !important;')); ?>
                                <?php echo $form->textField($model,'DelFullname',array('style'=>'width:215px;','maxlength'=>'256')); ?>
                                <?php echo $form->error($model, 'DelFullname'); ?>
                            </div>
							
                            <div class="row fix-inline">
                                <?php echo $form->labelEx($model,'DelAddress',array('style'=>'width:80px !important;')); ?>
								<?php echo $form->textArea($model,'DelAddress',array('style'=>'width:215px;','rows'=>6)); ?>	
								<?php echo $form->error($model, 'DelAddress'); ?>
                            </div>
							
                            <div class="row fix-inline">
                                <?php echo $form->labelEx($model,'DelPhone',array('style'=>'width:80px !important;')); ?>
                                <?php echo $form->textField($model,'DelPhone',array('style'=>'width:215px;','maxlength'=>'256')); ?>
                                <?php echo $form->error($model, 'DelPhone'); ?>
                            </div>
							<br>
						</div>
						<div class="row fix-inline">
                                <?php echo $form->labelEx($model,'payment_type',array('style'=>'width:80px !important;')); ?>
                                <?php echo $form->dropDownList($model,'payment_type', 
                                	 array('Thanh toán bằng thẻ ATM'=>'Thanh toán bằng thẻ ATM',
                                	 		'Thanh toán bằng thẻ tín dụng'=>'Thanh toán bằng thẻ tín dụng',
                                	 		'Nhân viên vận chuyển thu tiền khi giao hàng'=>'Nhân viên vận chuyển thu tiền khi giao hàng',
                                	 		'Chuyển tiền qua bưu điện'=>'Chuyển tiền qua bưu điện',
                                	 ),
                                	 array('style'=>'width:215px;','maxlength'=>'256')); ?>
                                <?php echo $form->error($model, 'payment_type'); ?>
                        </div>
						
						<div class="row">
							<input class="fright big-button" style="margin-right:50px;" value="Đặt hàng" type="submit"/>
							<br><br>
						</div>
						<?php $this->endWidget(); ?>
					</div><!--box-content-->
				</div><!--box-->
<script>
$(document).ready(function() {

	 $('#PaymentForm :checkbox').change(function(){
		if($('input[name="iPayCheck"]').is(':checked')){
            document.getElementById("Order_PayFullname").value = document.getElementById('fullname').innerHTML;
			document.getElementById("Order_PayAddress").value = document.getElementById('address').innerHTML;
			document.getElementById("Order_PayPhone").value = document.getElementById('phone').innerHTML;
		}
		else{
			document.getElementById("Order_PayFullname").value = '';
			document.getElementById("Order_PayAddress").value = '';
			document.getElementById("Order_PayPhone").value = '';
		}
      });
	  
	  	 $('#DeliveryForm :checkbox').change(function(){
		if($('input[name="iDelCheck"]').is(':checked')){
            document.getElementById("Order_DelFullname").value = document.getElementById('Order_PayFullname').value;
			document.getElementById("Order_DelAddress").value = document.getElementById('Order_PayAddress').value;
			document.getElementById("Order_DelPhone").value = document.getElementById('Order_PayPhone').value;
		}
		else{
			document.getElementById("Order_DelFullname").value = '';
			document.getElementById("Order_DelAddress").value = '';
			document.getElementById("Order_DelPhone").value = '';
		}
      });
});
</script>