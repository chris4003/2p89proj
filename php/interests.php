<?php

include 'globals.php';

function deleteInterest($nTagID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();
		
		$stmt = $db->prepare('DELETE FROM EventInterests WHERE in_id = :tagID');
		$stmt->bindValue(':tagID', $nTagID, PDO::PARAM_INT);
		$stmt->execute();

		$stmt = $db->prepare('DELETE FROM Interests WHERE in_id = :tagID');
		$stmt->bindValue(':tagID', $nTagID, PDO::PARAM_INT);
		$stmt->execute();

		$db->commit();
		$return = "";
	}
	catch (Exception $e)
	{
		$db->rollBack();
		$return = "Delete failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
	return $return;
}


function SearchInterests($filter = "")
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;

	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	try
	{
		$sql = 'SELECT in_id, in_description, in_id_parent FROM Interests';
		if ($filter != "")
		{
			$sql = $sql . ' WHERE ' . $filter;
		}
		$stmt = $db->query($sql);  
		$return = $stmt->FetchAll();  
	}
	catch (PDOException $e)
	{ 
		$return = mull;
	}
	$db = null;
	return $return;
}

function modifyInterest($sTagID, $sDescription, $sParentID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$stmt = $db->prepare('UPDATE Interests SET in_description = :description, in_id_parent = :parentID 
								WHERE in_id = :tagID');

		$stmt->bindValue(':tagID', $sTagID, PDO::PARAM_INT);
		$stmt->bindValue(':description', $sDescription, PDO::PARAM_STR);
		$stmt->bindValue(':parentID', $sParentID, PDO::PARAM_INT);

		$stmt->execute();	
		return "";
	}
	catch (Exception $e)
	{
		return "Update Interest failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}

function newInterest($sDescription, $sParentID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	try
	{	
		$stmt = $db->prepare('INSERT INTO  Interests (in_description, in_id_parent)
				VALUES (:description, :parentID)');

		$stmt->bindValue(':description', $sDescription, PDO::PARAM_STR);
		$stmt->bindValue(':parentID', $sParentID, PDO::PARAM_INT);

		$stmt->execute();	
		return "";
	}
	catch (PDOException $e)
	{
		return "Insert fail<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}




function getInterestsOptions($sSelectedID = "")
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
		$result = "<option value='0'" . ($sSelectedID=="0"?" selected":"") . "></option>";
		while($row = $stmt->fetch())
		{
			$result .= "<option value='" . $row->in_id ."'" . ($row->in_id == $sSelectedID?" selected":"") . ">" . $row->in_description ."</option>";
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

function getInterestInfo($sTagID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$stmt = $db->prepare("SELECT in_id, in_description, in_id_parent FROM Interests
							WHERE in_id = :TagID");  
		$stmt->bindValue(':TagID', $sTagID, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC); 
	}
	catch (PDOException $e)
	{
		echo "Get info failed<br />" . $e->getMessage() . "<br />";	
		return null;
	}
	$db = null;
}