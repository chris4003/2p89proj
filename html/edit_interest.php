#!/usr/bin/php-cgi
   
   <?php 
      $pagetype = 2;
      include '../html/html_head.html'; 
      include '../php/globals.php';
      if (isset($_GET['InterestID']) && is_numeric($_GET['InterestID']))
      {
         include_once '../php/interests.php';
         $tagID = $_GET['InterestID'];
         $aInterest = getInterestInfo($tagID);
         if (!is_null($aInterest))
         {
            if (!$_SESSION['user_admin'])
            {
               header("Location: ../html/index.php");
               die();
            } 
            else
            {
               $description = $aInterest['in_description'];
               $parentID = $aInterest['in_id_parent'];

               $referer = end(explode("/", $_SERVER['HTTP_REFERER']));
            }
         }
      }
      else
      {
         header("Location: ../html/manageinterests.php");
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
         Edit Interest:
      </legend>
      <form action="../php/update_interest_script.php" method="post" onsubmit="return validateEditInterest(this);"  enctype="multipart/form-data" >
         <br />
         <div class="labelOrder">
            <label for="tagid">Interest ID:</label><input type="text" name="tagid" value="<?php echo $tagID;?>" readonly style="background-color:#e0e0e0;border:1px solid grey;"><br />
            <input type="hidden" name="referer" value="<?php echo $referer;?>">
            <label for="description">Description*:</label> <input type="text" id = "description" name = "description" value="<?php echo $description;?>"/><br />
            <label for="parentid">Parent ID*:</label> 
            <select id="parentid" name="parentid">
            <?php
               getInterestsOptions($parentID);
            ?>
            </select>
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
