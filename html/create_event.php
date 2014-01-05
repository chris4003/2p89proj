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

               <fieldset>
      <legend>
         New Event:
      </legend>
      <form action="../php/create_event_script.php" method="post" onsubmit="return validateCreateEvent(this);"  enctype="multipart/form-data" >
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
