#!/usr/bin/php-cgi
<?php 
	include "../php/flash_tools.php"; 
	unset($_SESSION['username'],$_SESSION['user_id']);
	set_flash_message("You are now logged out.");
	header("Location:". $_SERVER['HTTP_REFERER']);#go back
	exit;
?>