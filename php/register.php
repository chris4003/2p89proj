#!/usr/bin/php-cgi
<?php 
	include 'user_tools.php';
	include "../php/flash_tools.php"; 
	if ( strcmp($_POST['password'],$_POST['passcheck']) != 0){
		set_flash_message("Passwords do not match.");
	}
	else {
		$displayname = $_POST['realname'];
		$email = $_POST['email'];
		$name = $_POST['username'];
		$password = $_POST['password'];
	    newUser($name, $password, $displayname, $email);

		$userinfo = validateUser($_POST['username'],$_POST['password']);
		if (!is_null($userinfo))
		{
			$_SESSION['username'] = $userinfo['us_name'];
			$_SESSION['user_id'] = $userinfo['us_id'];
			$_SESSION['user_admin'] = $userinfo['us_admin'];
		}
		set_flash_message("Account created.  You're now logged in.");
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