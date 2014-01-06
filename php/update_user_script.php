#!/usr/bin/php-cgi
<?php
    include '../php/user_tools.php';
    include "../php/flash_tools.php"; 
    if ($_POST) 
    {
        $pUserID = $_POST["userID"];
        $pUserName = $_POST["username"];
        $pDisplayName = $_POST["displayname"];
        $pLocation = $_POST["location"];
        $pEmail = $_POST["email"];
        $pAdmin = $_POST["admin"];

        $result = modifyUser($pUserID, $pUserName, $pDisplayName, $pLocation, $pEmail,$pAdmin);

         if ($result == "")
            set_flash_message("User Updated");
         else
            set_flash_message($result);
      
    }
    
    if ($_POST['referer'] == "manageusers.php")
    {
        header("Location: ../html/manageusers.php");        
    }
    else
    {
        header("Location: ../html/index.php");
    }
    
    exit; #comment this out to view the rest of the stuff for debugging purposes
?>