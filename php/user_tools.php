
<?php

include 'globals.php';


#2 vmorsaint vince123
#3 ctbullet chris
#4 Nubzor nub
#5 darminian darm
#setUser("dave", "dave","dave", $db, $key);



function listUsers($filter)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;

	# creating the statement  
	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql = 'SELECT us_name, us_password, us_displayname from Users';
	if (!is_null($filter))
	{
		$sql = $sql . 'where ' . $filter;
	}
	

	$stmt = $db->query($sql);  
	  
	# setting the fetch mode  
	$stmt->setFetchMode(PDO::FETCH_OBJ);  
	
	echo "User list:<br />";

	# showing the results  
	while($row = $stmt->fetch()) 
	{  
	    echo $row->us_name . " ";  
	    echo $row->us_password . " ";
	    echo $row->us_displayname . " ";
	    echo "<br />";
	}
}

# create a new user by passing needed params
function newUser($sName, $sPassword, $sDisplayname, $sEmail)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	try
	{	
		$db->begintransaction();
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
		$db->commit();
		return "";
	}
	catch (PDOException $e)
	{
		$db->rollBack();
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

		$stmt = $db->prepare("select us_id from Users where us_name = :name and us_password = :password");  
		$stmt->bindValue(':name', $sName, PDO::PARAM_STR);
		$stmt->bindValue(':password', crypt($sPassword,$key), PDO::PARAM_STR);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_OBJ);

		while($row = $stmt->fetch()) 
		{  
			return $row->us_id; #LOL FUCKING HACKED IT BRO, EZ
		}
	}
	catch (PDOException $e)
	{
		echo "Validation failed<br />" . $e->getMessage() . "<br />";	
	}
	return 0;
	$db = null;
}


function getUserInfo($sID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$stmt = $db->prepare("select us_id, us_name, us_location, us_displayname, us_email, us_admin
							from Users where us_id = :ID");  
		$stmt->bindValue(':ID', $sID, PDO::PARAM_INT);
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
?>