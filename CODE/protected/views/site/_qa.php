 <div class="grid">
<div class="g-row"><a href="<?php echo $data->url?>" class="g-title"><?php echo $data->question;?></a></div>
<div class="g-row"><h6><?php echo Language::t('Câu trả lời')?>:</h6></div>
<div class="g-row">
<?php echo iPhoenixString::createIntrotext($data->answer,Setting::s('QA_INTRO_LENGTH'));?> 
</div>
</div><!--grid-->