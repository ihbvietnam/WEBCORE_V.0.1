$(document).ready(function(){ 
	$('div','.contact-tab').click(function () {
		$('div', $('.contact-tab')).removeClass("active");
		$(this).addClass("active");
	});
	$('div.tab-click1','.contact-tab').click(function () {
		$(".tab-content1").css("display","block");
		$(".tab-content2").css("display","none");
	});
	$('div.tab-click2','.contact-tab').click(function () {
		$(".tab-content1").css("display","none");
		$(".tab-content2").css("display","block");
	});
});