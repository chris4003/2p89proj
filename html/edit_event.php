#!/usr/bin/php-cgi
   
   <?php 
      $pagetype = 1;
      include '../html/html_head.html'; 
      if (isset($_GET['ed_id']) && is_numeric($_GET['ed_id']))
       {
         include '../php/event.php';
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
               include '../php/interests.php';
               $eventID = $aEvent['eh_id'];
               $title = $aEvent['eh_title'];
               $description = $aEvent['eh_description'];
               $address = $aEvent['eh_address'];
               $city = $aEvent['eh_city'];
               $dtStart = date_create($aEvent['ed_start']);
               $dtEnd = date_create($aEvent['ed_end']);
               $startDate = date_format($dtStart,"m/d/Y");
               $startTime = date_format($dtStart,"h:i");
               $startAP = date_format($dtStart,"A");
               $endDate = date_format($dtEnd,"m/d/Y");
               $endTime = date_format($dtEnd,"h:i");
               $endAP = date_format($dtEnd,"A");
               $imagefile = $aEvent['eh_image_name'];
               $tagIDs = $aEvent['tagIDs'];
               $tags = $aEvent['tags'];
               $Owner = $aEvent['us_id'];
               $referer = end(explode("/", $_SERVER['HTTP_REFERER']));
            }
         }
       }
       else
       {
         header("Location: ../html/manageevents.php");
         die();
       }
      ?>
      <title>Edit Event</title>
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

               <fieldset>
      <legend>
         Edit Event:
      </legend>
      <form action="../php/update_event_script.php" method="post" onsubmit="return validateEditEvent(this);"  enctype="multipart/form-data" >
         <br />
         <div class="labelOrder">
            <?php

            if ($_SESSION['user_admin'] && $referer == "manageevents.php")
            {
               echo "<label for='eventID'>EventID:</label><input id='eventID' type='text' name='eventID' value=" . $eventID . 
               " readonly style='background-color:#e0e0e0;border:1px solid grey;' /><br />";
               echo "<label for='dateID'>DateID:</label><input id='dateID 'type='text' name='dateID' value=" . $dateID . 
               " readonly style='background-color:#e0e0e0;border:1px solid grey;'/><br />";
            }
            else
            {
               echo "<input type='hidden' name='eventID' value=" . $eventID . ">";
               echo "<input type='hidden' name='dateID' value=" . $dateID . ">";
            }
            ?>

            <input type="hidden" name="referer" value="<?php echo $referer;?>">
            <label for="title">Title*:</label> <input type="text" id = "title" name = "title" value="<?php echo $title;?>"/><br />
            <label for="description">Description:</label> <textarea id = "description" name = "description" cols="40" rows="5"><?php echo $description ?></textarea><br />
            <label for="address">Address*:</label> <input type="text" id = "address" name = "address" value="<?php echo $address ?>"/><br />
            <label for="city">City*:</label> <input type="text" id = "city" name = "city" value="<?php echo $city ?>"/><br />

            <label for="eventstart">Start*:</label> <input type="text" id = "eventstart" name = "eventstart"  value="<?php echo $startDate ?>"/>
            <input type="text" id = "eventstarttime" name = "eventstarttime" value="<?php echo $startTime ?>" />
            <select id="startampm" name="startampm"><option value="AM">AM</option><option value="PM" <?php echo ($startAP == 'PM')?'selected':''; ?>>PM</option></select><br />

            <label for="eventend">End*:</label> <input type="text" id = "eventend" name = "eventend" value="<?php echo $endDate ?>"/>
            <input type="text" id = "eventendtime" name = "eventendtime" value="<?php echo $endTime ?>" />
            <select id="endampm" name="endampm"><option value="AM">AM</option><option value="PM" <?php echo ($endAP == 'PM')?'selected':''; ?>>PM</option></select><br />   
            
            <script>
               $( "#eventstart" ).datepicker();
               $( "#eventend" ).datepicker();
            </script>

            <input type="hidden" name="MAX_FILE_SIZE" value="50000">
            <?php
            
            echo "<input type='hidden' id='currentImage' name='currentImage' value=' " . $imagefile . "' />";
            if($imagefile != "")
            {
                echo "<label>Current Image:</label><img class='thumbnail' src='../assets/images/uploaded/" . $imagefile . "' />" .
                "<input type='checkbox' name='deleteimage' id='deleteimage' value='true'>Delete Image<br />" .
                "<label>Change Image:</label>";

            }
            else
            {
               echo "<label>Add Image:</label>";
            }

            ?>

            <input name="userfile" type="file"><small>Note: Image sizes are limited to 50kb</small><br />
            <label>Tags*:</label>
            <select id="tag_select" onChange="tagPicked()">
               <?php
                  getInterestsOptions();
               ?>
            </select>
            <input type="text" id = "tags" name = "tags" value="<?php echo $tags ?>" readonly/>
            <a href="javascript:clearTags()">Clear</a>
            <input type="hidden" id = "tagids" name = "tagids" value="<?php echo $tagIDs ?>"/>
            <br />
            <?php

               if ($_SESSION['user_admin'] && $referer == "manageevents.php")
               {
                  echo "<label for='userID'>Owner*:</label><input id='userID' name='userID' type='text' value='" . $Owner ."'/><br />";
               }
               else
               {
                  echo "<input id='userID' name='userID' type='hidden' value='" . $Owner ."'/>";
               }
            ?>
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
