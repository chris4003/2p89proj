#!/usr/bin/php-cgi
<?php 
	include 'user_tools.php';
	include "../php/flash_tools.php"; 

	if ($_POST){
		$user_id = validateUser($_POST['username'],$_POST['password']);
		if ($user_id){
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['user_id'] = $user_id;
			set_flash_message("Thanks {$_SESSION['username']}, you are now logged in.");
		}
		else {
			set_flash_message("Invalid username or password.");
		}

	}


	header("Location:". $_SERVER['HTTP_REFERER']);
	exit; #comment this out to view the rest of the stuff for debugging purposes
?>
<html>
<head></head>
<body>
<?php 
	echo "post";
	var_dump($_POST);
	echo "session";
	var_dump($_SESSION);
?>
</body>
</html>