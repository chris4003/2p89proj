#!/usr/bin/php-cgi
<!--eg1.php-->
<!DOCTYPE html>
<html>
  <head>
    <title>A Sample Page from PHP</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />  
  </head>
<body>
<?php 
   print "<h1>Hello World!</h1>";
   print "<p>Isn't programming fun!</p>";
?>
<h2>Some more html</h2>
<?php 
   print "<p>Here is ";
   print "some more";
   print " text</p>";
?>
</body>
</html>