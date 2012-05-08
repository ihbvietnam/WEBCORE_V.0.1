// JavaScript Document
window.addEvent('domready', function(){
	var mySlide = new Fx.Slide('toggle');
	$('ex').addEvent('click', function(e){
		e = new Event(e);
		mySlide.toggle();
		e.stop();
	});
});
