<?php
	if (isset($pagetype))
	{
		#1 for pages requiring a user to be logged in,
		#2 for admin only pages,
		if (($pagetype > 0 and !isset($_SESSION['user_id'])) or
			($pagetype == 2 and !$_SESSION['user_admin']))
		{
			header("Location: ../html/index.php");
			die();
		}
	}
?>