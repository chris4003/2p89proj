#!/usr/bin/php-cgi
<?php
  include '../php/event.php';
    include "../php/flash_tools.php"; 
    if ($_POST) 
    {
        $pEventID = $_POST["eventID"];
        $pDateID = $_POST["dateID"];
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
                $pEventEnd = $_POST["eventend"] . $_POST["eventendtime"] . ":00:00";         
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
        $pTagIDs  = $_POST['tagids'];
        $pUserID = $_POST['userID'];

        if ($_FILES["userfile"]["name"])
        {
           $uploaddir = '../assets/images/uploaded/';
           $extension = end(explode(".", $_FILES["userfile"]["name"]));
           $new_image_name = $pEventID . "." . $extension;
           $uploadfilepath = $uploaddir . $new_image_name;
           if ($_POST['currentImage'] != "")
           {
            unlink($_POST['currentImage']); 
           }
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
        else if($_POST['deleteimage'] && $_POST['currentImage'] != "")
        {
            unlink($_POST['currentImage']);
            $new_image_name = "";
        }
         

         $resultH = modifyEventHead($pEventID, $pTitle, $pDescription, $pAddress, $pCity, $pUserID, $pTagIDs, $new_image_name);
         $resultD = modifyEventDate($pDateID, $pEventStart, $pEventEnd);

         if ($resultH == "" and $resultD == "")
            set_flash_message("Event Updated");
         else
            set_flash_message($resultH . $resultD);
      
    }
    
    if ($_POST['referer'] == "manageevents.php" or $_POST['referer'] == "my_events.php")
    {
        header("Location: ../html/" . $_POST['referer']);        
    }
    else
    {
        header("Location: ../html/index.php");
    }
    
    exit; #comment this out to view the rest of the stuff for debugging purposes
?>