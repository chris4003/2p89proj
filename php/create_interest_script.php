#!/usr/bin/php-cgi
<?php
    include '../php/interests.php';
    include "../php/flash_tools.php"; 
    if ($_POST) 
    {
        
        $pDescription = $_POST["description"];
        $pParentID = $_POST["parentid"];


        $result = newInterest($pDescription, $pParentID);
         
        if ($result == "")
        {
            set_flash_message("Imterest created");
        }
         else
        {
            set_flash_message($result);
        }
      
    }
    if ($_POST['referer'] == "manageinterests.php")
    {
        header("Location: ../html/manageinterests.php");        
    }
    else
    {
        header("Location: ../html/index.php");
    }
    exit; #comment this out to view the rest of the stuff for debugging purposes
?>