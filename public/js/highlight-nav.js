// Navigation Highlight
function highlight_nav(open,child){
	$("."+open).addClass("active");
        $("#"+open).addClass("collapse in");
	$("#"+open).attr('aria-expanded','true');
	$("."+child).addClass("active-page");
}

