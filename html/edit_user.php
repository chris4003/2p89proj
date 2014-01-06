#!/usr/bin/php-cgi
   
   <?php 
      $pagetype = 2;
      include '../html/html_head.html'; 
      if (isset($_GET['UserID']) && is_numeric($_GET['UserID']))
      {
         include_once '../php/user_tools.php';
         $userID = $_GET['UserID'];
         $aUser = getUserInfo($userID);
         if (!is_null($aUser))
         {
            if (!$_SESSION['user_admin'])
            {
               header("Location: ../html/index.php");
               die();
            } 
            else
            {
               $username = $aUser['us_name'];
               $displayname = $aUser['us_displayname'];
               $location = $aUser['us_location'];
               $email = $aUser['us_email'];
               $admin = $aUser['us_admin'];

               $referer = end(explode("/", $_SERVER['HTTP_REFERER']));
            }
         }
      }
      else
      {
         header("Location: ../html/manageusers.php");
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
         Edit User:
      </legend>
      <form action="../php/update_user_script.php" method="post" onsubmit="return validateEditUser(this);"  enctype="multipart/form-data" >
         <br />
         <div class="labelOrder">
            <label for="userID">User ID:</label><input type="text" name="userID" value="<?php echo $userID;?>" readonly style="background-color:#e0e0e0;border:1px solid grey;"><br />
            <input type="hidden" name="referer" value="<?php echo $referer;?>">
            <label for="username">Username*:</label> <input type="text" id = "username" name = "username" value="<?php echo $username;?>"/><br />
            <label for="displayname">Display Name*:</label> <input type="text" id = "displayname" name = "displayname" value="<?php echo $displayname;?>"/><br />
            <label for="location">Location*:</label> <input type="text" id = "location" name = "location" value="<?php echo $location ?>"/><br />
            <label for="email">Email*:</label> <input type="text" id = "email" name = "email" value="<?php echo $email ?>"/><br />
            <label for="admin">Admin:</label> <input type="checkbox" id = "admin" name = "admin" value = "1" <?php echo ($admin == '1'?'checked':'') ?>/><br />
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
