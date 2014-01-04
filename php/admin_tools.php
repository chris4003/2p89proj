<?php

	include 'globals.php';

	function listMessages()
	{
		global $SERVER, $USERNAME, $PASSWORD, $DATABASE;

		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		try
		{
			$stmt = $db->prepare('SELECT ac_id, ac_name, ac_email, ac_subject, ac_message, ac_datetime 
								  FROM AdminContact ORDER BY ac_datetime DESC');
			$stmt->execute();	
			$return = $stmt->fetchAll();
		}
		catch (PDOException $e)
		{
			$return = null;
			$err = "List Messages fail:" . $e->getMessage();	
			file_put_contents("../assets/err.log", $err, FILE_APPEND);
		}
		$db=null;
		return $return;

	}
?>