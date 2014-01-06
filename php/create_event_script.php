#!/usr/bin/php-cgi
<?php
  include '../php/event.php';
    include "../php/flash_tools.php"; 
  if ($_POST) {
     $pTitle = $_POST["title"];
     $pDescription = $_POST["description"];
     $pAddress = $_POST["address"];
     $pCity = $_POST["city"];
     if ($_POST["eventstarttime"] == "")
     {
        $pEventStart = $_POST["eventstart"] . "00:00:00";
     }
     else
     {  
        if (is_numeric($_POST['eventstarttime']))
        {
            $pEventStart = $_POST["eventstart"] . $_POST["eventstarttime"] . ":00:00";         
        }
        else
        {
            $pEventStart = $_POST["eventstart"] . $_POST["eventstarttime"];
        }
        if ($_POST["startampm"] == "PM")
        {
           $pEventStart = date("m/d/y H:i:s", strtotime($pEventStart) + (12*3600));       
        }
        else
        {
           $pEventStart = date("m/d/y H:i:s", strtotime($pEventStart));
        }
        
     }

     if ($_POST["eventendtime"] == "")
     {
        $pEventEnd = $_POST["eventend"] . "00:00:00";   
     }
     else
     {
        if (is_numeric($_POST['eventendtime']))
        {
            $pEventStart = $_POST["eventend"] . $_POST["eventendtime"] . ":00:00";         
        }
        else
        {
            $pEventEnd = $_POST["eventend"] . $_POST["eventendtime"];
        }
        if ($_POST["endampm"] == "PM")
        {
           $pEventEnd = date("m/d/y H:i:s", strtotime($pEventEnd) + (12*3600));
        }
        else
        {
           $pEventEnd = date("m/d/y H:i:s", strtotime($pEventEnd));
        }
        
     }
     $pCycle = $_POST["cycle"];
     $pCount = $_POST["count"];
     $pTags  = $_POST['tagids'];

     if ($_FILES["userfile"]["name"])
     {
        $uploaddir = '../assets/images/uploaded/';
         $new_image_name = $_SESSION['user_id']."_".$_FILES["userfile"]["name"];
         $uploadfilepath = $uploaddir.$new_image_name;
        if ($_FILES['userfile']['error'] === UPLOAD_ERR_OK){
           if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $uploadfilepath)) {
            #print "File is valid, and was successfully uploaded. ";
            #chmod($uploadfile,0755); #chmod denied
           } else {
               print "File upload problem! Here's some debugging info:\n";
               print_r($_FILES);
           }
        }
        else {
            #$error_message = file_upload_error_message($_FILES['userfile']['error']);
            print "Error uploading the image"."<br />";
        }
     }
     else
     {
        $new_image_name = "";
     }

     $printstuff = buildEvent($pTitle, $pDescription,$pAddress,$pCity, $pEventStart, $pEventEnd, $pCycle, $pCount, $_SESSION['user_id'],$pTags,$new_image_name);
     
     if ($printstuff == "")
        set_flash_message("Event created");
     else
        set_flash_message($printstuff);
  
  }

    header("Location:". $_SERVER['HTTP_REFERER']);
    exit; #comment this out to view the rest of the stuff for debugging purposes
?>