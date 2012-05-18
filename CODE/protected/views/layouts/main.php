<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='AUTHOR' content='<?php echo Language::t(Setting::s('META_AUTHOR','System'));?>'>
<meta name='COPYRIGHT' content='<?php echo Language::t(Setting::s('META_COPYRIGHT','System'));?>'>
<meta name="keywords" content= "<?php echo Language::t(Setting::s('META_KEYWORD','System'));?>">
<meta name="desc" content="<?php echo Language::t(Setting::s('META_DESCRIPTION','System'));?>">
<link rel="shortcut icon" href="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/fav.png" type="image/x-icon" />
<!--css default-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true)?>/css/front/reset.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true)?>/css/front/common.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true)?>/css/front/form.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true)?>/css/front/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true)?>/css/front/nivo-slider.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true)?>/css/front/jquery.fancybox-1.3.4.css">
<!--js default-->
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true)?>/js/front/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true)?>/js/front/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true)?>/js/front/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true)?>/js/front/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true)?>/js/front/tab.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->getBaseUrl(true)?>/js/front/main.slider.js"></script>
<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
<title><?php echo Language::t(Setting::s('FRONT_SITE_TITLE','System'));?></title>
<script type="text/javascript">
$(document).ready(function(){
<?php if(Yii::app()->controller->id != "site" || Yii::app()->controller->action->id != "index"):?>
$(window).scrollTop($(".main").offset().top); 
<?php endif;?>
});
</script>
</head>
<body>
<div class="webtitle">
	<div class="wrapper">
    	<span class="email-label"><?php echo Language::t('Liên hệ qua Email');?>:</span>
        <a class="email-link"><?php echo Setting::s('EMAIL_CONTACT','System');?></a>
        <div class="box-language">
        	<?php echo Language::t('Ngôn ngữ');?>:
            <a href="<?php echo Yii::app()->createUrl('site/language',array('language'=>'vi'))?>" class="active"><img src="<?php echo Yii::app()->request->getBaseUrl(true)?>/images/front/vie.png" width="21" height="11" alt="vie" /></a>
            <a href="<?php echo Yii::app()->createUrl('site/language',array('language'=>'en'))?>"><img src="<?php echo Yii::app()->request->getBaseUrl(true)?>/images/front/eng.png" width="21" height="11" alt="eng" /></a> 
        </div><!--box-language-->
    </div><!--wrapper-->
</div>
<div class="header">
	<div class="wrapper">
    	<a class="logo"></a>
        <div class="fright" style="width:200px;">
        	<div class="hotline"><?php echo Language::t('Hotline');?>: <span><?php echo Setting::s('HOTLINE','System');?></span></div>
        	<a href="<?php echo Yii::app()->createUrl('cart/cart')?>" class="btn-showcart"><?php echo Language::t('Giỏ hàng');?>:<span id="qty_cart"> <?php if(isset(Yii::app()->session['cart']))echo sizeof(Yii::app()->session['cart']); else {Yii::app()->session['cart']=array();echo '0';}?></span></a>
        </div>
    </div><!--wrapper-->	
</div><!--header-->
<div class="menu">
	<div class="wrapper">
         	<?php $this->widget('wMenu',array('group'=>Category::GROUP_USER_MENU,'view'=>'front-end-menu'))?>
         	<?php $this->widget('wQuickSearch')?>
    </div><!--wrapper-->
</div><!--menu-->
<div class="slider-outer">
    <div class="wrapper">
    	<div class="slider-wrapper theme-default">				
            <?php $this->widget('wBanner',array('code'=>Banner::CODE_HEADLINE,'view'=>'head-line'))?>
      	</div><!--slider-wrapper-->
      	<div class="slider-right">
        	<div class="box">
       			<?php $this->widget('wVideo',array('view'=>'video'));?> 
            </div><!--box-->
            <div class="box">
            	<div class="box-title"><label><?php echo Language::t('Hướng dẫn');?></label></div>
                <div class="box-content">
                	<div class="box-intro">
                        <ul>
                            <li><a href="<?php echo Yii::app()->createUrl('staticPage/view',array('cat_alias'=>News::ALIAS_GUIDE_CATEGORY))?>"><?php echo Language::t('Hướng dẫn mua hàng');?></a></li>
                            <li><a href="<?php echo Yii::app()->createUrl('staticPage/view',array('cat_alias'=>News::ALIAS_GUIDE_CATEGORY))?>"><?php echo Language::t('Phương thức thanh toán');?></a></li>
                        </ul>
                    </div><!--box-intro-->
                </div><!--box-content-->
            </div><!--box-->
        </div><!--slider-right-->
    </div><!--wrapper-->
</div><!--slider-outer-->
<div class="wrapper">
    <div class="tree-outer">
    	<div class="tree-view">
    		<?php 
    			$this->widget('wBreadCrumbs',array('data'=>$this->bread_crumbs));
    		?>        	
        </div><!--tree-view-->
        <span class="update-time"><?php echo date("d/m/Y"); ?></span>
    </div><!--tree-outer-->
    <div class="bground">
    	<div class="sidebar">
        	<div class="box">
            	<?php $this->widget('wMenu',array('group'=>Category::GROUP_PRODUCT,'view'=>'menu-left'));?> 
            </div><!--box-->
            <div class="box">
            	<?php $this->widget('wProduct',array('view'=>'remark','special'=>Product::SPECIAL_REMARK,'limit'=>Setting::s('SIZE_REMARK_PRODUCT','Product')));?> 
            </div><!--box-->
            <div class="box-ad">
            	<?php $this->widget('wBanner',array('code'=>Banner::CODE_LEFT,'view'=>'banner-left'));?> 
            </div><!--box-ad-->
        </div><!--sidebar-->
        <div class="main">
        	<?php echo $content;?>
        </div><!--main-->
    </div><!--bground-->
    <div class="clearfix"></div>
</div><!--wrapper-->
<div class="menu-bottom">
	<div class="wrapper">
    <?php $this->widget('wMenu',array('group'=>Category::GROUP_USER_MENU,'view'=>'front-end-menu'))?>
	</div><!--wrapper-->
</div><!--menu-bottom-->
<div class="footer">
	<div class="footer-line"></div>
	<div class="wrapper">
    	<div class="char-outer">
            <h5>Thống kê</h5>
                <div class="row"><label><?php echo Language::t('Đang online');?>:</label><span><?php echo rand(13,14);?></span></div>
        </div><!--char-outer-->
         	
        <div class="footer-right">
        	<h5><?php echo Language::t(Setting::s('COMPANY','System'));?></h5>
			<p><?php echo Language::t('Showroom');?>: <?php echo Language::t(Setting::s('ADDRESS_SHOWROOM','System'));?></p>
			<p><?php echo Language::t('Tel/Fax');?>: <?php echo Language::t(Setting::s('TEL/FAX','System'));?></p>
			<p><?php echo Language::t('Mobile');?>: <?php echo Language::t(Setting::s('MOBILE','System'));?></p>
			<p><?php echo Language::t('Email');?>: <?php echo Language::t(Setting::s('EMAIL','System'));?></p>
        </div><!--footer-right-->
        <div class="designer"><?php echo Language::t(Setting::s('DESIGN_BY','System'));?></div>  
    </div><!--wrapper-->
</div><!--footer-->
</body>
</html>