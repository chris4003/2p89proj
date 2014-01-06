#!/usr/bin/php-cgi
<?php
	session_start();
	include '../php/checksecurity.php';
	include "../php/flash_tools.php"; 
	include '../php/event.php';



 
	if (isset($_GET['eh_id']) && is_numeric($_GET['eh_id']))
	{
	  	$headerID = $_GET['eh_id'];
	  	$aEvent = getEventHead($headerID);
	    if (!is_null($aEvent))
    	{
	        #if check for ownership if not admin
	        if (!$_SESSION['user_admin'] && $_SESSION['user_id'] != $aEvent['us_id'])
	        {
	           header("Location: ../html/index.php");
	           die();
	        }
			else
			{
				$result =  deleteEvent($headerID); 
			 	if ($result == "")
			 	{
		        	set_flash_message("Event Deleted");
			 	}
		     	else
		     	{
		        	set_flash_message($result);
		     	}
		    }
	    }
	}
	else if (isset($_GET['ed_id']) && is_numeric($_GET['ed_id']))
	{
	  	$dateID = $_GET['ed_id'];

  	    $aEvent = findEventByDateID($dateID);
	    if (!is_null($aEvent))
    	{
	        #if check for ownership if not admin
	        if (!$_SESSION['user_admin'] && $_SESSION['user_id'] != $aEvent['us_id'])
	        {
	           header("Location: ../html/index.php");
	           die();
	        }
	        else
	        {
			    $result =  deleteEventDate($dateID); 
			 	if ($result == "")
		 		{
		        	set_flash_message("Date Deleted");
		    	}
			    else
			    {
			        set_flash_message($result);	
			    }
	        }
	    }
	}
	$referer = end(explode("/", $_SERVER['HTTP_REFERER']));

    if ($referer == "manageevents.php" or $referer == "my_events.php")
    {
        header("Location: ../html/" . $referer);        
    }
    else
    {
        header("Location: ../html/index.php");
    }
    exit;

?>