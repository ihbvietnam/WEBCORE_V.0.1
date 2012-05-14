<title>Khophutung.vn - Số hợp đồng <?php echo $order->id;?></title>
<table id="wrapper" cellspacing="1" cellpadding="10" bgcolor="#cccccc"
	align="center">
	<tbody>
		<tr>
			<td bgcolor="#ffffff">
			<table width="100%">
				<tbody>
					<tr>
						<td width="50%">
						<p><img src="images/front/logo.png"></p>
						</td>
						<td width="50%" align="center"><font class="unpaid">Chưa thanh
						toán</font><br>
						<p>Quý khách vui lòng tham khảo các hướng dẫn thanh toán tại đây:
						http://khophutung.vn/thanh-toan.html để có được các thông tin
						chuyển khoản chính xác nhất.<br>
						Theo hợp đồng số: <?php echo $order->id;?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<br>
			<table width="100%" id="invoicetoptables" cellspacing="0">
				<tbody>
					<tr>
						<td width="50%" id="invoicecontent"
							style="border: 1px solid #D1D7E7">
						<table width="100%" height="100" cellspacing="0" cellpadding="10"
							id="invoicetoptables">
							<tbody>
								<tr>
									<td id="invoicecontent" valign="top"
										style="border: 1px solid #D1D7E7"><strong>Khách hàng</strong><br>
									<br>
									Họ và tên: <?php echo $order->list_other_attributes['fullname'];?><br>
									<br>
									Địa chỉ: <?php echo $order->list_other_attributes['address'];?><br>
									<br>
									Email: <?php echo $order->list_other_attributes['email'];?><br>
									<br>
									Phone: <?php echo $order->list_other_attributes['phone'];?><br><br><br>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
						<td width="50%" id="invoicecontent"
							style="border: 1px solid #D1D7E7; border-left: 0px;">
						<table width="100%" height="100" cellspacing="0" cellpadding="10"
							id="invoicetoptables">
							<tbody>
								<tr>
									<td id="invoicecontent" valign="top"
										style="border: 1px solid #D1D7E7"><strong>Thông tin Cửa hàng</strong><br>
									<br>
									Khophutung.vn PartswareHouse<br>
									<br>
									Tầng 4 - số 6 - ngõ 850 - Đ. Láng, Q. Đống Đa, HN<br>
									<br>
									ĐT: 04 6680 7626 - Fax: 04 6680 7626<br>
									<br>
									Email: lienhe@khophutung.vn <br><br> Website: www.khophutung.vn<br>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td width="50%" id="invoicecontent"
							style="border: 1px solid #D1D7E7">
						<table width="100%" height="100" cellspacing="0" cellpadding="10"
							id="invoicetoptables">
							<tbody>
								<tr>
									<td id="invoicecontent" valign="top"
										style="border: 1px solid #D1D7E7"><strong>Thông tin thanh toán</strong><br>
									<br>
									Họ và tên: <?php echo $order->list_other_attributes['PayFullname'];?><br>
									<br>
									Địa chỉ: <?php echo $order->list_other_attributes['PayAddress'];?><br>
									<br>
									Phone: <?php echo $order->list_other_attributes['PayPhone'];?><br><br><br>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
						<td width="50%" id="invoicecontent"
							style="border: 1px solid #D1D7E7; border-left: 0px;">
						<table width="100%" height="100" cellspacing="0" cellpadding="10"
							id="invoicetoptables">
							<tbody>
								<tr>
									<td id="invoicecontent" valign="top"
										style="border: 1px solid #D1D7E7"><strong>Thông tin giao hàng</strong><br>
									<br>
									Họ và tên: <?php echo $order->list_other_attributes['DelFullname'];?><br>
									<br>
									Địa chỉ: <?php echo $order->list_other_attributes['DelAddress'];?><br>
									<br>
									Phone: <?php echo $order->list_other_attributes['DelPhone'];?><br><br><br>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			
			<br><br>
			<p><strong>Thông tin chi tiết đơn hàng</strong><br><br>

			<table class="tdata" cellspacing="0">
				<thead>
					<tr>
						<th width="5%">STT</th>
						<th width="30%">Tên sản phẩm</th>
						<th width="15%">Đơn giá</th>
						<th width="15%">Số lượng</th>
						<th width="20%">Thành tiền</th>
					</tr>
				</thead>
				<tbody>
					<tr class="even">
			            <?php
							$this->widget (
								'zii.widgets.CListView', 
								array (
									'id' => 'product-list-view', 
									'dataProvider' => $list_product, 
									'itemView' => '_checkout', 
									'template' => "{items}" 
								));
						?>  
                    </tr>
					<!--class-event-->
					<tr>
						<td align="right" colspan="4">Tổng tiền</td>
						<td align="right"><?php echo $_SESSION ['cart'] ['sum'];?></td>
					</tr>
					<tr class="even">
						<td align="right" colspan="4">Tiền vận chuyển</td>
						<td align="right">0.00</td>
					</tr>
					<tr class="even">
						<td align="right" colspan="4">Tổng tiền đã gồm vận chuyển</td>
						<td align="right"><?php
						echo $_SESSION ['cart'] ['sum'];
						?></td>
					</tr>
				</tbody>
			</table>

			<br>
			<br>
			<p style="margin-left: 5px;"><strong>Chú ý:</strong></br>
			- Để đảm bảo tính chính xác, chúng tôi có gửi một mail tới hòm thư
			của Quý khách. </br>
			- Quý khách vui lòng kiểm tra email để xác nhận đơn hàng!<br>
			- Trong trường hợp, Quý khách không nhận được mail xác nhận, vui lòng
			click <a href="">vào đây</a> để nhận lại mail xác nhận. </br>
			<strong> Xin cảm ơn! </strong></p>
			<br>
			<br>

			</td>
		</tr>
	</tbody>
</table>
<p align="center"><a
	href="<?php echo Yii::app()->createUrl('site/cart');?>">« Quay lại giỏ hàng</a> | <a
	href="<?php echo Yii::app()->createUrl('site/index');?>">Về Trang chủ</a></p>
