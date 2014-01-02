#!/usr/bin/php-cgi
   
   <?php 
      include 'html_head.html'; 
      ?>
      <title>Create Event</title>
      <script src="../assets/javascripts/toggle_count.js"></script>
   </head>

   <body>

      
      <?php 
      include 'header.html'; 
      ?>
      <div id="main">

      <?php include 'nav_bar.html'; ?>
         <div id="page_content">
            <div id="content_mid">
               <?php
                  include '../php/event.php';
                  if ($_POST) {
                     $pTitle = $_POST["title"];
                     $pDescription = $_POST["description"];
                     $pAddress = $_POST["address"];
                     $pEventStart = $_POST["eventstart"];
                     $pEventEnd = $_POST["eventend"];
                     $pCycle = $_POST["cycle"];
                     $pCount = $_POST["count"];
                     $sOwner = "2"; #fix, need to get actual userid from session
                     buildEvent($pTitle, $pDescription,$pAddress, $pEventStart, $pEventEnd, $pCycle, $pCount, $sOwner);
                     
                     echo "Event created";
                  }
               ?>
      <p>
         New Event:
      </p>

      <form action = "create_event.php" method = "post">
         <br />
         <div class="labelOrder">
            <label for="title">Title:</label> <input type="text" id = "title" name = "title"/><br />
            <label for="description">Description:</label> <textarea id = "description" name = "description" cols="40" rows="5"></textarea><br />
            <label for="address">Address:</label> <input type="text" id = "address" name = "address"/><br />
            <label for="eventstart">Start:</label> <input type="datetime-local" id = "eventstart" name = "eventstart"/><br />
            <label for="eventend">End:</label> <input type="datetime-local" id = "eventend" name = "eventend"/><br />   

            <label for="cycle">Occurence:</label> 
            <select id ="cycle" name ="cycle" onChange="toggleCount()">
               <option value="0">One-Time</option>
               <option value="1">Weekly</option>
               <option value="2">Bi-Weekly</option>
               <option value="3">Montly</option>
               <option value="4">Yearly</option>
            </select><br />
            <div id="count_box"><label for="count">Count:</label> <input type="text" id="count" name="count"/><br />   </div>
            <label for="tags">Tags:</label><input type="text" id = "tags" name = "tags"/><a href="javascript:clearTags()">Clear</a><br />
                        <input type="hidden" id = "tagids" name = "tagids"/>
                        <select id="tag_select" onChange="tagPicked()">
                           <?php
                              include '../php/interests.php';
                              getInterestsOptions();
                           ?>
                        </select>
                        <br />
            <input type="submit">
         </div>
      </form>

   </div></div></div>
      <?php 
         include 'footer.html'; 
      ?>
   </body>
</html>
