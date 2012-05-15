<?php 
$this->bread_crumbs=array(
	array('url'=>Yii::app()->createUrl('site/home'),'title'=>Language::t('Trang chủ')),
	array('url'=>'','title'=>Language::t('Giỏ hàng')),
)
?>
<div class="cart-outer">
            	<div class="product-table">
                    <table class="tdata">
                        <thead>
                            <tr>
                                <th width="10%">&nbsp;</th>
                                <th width="15%"><?php echo Language::t('Mã')?></th>
                                <th width="30%"><?php echo Language::t('Danh mục')?></th>
                                <th width="15%"><?php echo Language::t('Đơn giá')?></th>
                                <th width="15%" colspan="3"><?php echo Language::t('Số lượng')?></th>
                                <th width="15%"><?php echo Language::t('Thành tiền')?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(sizeof($list_product)>0):?>
                        	<?php $total=0;?>
                        	<?php foreach ($list_product as $id_product=>$qty):?>
                        	<?php 
                        		$product=Product::model()->findByPk($id_product);
                        		$total += $qty*$product->num_price;
                        	?>
                            <tr>
                                <td align="center"><?php echo CHtml::ajaxLink(Language::t('Xóa SP'),Yii::app()->createUrl('site/removeCart',array('id'=>$id_product)), array('dataType'=>'json','success'=>'function(data){$(".main").html(data.cart);$("#qty_cart").html(" "+data.qty)}'), array('id'=>'remove-cart'.$id_product));?></td>
                                <td><?php echo $product->code;?></td>
                                <td><?php echo $product->name;?></td>
                                <td align="right"><?php echo $product->code;?></td>
                                <td align="center"><?php echo CHtml::ajaxLink('+',Yii::app()->createUrl('site/plusMinusCart',array('id'=>$id_product,'sign'=>'1')), array('dataType'=>'json','success'=>'function(data){$(".main").html(data.cart);$("#qty_cart").html(" "+data.qty)}'), array('id'=>'plus-cart'.$id_product,'class'=>'btn-plus'));?></td>
                                <td align="center"><?php echo $qty?></td>
                                <td align="center"><?php echo CHtml::ajaxLink('-',Yii::app()->createUrl('site/plusMinusCart',array('id'=>$id_product,'sign'=>'-1')), array('dataType'=>'json','success'=>'function(data){$(".main").html(data.cart);$("#qty_cart").html(" "+data.qty)}'), array('id'=>'minus-cart'.$id_product,'class'=>'btn-minus'));?></td>
                                <td align="right"><?php echo number_format($product->num_price, 0, ',', '.').' '.$product->unit_price;?></td>
                            </tr>
                            <?php endforeach;?>                           
                            <tr>
                                <td align="right" colspan="7"><?php echo Language::t('Tổng tiền')?></td>
                                <td align="right"><?php echo number_format($total, 0, ',', '.').' '.$product->unit_price;?></td>
                            </tr>
                        <?php else:?>
                         <tr>
                         	<td colspan="8">
                        	<?php echo Language::t('Giỏ hàng trống')?>
                        	</td>
                        </tr>
                        <?php endif;?>
                        </tbody>
                    </table>
                </div><!--product-table-->
                <div class="cart-button">
                    <a href="<?php echo Yii::app()->createUrl('site/product');?>" class="fleft big-button"><?php echo Language::t('Mua hàng tiếp')?></a>
                </div><!--cart-button-->
                <div class="cart-note">
                    <p><b><?php echo Language::t('Lưu ý')?>: </b><?php echo Language::t('Một số sản phẩm chưa được báo giá cụ thể, khi đặt hàng khách hàng sẽ thoả thuận để có được giá phù hợp nhất')?>.</p>
                </div><!--cart-note-->	
               <?php $form=$this->beginWidget('CActiveForm', array('action'=>Yii::app()->createUrl('site/cart'),'method'=>'post','enableAjaxValidation'=>false,'htmlOptions'=>array('class'=>'contact-form form','style'=>'display:block'))); ?>
                     <?php
    					foreach(Yii::app()->user->getFlashes() as $key => $message) {
        					echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    					}
					?>
                    <div class="row fix-inline">
                        <h3>(*) Phần thông tin bắt buộc:</h3>
                    </div>
                    <div class="row fix-inline">
                        <?php echo $form->labelEx($model,'fullname'); ?>
                        <?php echo $form->textField($model,'fullname',array('style'=>'width:288px;')); ?>	
						<?php echo $form->error($model, 'fullname'); ?>		
                    </div>
                    <div class="row fix-inline">
                   		<?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->textField($model,'email',array('style'=>'width:288px;')); ?>	
						<?php echo $form->error($model, 'email'); ?>	
                    </div>
                    <div class="row fix-inline">
                        <?php echo $form->labelEx($model,'phone'); ?>
                        <?php echo $form->textField($model,'phone',array('style'=>'width:288px;')); ?>	
						<?php echo $form->error($model, 'phone'); ?>
                    </div>
                    <div class="row fix-inline">
                        <?php echo $form->labelEx($model,'address'); ?>
                        <?php echo $form->textField($model,'address',array('style'=>'width:288px;')); ?>	
						<?php echo $form->error($model, 'address'); ?>
                    </div>
                    <div class="row fix-inline">
                     <?php echo $form->labelEx($model,'note'); ?>
                     <?php echo $form->textField($model,'note',array('style'=>'width:400px; min-height:150px;')); ?>	
					 <?php echo $form->error($model, 'note'); ?>
                     </div>              
                    <div class="row">
                        <input type="submit" value="Gửi đi" class="button" name="btn-submit" />
                    </div>
                <?php $this->endWidget(); ?>
            </div><!--cart-outer-->