<?php

include 'globals.php';

function getInterestsOptions()
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$stmt = $db->query('SELECT in_id, in_description
							   FROM Interests
							   ORDER BY in_id_parent, in_id');
		$stmt->setFetchMode(PDO::FETCH_OBJ);  
		# building the results  
		$result = "<option value='0'></option>";
		while($row = $stmt->fetch())
		{
			$result .= "<option value='" . $row->in_id ."'>" . $row->in_description ."</option>";
		}
		echo $result;
		return "";
	}
	catch (Exception $e)
	{
		 return "Search failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;

}