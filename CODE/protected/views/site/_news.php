<div class="grid">
                            <a href="<?php echo $data->url?>"><?php echo $data->getThumb_url('introimage');?></a>
                            <div class="g-content">
                                <div class="g-row"><a href="<?php echo $data->url?>" class="g-title"><?php echo $data->title?></a><span><?php if(!in_array($data->catid,array(News::GUIDE_CATEGORY,News::PRESENT_CATEGORY))) echo date("(d/m/Y)",$data->created_date); ?></span></div>
                                <div class="g-row">
                                	<?php echo iPhoenixString::createIntrotext($data->introtext,Setting::s('LIST_INTRO_LENGTH'));?>
                                </div>
                            </div>
                        </div><!--grid-->
