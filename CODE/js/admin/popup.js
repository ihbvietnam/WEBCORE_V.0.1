function showPopUp(){
	var height = $(window).height();
	$("body").css("overflow","hidden");	
	$(".main-popup").css("margin-top",-(height-$(".main-popup").height())/2);
	$(".main-popup").css("margin-left",-350);		
	$(".main-popup").css("display","block");
	$(".bg-overlay").css("display","block");
}
function hidenPopUp(){
	$("body").css("overflow","auto");		
	$(".main-popup").css("display","none");
	$(".bg-overlay").css("display","none");
}