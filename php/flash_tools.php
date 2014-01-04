<?php
if(session_id() == '') {
    session_start();
}
function has_flash_message(){
	return isset($_SESSION['flash_message']);
}
function set_flash_message($message){
	$_SESSION['flash_message'] = $message;
}
function get_flash_message(){
	$message = $_SESSION['flash_message'];
	unset($_SESSION['flash_message']);
	return $message;
}
?>