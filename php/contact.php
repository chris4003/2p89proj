<?php

include 'globals.php';
function createMessage($sName,$sEmail,$sSubject,$sMessage)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();

		$stmt = $db->prepare('INSERT INTO AdminContact(ac_name, ac_email, ac_subject, ac_message) VALUES (:name, :email, :subject, :message)');
		$stmt->bindValue(':name', $sName, PDO::PARAM_STR);
		$stmt->bindValue(':email', $sEmail, PDO::PARAM_STR);
		$stmt->bindValue(':subject', $sSubject, PDO::PARAM_STR);
		$stmt->bindValue(':message', $sMessage, PDO::PARAM_STR);

		$stmt->execute();
		$db->commit();
		return "";
	}
	catch (Exception $e)
	{
		$db->rollBack();
		return "Transaction failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}
?>