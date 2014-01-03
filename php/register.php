#!/usr/bin/php-cgi
<?php 
	include 'user_tools.php';
	if ( strcmp($_POST['password'],$_POST['passcheck']) != 0){
		#password check failed
	}

	$displayname = $_POST['username'];
	$email = $_POST['email'];
	$name = $_POST['realname'];
	$password = $_POST['password'];
    newUser($name, $password, $displayname, $email);



	session_start();
	$user_id = validateUser($_POST['username'],$_POST['password']);
	if ($user_id){
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['user_id'] = $user_id;
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