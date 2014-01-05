#!/usr/bin/php-cgi

<?php
	
	include 'event.php';
	include "../php/flash_tools.php"; 

	$row = findEvent($_GET['id']);

	if ($row["us_id"] == $_SESSION['user_id'] && ($errormsg = deleteEventDate($_GET['id'])) == "" ){ #security check
		
		set_flash_message("Event Deleted");
		header("Location:". "../html/index.php");
	}
	else {
		set_flash_message("Problem deleting event".$errormsg);
		header("Location:". $_SERVER['HTTP_REFERER']);
	}

	exit; 
?>