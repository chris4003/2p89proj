function tagPicked() {
	if ($("#tag_select").val() != "0"){
		if (document.getElementById("tags").value != ""){
			document.getElementById("tags").value += ",";
			document.getElementById("tagids").value += ",";
		}
		document.getElementById("tags").value += $("#tag_select option:selected").text();
		document.getElementById("tagids").value += $("#tag_select").val();
	}
};
function clearTags() {
	document.getElementById("tags").value = "";
	document.getElementById("tagids").value = "";
}