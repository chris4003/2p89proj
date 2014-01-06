#!/usr/bin/php-cgi
<?php
	session_start();
	include '../php/checksecurity.php';
	include "../php/flash_tools.php"; 
	include '../php/interests.php';


	if ($_SESSION['user_id'] and is_numeric($_SESSION['user_id'])
	and $_GET['InterestID'] and is_numeric($_GET['InterestID']))
	{
        if ($_SESSION['user_admin'])
        {
            $result =  deleteInterest($_GET['InterestID']); 
		 	if ($result == "")
		 	{
	        	set_flash_message("Interest Deleted");
		 	}
	     	else
	     	{
	        	set_flash_message($result);
	     	}
	     	$referer = end(explode("/", $_SERVER['HTTP_REFERER']));
		    if ($referer == "manageinterests.php")
		    {
		        header("Location: ../html/manageinterests.php");        
		    }
		    else
		    {
		        header("Location: ../html/index.php");
		    }
		    exit;
        }
		else
		{
			header("Location: ../html/index.php");
           die();
	    }
	}
	else
	{
		header("Location: ../html/index.php");
        die();
	}
 

?>