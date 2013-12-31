#!/usr/bin/php-cgi
<html>
<head>
<title>PHP Database</title>
</head>
<body>
<?php

include 'globals.php';

$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
#2 vmorsaint vince123
#3 ctbullet chris
#4 Nubzor nub
#5 darminian darm
#setUser("dave", "dave","dave", $db, $key);


listusers(null);

function listUsers($filter)
{
	global $db;

	# creating the statement  
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
	global $db, $key;
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



?>
</body>
</html>