				<div class="box-item">
                	<div class="b-title"><?php echo $data->name?></div>
                	<a class="b-image" href="<?php echo $data->url?>">
                   		<?php echo $data->getThumb_url('introimage');?>
                    </a>
                    <div class="b-detail">
                      	<h5><?php echo Language::t('Giá')?>: <?php if($data->num_price!='') echo number_format($data->num_price, 0, ',', '.').' '.$data->unit_price?></h5>
                        <a class="b-viewmore" href="<?php echo $data->url?>">Chi tiết</a>
                  	</div>
                </div><!--box-item-->