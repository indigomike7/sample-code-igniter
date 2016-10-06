$(document).ready(function(){
	var first = $("#tab-link a").first();
	var firstContent = first.attr("href");

	first.addClass("active");
	$(firstContent).toggle();
});

$(function(){
	$("#tab-link a").live("click",function(e){
		e.preventDefault();

		var newContent = $(this).attr("href");

		$("#tab-link a").removeClass("active");
		$(this).addClass("active");

		$(".tab-content").hide();
		$(newContent).toggle();
	});
});