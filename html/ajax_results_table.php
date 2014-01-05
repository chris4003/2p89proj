#!/usr/bin/php-cgi
<?php
	include '../php/event.php';
	if ($_GET)
	{
	    $pTitle = $_GET["title"];
	    $pDescription = $_GET["description"];
	    $pCity = $_GET["city"];
	    $pEventStart = $_GET["eventstart"];
	    $pEventEnd = $_GET["eventend"];
	    $pInterests = $_GET["tagids"];

	    $aEvents = SearchEvent($pTitle, $pDescription,$pCity, $pEventStart, $pEventEnd, $pInterests);
	    #date("Y/m/d 23:59:59")
  	}
  	else
  	{
  		$aEvents = SearchEvent("","","", date("Y/m/d H:i:s"),  date("Y/m/d 23:59:59", time()+(7*24*3600)));	
  	}

	if (!is_null($aEvents))
	{
		include "render_event_table.php";
	}
	#var_dump($_SESSION);
?>