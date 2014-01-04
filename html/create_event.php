#!/usr/bin/php-cgi
   
   <?php 
      include 'html_head.html'; 
      ?>
      <title>Create Event</title>
      <script src="../assets/javascripts/toggle_count.js"></script>
      <script src="../assets/javascripts/validation.js"></script>
   </head>

   <body>

      <div id="main">
      <?php include 'header.html'; ?>

      <?php include 'nav_bar.html'; ?>
         <div id="page_content">
            <div id="content_mid">
               <?php include "../html/flash_message.php"; ?>
               <?php
                  include '../php/event.php';
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
                        $pEventStart = $_POST["eventstart"] . $_POST["eventstarttime"];     
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
                        $pEventEnd = $_POST["eventend"] . $_POST["eventendtime"];     
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

                     $uploaddir = '../assets/images/uploaded/';
                     $new_image_name = $_SESSION['user_id']."_".$_FILES["userfile"]["name"];
                     $uploadfile = $uploaddir.$new_image_name;

                     $printstuff = buildEvent($pTitle, $pDescription,$pAddress,$pCity, $pEventStart, $pEventEnd, $pCycle, $pCount, $_SESSION['user_id'],$pTags,$new_image_name);


                     if ($_FILES['userfile']['error'] === UPLOAD_ERR_OK){
                        #nifty
                     }
                     else {
                         #$error_message = file_upload_error_message($_FILES['userfile']['error']);
                         print "Error uploading the image"."<br />";
                     }
                     if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $uploadfile)) {
                         #print "File is valid, and was successfully uploaded. ";
                         #print "Here's some more info about the upload:\n";
                         #print_r($_FILES);
                         #chmod($uploadfile,0755); #chmod denied
                     } else {
                         print "File upload problem! Here's some debugging info:\n";
                         print_r($_FILES);
                     }

                     include "../php/flash_tools.php"; 

                     if ($printstuff == "")
                        set_flash_message("Event created");
                     else
                        set_flash_message($printstuff);
                  
                  }
               ?>
               <fieldset>
      <legend>
         New Event:
      </legend>
      <form action="create_event.php" method="post" onsubmit="return validateCreateEvent(this);"  enctype="multipart/form-data" >
         <br />
         <div class="labelOrder">
            <label for="title">Title:</label> <input type="text" id = "title" name = "title"/><br />
            <label for="description">Description:</label> <textarea id = "description" name = "description" cols="40" rows="5"></textarea><br />
            <label for="address">Address:</label> <input type="text" id = "address" name = "address"/><br />
            <label for="city">City:</label> <input type="text" id = "city" name = "city"/><br />
            <label for="eventstart">Start:</label> <input type="text" id = "eventstart" name = "eventstart"/><input type="text" id = "eventstarttime" name = "eventstarttime" value="00:00" /><select id="startampm" name="startampm"><option value="AM">AM</option><option value="PM">PM</option></select><br />
            <label for="eventend">End:</label> <input type="text" id = "eventend" name = "eventend"/><input type="text" id = "eventendtime" name = "eventendtime" value="00:00" /><select id="endampm" name="endampm"><option value="AM">AM</option><option value="PM">PM</option></select><br />   
            <script>
               $( "#eventstart" ).datepicker();
               $( "#eventend" ).datepicker();
            </script>
            <label for="cycle">Occurence:</label> 
            <select id ="cycle" name ="cycle" onChange="toggleCount()">
               <option value="0">One-Time</option>
               <option value="1">Weekly</option>
               <option value="2">Bi-Weekly</option>
               <option value="3">Montly</option>
               <option value="4">Yearly</option>
            </select><br />
            <div id="count_box">
               <label for="count">Count:</label> 
               <input type="text" id="count" name="count"/><br />  
            </div>
            <input type="hidden" name="MAX_FILE_SIZE" value="50000">
            <label>Upload Image:</label> <input name="userfile" type="file"><small>Note: Image sizes are limited to 50kb</small><br />
            <label>Tags:</label>
                        <select id="tag_select" onChange="tagPicked()">
                           <?php
                              include '../php/interests.php';
                              getInterestsOptions();
                           ?>
                        </select>
                        <input type="text" id = "tags" name = "tags" readonly/>
                        <a href="javascript:clearTags()">Clear</a>
                        <input type="hidden" id = "tagids" name = "tagids"/>
                        <br />
            <input type="submit">
         </div>
      </form>
   </fieldset>
      
   </div>

            <div style="clear:both;"></div>
</div>
<?php include 'footer.html'; ?>
</div> <!-- main -->
   </body>
</html>
