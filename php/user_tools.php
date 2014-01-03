
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
function newUser($name, $password, $displayname, $email)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	$stmt = $db->prepare('INSERT INTO  Users (us_name, us_password, us_location, us_displayname, us_email, us_admin)
			VALUES (:name, :password, :location, :displayname, :email, :admin)');


	$userloc = $_SERVER["REMOTE_ADDR"];
	$encryptedPassword = crypt($password, $key);
	$admin = "0";

	$stmt->bindParam(':name', $name);
	$stmt->bindParam(':password', $encryptedPassword);
	$stmt->bindParam(':location', $userloc);
	$stmt->bindParam(':displayname', $displayname);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':admin', $admin);

	$db->begintransaction();
	try
	{
		$stmt->execute();	
		$db->commit();
		echo "Insert Successful<br />";
	}
	catch (PDOException $e)
	{
		$db->rollBack();
		echo "Insert fail<br />" . $e->getMessage() . "<br />";	
	}
}

function validateUser ($name,$password){

	global $SERVER, $USERNAME, $PASSWORD, $DATABASE, $key;
	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql = "select * from Users where us_name = '" . $name . "' and us_password = '" . crypt($password,$key) . "'";
	$stmt = $db->query($sql);  
	$stmt->setFetchMode(PDO::FETCH_OBJ);

	while($row = $stmt->fetch()) 
	{  
		return $row->us_id; #LOL FUCKING HACKED IT BRO, EZ
	}
	return 0;
}

?>