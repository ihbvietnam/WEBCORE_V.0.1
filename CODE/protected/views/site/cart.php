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
                                <th width="15%">Mã</th>
                                <th width="30%">Danh mục</th>
                                <th width="15%">Đơn giá</th>
                                <th width="15%" colspan="3">Số lượng</th>
                                <th width="15%">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php $total=0;?>
                        	<?php foreach ($list_product as $id_product=>$qty):?>
                        	<?php 
                        		$product=Product::model()->findByPk($id_product);
                        		$total += $qty*$product->num_price;
                        	?>
                            <tr>
                                <td align="center"><a href="<?php echo Yii::app()->createUrl('site/removeCart',array('id'=>$id_product));?>">Xoá SP</a></td>
                                <td><?php echo $product->code;?></td>
                                <td><?php echo $product->name;?></td>
                                <td align="right"><?php echo $product->code;?></td>
                                <td align="center"><a class="btn-plus" href="<?php echo Yii::app()->createUrl('site/plusMinusCart',array('id'=>$id_product,'sign'=>'1'));?>">+</a></td>
                                <td align="center"><?php echo $qty?></td>
                                <td align="center"><a class="btn-minus" href="<?php echo Yii::app()->createUrl('site/plusMinusCart',array('id'=>$id_product,'sign'=>'-1'));?>">-</a></td>
                                <td align="right"><?php echo number_format($product->num_price, 0, ',', '.').' '.$product->unit_price;?></td>
                            </tr>
                            <?php endforeach;?>                           
                            <tr>
                                <td align="right" colspan="7"><?php echo Language::t('Tổng tiền')?></td>
                                <td align="right"><?php echo number_format($total, 0, ',', '.').' '.$product->unit_price;?></td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--product-table-->
                <div class="cart-button">
                    <a href="<?php echo Yii::app()->createUrl('site/product');?>" class="fleft big-button"><?php echo Language::t('Mua hàng tiếp')?></a>
                    <a href="<?php echo Yii::app()->createUrl('site/addInfo');?>" class="fright big-button"><?php echo Language::t('Đặt hàng')?></a>
                </div><!--cart-button-->
                <div class="cart-note">
                    <p><b><?php echo Language::t('Lưu ý')?>: </b><?php echo Language::t('Một số sản phẩm chưa được báo giá cụ thể, khi đặt hàng khách hàng sẽ thoả thuận để có được giá phù hợp nhất')?>.</p>
                </div><!--cart-note-->	
            </div><!--cart-outer-->