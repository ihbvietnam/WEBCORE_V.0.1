$(document).ready(function(){
	$('#btn-add-product').click(function(){
		var height = $(window).height();
		$("body").css("overflow","hidden");	
		$(".main-popup").css("margin-top",-(height-$(".main-popup").height())/2);
		$(".main-popup").css("margin-left",-350);		
		$(".main-popup").css("display","block");
		$(".bg-overlay").css("display","block");
	});
	$('.popup-close, .p-close').click(function(){	
		$("body").css("overflow","auto");		
		$(".main-popup").css("display","none");
		$(".bg-overlay").css("display","none");
	});	
});