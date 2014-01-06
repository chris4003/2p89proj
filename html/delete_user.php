#!/usr/bin/php-cgi
<?php
	session_start();
	include "../php/flash_tools.php"; 
	include '../php/user_tools.php';


	if ($_SESSION['user_id'] and is_numeric($_SESSION['user_id'])
	and $_GET['UserID'] and is_numeric($_GET['UserID']))
	{
        if ($_SESSION['user_admin'])
        {
            $result =  deleteUser($_GET['UserID'], $_SESSION['user_id']); 
		 	if ($result == "")
		 	{
	        	set_flash_message("User Deleted");
		 	}
	     	else
	     	{
	        	set_flash_message($result);
	     	}
	     	$referer = end(explode("/", $_SERVER['HTTP_REFERER']));
		    if ($referer == "manageusers.php")
		    {
		        header("Location: ../html/" . $referer);        
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