$(document).ready(function() {

	//When page loads...
	$(".tab-content").hide(); //Hide all content
	$(".tab-title a:first").addClass("active").show(); //Activate first tab
	$(".tab-content:first").show(); //Show first tab content

	//On Click Event
	$(".tab-title a").click(function() {

		$(".tab-title a").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab-content").hide(); //Hide all tab content

		var activeTab = $(this).attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});