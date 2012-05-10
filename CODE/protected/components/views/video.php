<div class="box-title"><label><?php
echo Language::t ( 'Video' );
?>:</label></div>
<div class="box-content">
<div class="box-video">
<?php
if (isset ( $gallery_video )) {
	$this->widget ( 'application.extensions.smp.StrobeMediaPlayback', array ('src' => $gallery_video->link, 'src_title' => '', 'width' => '270', 'height' => '250', 'allowFullScreen' => 'true' ) );
}
?>
</div>
<!--box-video--></div>
<!--box-content-->
