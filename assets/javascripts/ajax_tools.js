var xmlHttp=false;
createXMLHttpRequest();

function createXMLHttpRequest(){
  if (window.ActiveXObject) {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  else if (window.XMLHttpRequest) {
    xmlHttp=new XMLHttpRequest();
    }
}

function getEventTable(){
	var obj = document.getElementById("content_mid");
	serverpage = "../html/results_table.php?" + $('#search_form').serialize();//just a hint of jquery for flavour :D
   	xmlHttp.open("GET", serverpage);

  	xmlHttp.onreadystatechange = function() {
    	if (xmlHttp.readyState == 4 && xmlHttp.status==200) {
       		obj.innerHTML = xmlHttp.responseText;
	     	}
    }
    xmlHttp.send();
    return false;
}