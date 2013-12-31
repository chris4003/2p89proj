$(function (){
	$("#count_box").hide();
});

function toggleCount(){
	
	if ($("#cycle").val() != 0)
		$("#count_box").show();
	else
		$("#count_box").hide();
};
