                            <div class="grid">
                            	<a href="<?php echo $data->url?>"><?php echo $data->getThumb_url('thumb');?></a>
                            	<div class="g-content">
                                    <div class="g-row"><a class="g-title" href="<?php echo $data->url?>"><?php echo $data->title?></div> 
                                    <div class="g-row"><h6>(<?php echo date('d/m/Y',$data->created_date).' | '.date("H\h:i",$data->created_date)?>)</h6></div>                                  
                                    <div class="g-row"><span>Tạo ngày:&nbsp;</span><?php echo date('d/m/Y',$data->created_date)?></div>
                                	<a href="#" class="download">Tải về</a>
                                </div>
                            </div><!--grid-->
