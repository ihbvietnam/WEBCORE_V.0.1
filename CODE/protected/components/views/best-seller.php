<div class="winget-title">
                        	<label><?php echo Language::t('Các sản phẩm bán chạy')?></label>
                        </div><!--winget-title-->
                        <div class="winget-content">
                        	<div class="box-featured">
                        		<?php foreach ($list_product as $product):?>
                                <div class="grid">
                                    <a href="<?php echo $product->url?>"><?php echo $product->getThumb_url('introimage');?></a>
                                    <div class="g-content">
                                        <div class="g-row"><a class="g-title" href="<?php echo $product->url?>"><?php echo $product->code?></a></div>
                                        <div class="g-row"><?php if($product->num_price!='') echo number_format($product->num_price, 0, ',', '.').' '.$product->unit_price?></div>
                                    </div>
                                </div><!--grid-->
                                <?php endforeach;?>                              
                            </div><!--box-featured-->
                        </div><!--winget-content-->
