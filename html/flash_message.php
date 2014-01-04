<?php include "../php/flash_tools.php"; 
if (has_flash_message()){
	echo "<div id='flash_message'>";
	echo get_flash_message();	
	echo "</div>";
}
?>