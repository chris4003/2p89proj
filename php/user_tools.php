
<?php

include 'globals.php';


#2 vmorsaint vince123
#3 ctbullet chris
#4 Nubzor nub
#5 darminian darm
#setUser("dave", "dave","dave", $db, $key);

function deleteUser($nUserID, $nNewOwnerID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();
		
		$stmt = $db->prepare('DELETE FROM Users WHERE us_id = :userID');
		$stmt->bindValue(':userID', $nUserID, PDO::PARAM_INT);
		$stmt->execute();
		
		$stmt = $db->prepare('UPDATE EventHeader set us_id = :adminID
								WHERE us_id = :userID');
		$stmt->bindValue(':userID', $nUserID, PDO::PARAM_INT);
		$stmt->bindValue(':adminID', $nNewOwnerID, PDO::PARAM_INT);
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


function SearchUsers($filter = "")
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;

	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	try
	{
		$sql = 'SELECT us_id, us_name, us_password, us_email, us_location, us_displayname, us_admin from Users';
		if ($filter != "")
		{
			$sql = $sql . 'where ' . $filter;
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

# create a new user by passing needed params
function newUser($sName, $sPassword, $sDisplayname, $sEmail)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	try
	{	
		$stmt = $db->prepare('INSERT INTO  Users (us_name, us_password, us_location, us_displayname, us_email, us_admin)
				VALUES (:name, :password, :location, :displayname, :email, :admin)');


		$sUserloc = $_SERVER["REMOTE_ADDR"];
		$sEncryptedPassword = crypt($sPassword, $key);
		$bAdmin = "0";
		$stmt->bindValue(':name', $sName, PDO::PARAM_STR);
		$stmt->bindValue(':password', $sEncryptedPassword, PDO::PARAM_STR);
		$stmt->bindValue(':location', $sUserloc, PDO::PARAM_STR);
		$stmt->bindValue(':displayname', $sDisplayname, PDO::PARAM_STR);
		$stmt->bindValue(':email', $sEmail, PDO::PARAM_STR);
		$stmt->bindValue(':admin', $bAdmin, PDO::PARAM_BOOL);

		$stmt->execute();	
		return "";
	}
	catch (PDOException $e)
	{
		return "Insert fail<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}


function validateUser ($sName,$sPassword){

	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$stmt = $db->prepare("SELECT us_id, us_name, us_admin from Users where us_name = :name and us_password = :password");  
		$stmt->bindValue(':name', $sName, PDO::PARAM_STR);
		$stmt->bindValue(':password', crypt($sPassword,$key), PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e)
	{
		echo "Validation failed<br />" . $e->getMessage() . "<br />";	
		return null;
	}
	$db = null;
}


function getUserInfo($sUserID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$stmt = $db->prepare("SELECT us_id, us_name, us_location, us_displayname, us_email, us_admin, us_password
							FROM Users WHERE us_id = :userID");  
		$stmt->bindValue(':userID', $sUserID, PDO::PARAM_INT);
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


function modifyUser($sUserID, $sUserName, $sDisplayName, $sLocation, $sEmail, $sAdmin)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$stmt = $db->prepare('UPDATE Users SET us_name = :name, us_displayname = :displayname, 
						 		us_location = :location, us_email = :email, us_admin = :admin 
								WHERE us_id = :userID');

		$stmt->bindValue(':userID', $sUserID, PDO::PARAM_INT);
		$stmt->bindValue(':name', $sUserName, PDO::PARAM_STR);
		$stmt->bindValue(':location', $sLocation, PDO::PARAM_STR);
		$stmt->bindValue(':displayname', $sDisplayName, PDO::PARAM_STR);
		$stmt->bindValue(':email', $sEmail, PDO::PARAM_STR);
		$stmt->bindValue(':admin', $sAdmin, PDO::PARAM_BOOL);

		$stmt->execute();	
		return "";
	}
	catch (Exception $e)
	{
		return "Update User failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}

?>