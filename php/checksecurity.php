<?php
	if (isset($pagetype))
	{
		#1 for pages requiring a user to be logged in,
		#2 for admin only pages,
		if ($pagetype > 0 && !isset($_SESSION['user_id']))
		{
			header("Location: ../html/index.php");
			die();
		}
		else if ($pagetype == 2 && !$_SESSION['user_admin'])
		{
			header("Location: ../html/my_events.php");
			die();	
		}
	}
?>