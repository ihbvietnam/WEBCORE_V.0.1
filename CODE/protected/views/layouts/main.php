<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='AUTHOR' content='leehaira [at] Designer'>
<meta name='COPYRIGHT' content='&copy; Lee Haira 2011'>
<meta name="keywords" content= "Lee Haira, leehaira, leehaira@gmail.com, Donoithatgo">
<meta name="desc" content="Donoithatgo INC">
<link rel="shortcut icon" href="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/fav.png" type="image/x-icon" />
<title>DNTG - Home page</title>
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
<script type="text/javascript">
$(document).ready(function(){
<?php if(Yii::app()->controller->id != "site" || Yii::app()->controller->action->id != "index"):?>
$(window).scrollTop($(".main").offset().top); 
<?php endif;?>
IMSlider.slide();
});
</script>
</head>
<body>
<div class="webtitle">
	<div class="wrapper">
    	<span class="email-label">Liên hệ qua Email:</span>
        <a class="email-link">leehaira@gmail.com</a>
        <div class="box-language">
        	Ngôn ngữ:
            <a href="#" class="active"><img src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/vie.png" width="21" height="11" alt="vie" /></a>
            <a href="#"><img src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/eng.png" width="21" height="11" alt="eng" /></a> 
        </div><!--box-language-->
    </div><!--wrapper-->
</div>
<div class="header">
	<div class="wrapper">
    	<a class="logo"></a>
        <div class="fright" style="width:200px;">
        	<div class="hotline">Hotline: <span>0983711587</span></div>
        	<a class="btn-showcart">Giỏ hàng:<span>34</span></a>
        </div>
    </div><!--wrapper-->	
</div><!--header-->
<div class="menu">
	<div class="wrapper">
        <ul>
            <li class="active"><a href="#">Trang chủ</a></li>
            <li><a href="#">Giới thiệu</a></li>
            <li><a href="#">Tin tức</a></li>
            <li><a href="#">Sản phẩm</a></li>
            <li><a href="#">Hỗ trợ</a></li>
            <li><a href="#">Liên hệ</a></li>
            <li><a href="#">Hỏi đáp</a></li>
        </ul>
        <div class="box-search">
            <input name="" type="text" class="text" onfocus="javascript:if(this.value=='Tìm kiếm...'){this.value='';};" onblur="javascript:if(this.value==''){this.value='Tìm kiếm...';};" value="Tìm kiếm..." />
            <input name="" type="submit" class="btn-search" />
        </div>
    </div><!--wrapper-->
</div><!--menu-->
<div class="slider-outer">
    <div class="wrapper">
    	<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">					
                <img src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/slider1.jpg" alt="slider1" />
                <img src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/slider2.jpg" alt="slider2" />
                <img src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/slider3.jpg" alt="slider2" />
                <img src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/slider4.jpg" alt="slider2" />
            </div>
      	</div><!--slider-wrapper-->
      	<div class="slider-right">
        	<div class="box">
            	<div class="box-title"><label>Video</label></div>
                <div class="box-content">
                	<div class="box-video">
                        <iframe width="190" height="160" src="http://www.youtube.com/embed/g9lXpn5Q99M" frameborder="0" allowfullscreen></iframe>
                    </div><!--box-video-->
                </div><!--box-content-->
            </div><!--box-->
            <div class="box">
            	<div class="box-title"><label>Hướng dẫn</label></div>
                <div class="box-content">
                	<div class="box-intro">
                        <ul>
                            <li><a href="#">Hướng dẫn mua hàng</a></li>
                            <li><a href="#">Cách giao dịch thanh toán</a></li>
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
        	<a href="#">Trang chủ</a><span></span><a href="#">Sản phẩm</a><span></span><label>Bàn ghế Minh</label>
        </div><!--tree-view-->
        <span class="update-time">Thứ 4 ngày 30/3/2012</span>
    </div><!--tree-outer-->
    <div class="bground">
    	<div class="sidebar">
        	<div class="box">
            	<div class="box-title"><label>Đặt hàng online</label></div>
                <div class="box-content">
                	<div class="menuleft">
                        <ul>
                            <li><a href="#">Bàn ăn</a></li>
                            <li><a href="#">Tủ bày phòng khách</a>
                            	<ul>
                                    <li><a href="#">Tủ đứng</a></li>
                                    <li><a href="#">Tủ nằm</a></li>
                                    <li><a href="#">Tủ 3 buồng</a></li>
                                    <li><a href="#">Tủ 2 buồng</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Bàn ghế phòng khách</a></li>
                            <li><a href="#">Kệ bày</a></li>
                            <li><a href="#">Tủ rượu</a></li>
                            <li><a href="#">Giường ngủ</a></li>
                            <li><a href="#">Tủ quần áo</a></li>
                            <li><a href="#">Tủ ngăn kéo</a></li>
                        </ul>
                    </div><!--menuleft-->
                </div><!--box-content-->
            </div><!--box-->
            <div class="box">
            	<div class="box-title"><label>Sản phẩm nổi bật</label></div>
                <div class="box-content">
                	<div class="box-featured">
                        <div class="grid">
                            <a href="#"><img class="img" src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/view1.jpg" alt="image" /></a>
                            <div class="g-content">
                                <div class="g-row"><a class="g-title" href="#">TBE-03</a></div>
                                <div class="g-row">1.200.000 VND</div>
                            </div>
                        </div><!--grid-->
                        <div class="grid">
                            <a href="#"><img class="img" src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/view2.jpg" alt="image" /></a>
                            <div class="g-content">
                                <div class="g-row"><a class="g-title" href="#">TBE-03</a></div>
                                <div class="g-row">1.200.000 VND</div>
                            </div>
                        </div><!--grid-->
                        <div class="grid">
                            <a href="#"><img class="img" src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/view3.jpg" alt="image" /></a>
                            <div class="g-content">
                                <div class="g-row"><a class="g-title" href="#">TBE-03</a></div>
                                <div class="g-row">1.200.000 VND</div>
                            </div>
                        </div><!--grid-->
                        <div class="grid">
                            <a href="#"><img class="img" src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/view4.jpg" alt="image" /></a>
                            <div class="g-content">
                                <div class="g-row"><a class="g-title" href="#">TBE-03</a></div>
                                <div class="g-row">1.200.000 VND</div>
                            </div>
                        </div><!--grid-->
                        <div class="grid">
                            <a href="#"><img class="img" src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/view1.jpg" alt="image" /></a>
                            <div class="g-content">
                                <div class="g-row"><a class="g-title" href="#">TBE-03</a></div>
                                <div class="g-row">1.200.000 VND</div>
                            </div>
                        </div><!--grid-->
                    </div><!--box-featured-->
                </div><!--box-content-->
            </div><!--box-->
            <div class="box-ad">
            	<a href="#"><img src="<?php Yii::app()->request->getBaseUrl(true)?>/images/front/data/ad1.jpg" /></a>
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
    	<ul>
        	<li><a href="#">Trang chủ</a></li>
            <li><a href="#">Giới thiệu</a></li>
            <li><a href="#">Tin tức</a></li>
            <li><a href="#">Sản phẩm</a></li>
            <li><a href="#">Hỗ trợ</a></li>
            <li><a href="#">Liên hệ</a></li>
            <li><a href="#">Hỏi đáp</a></li>
        </ul>
	</div><!--wrapper-->
</div><!--menu-bottom-->
<div class="footer">
	<div class="footer-line"></div>
	<div class="wrapper">
    	<div class="char-outer">
            <h5>Thống kê</h5>
                <div class="row"><label>Đang online:</label><span>12</span></div>
                <div class="row"><label>Lượt truy cập:</label><span>34562</span></div>
        </div><!--char-outer-->
         	
        <div class="footer-right">
        	<h5>CÔNG TY CỔ PHẦN THƯƠNG MẠI VÀ XÂY DỰNG ĐỒ NỘI THẤT GỖ</h5>
			<p>Showroom: 43 - Ngõ Văn Chương - Khâm Thiên - Hà Nội</p>
			<p>Tel/Fax: 04.35565 863</p>
			<p>Mobile: 0943 903 069</p>
			<p>Email: contact@donoithatgo.vn</p>
        </div><!--footer-right-->
        <div class="designer">Design by Lee Haira</div>  
    </div><!--wrapper-->
</div><!--footer-->
</body>
</html>