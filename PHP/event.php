<?php

include 'globals.php';

function deleteEvent($nHeaderID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();

		$stmt = $db->prepare('DELETE FROM EventDates WHERE eh_id = :headerID');
		$stmt = $db->prepare('DELETE FROM EventHeader WHERE eh_id = :headerID');
		$stmt->bindParam(':headerID', $nHeaderID);
		$stmt->execute();
		$db->commit();
		echo "Delete Successful<br />";
	}
	catch (Exception $e)
	{
		$db->rollBack();
		echo "Delete failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}
function deleteEventDate($nDateID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();

		$stmt = $db->prepare('DELETE FROM EventDates WHERE ed_id = :dateID');
		$stmt->bindParam(':dateID', $nDateID);
		$stmt->execute();
		$db->commit();
		echo "Delete Successful<br />";
	}
	catch (Exception $e)
	{
		$db->rollBack();
		echo "Delete failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}

function getEventHead($nHeaderID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();
		$stmt = $db->prepare('SELECT eh_id, eh_title, eh_description, eh_rating, us_id from EventHeader
							   WHERE eh_id = :headerID');

		$stmt->bindParam(':headerID', $nHeaderID);
		$stmt->execute();
	
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

	}
	catch (Exception $e)
	{
		echo "Select failed<br />" . $e->getMessage() . "<br />";	
		$result = null;
	}
	$db = null;
	return $result;
}
#search for events using an array parameters. currently only supports an array of interests(including any event that match any of those interests)
#returns array if successful, returns null if error. 
function SearchEvent($sTitle = "", $sDescription = "", $sAddress = "", $sStart = "", $sEnd = "", $sInterests = "")
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();

		$sFields = "SELECT EventHeader.eh_id, eh_title, eh_description, eh_address, ed_start, ed_end, eh_rating 
							   FROM EventHeader inner join EventDates on EventHeader.eh_id = EventDates.eh_id
							   WHERE ";
		
		if ($sTitle == "" && $sDescription == "" && $sAddress == "" && $sStart == "" && $sEnd == "" && $sInterests == "")
		{
			$sWhere = "1";
		}
		else
		{	
			$sWhere = "";
			if ($sTitle != "")
			{
				$sWhere = "eh_title LIKE '%" . $sTitle . "%'";
			}
			if ($sDescription != "")
			{	
				$sWhere .= ($sWhere==""?"":" AND ") . "eh_description LIKE '%" . $sDescription . "%'";
			}
			if ($sAddress != "")
			{
				$sWhere .= ($sWhere==""?"":" AND ") . "eh_address LIKE '%" . $sAddress . "%'";
			}
			if ($sStart != "")
			{
				$sWhere .= ($sWhere==""?"":" AND ") . "ed_start >= '" . date("Y-m-d H:i:s", strtotime($sStart)) . "'";
			}
			if ($sEnd != "")
			{
				$sWhere .= ($sWhere==""?"":" AND ") . "ed_end <= '" . date("Y-m-d H:i:s", strtotime($sEnd)) . "'";
			}
			if ($sInterests != "")
			{
				$sWhere .= ($sWhere==""?"":" AND ") . 
					"EventHeader.eh_id IN (SELECT DISTINCT eh_id from EventInterests where in_id IN(" . $sInterests . "))";
			}
		}
		$stmt = $db->prepare($sFields . $sWhere);
		$stmt->execute();
		$result = $stmt->fetchall();
	}
	catch (Exception $e)
	{
		echo "Search failed<br />" . $e->getMessage() . "<br />";	
		$result = null;
	}
	$db = null;
	return $result;
}


function modifyEventHead($nHeaderID, $sTitle, $sDescription, $sOwner)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();
		$stmt = $db->prepare('UPDATE EventHeader (eh_title, eh_description, us_id)
				VALUES (:title, :description, :owner) WHERE eh_id = :headerID');

		$stmt->bindParam(':headerID', $nHeaderID);
		$stmt->bindParam(':title', $sTitle);
		$stmt->bindParam(':description', $sDescription);
		$stmt->bindParam(':owner', $sOwner);
		$stmt->execute();
	

		$db->commit();
		echo "Insert Successful<br />";
	}
	catch (Exception $e)
	{
		$db->rollBack();
		echo "Insert fail<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}

function buildEvent($sTitle, $sDescription,$sAddress, $sStart, $sEnd, $nCycle, $nCount, $sOwner)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;

	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();
		$stmt = $db->prepare('INSERT INTO  EventHeader (eh_title, eh_description, eh_address, us_id)
				VALUES (:title, :description, :address, :owner); SET @parenteh_ID = LAST_INSERT_ID();');

		$stmt->bindParam(':title', $sTitle);
		$stmt->bindParam(':description', $sDescription);
		$stmt->bindParam(':address', $sAddress);
		$stmt->bindParam(':owner', $sOwner);


		$stmt->execute();	


		$stmt = $db->prepare('INSERT INTO  EventDates (eh_id, ed_start, ed_end)
		VALUES (@parenteh_ID, :start, :end)');

		$dtStart = new DateTime($sStart);
		$dtEnd = new DateTime($sEnd);

		$stmt->bindParam(':start',$sStart);
		$stmt->bindParam(':end',$sEnd);
			

		#first event/once
		$stmt->execute();

		if ($nCount > 1)
		{
			if ($nCycle == 1) #weekly
			{
				echo $dtStart->format('Y-m-d H:i:s') . " <br /> " . $dtEnd->format('Y-m-d H:i:s') . "<br />";
				if (date_diff($dtStart,$dtEnd)->days < 7)
				{
					for ($i = 1; $i < $nCount; $i++)
					{
						$dtStart->add(new DateInterval('P7D'));
						$dtEnd->add(new DateInterval('P7D'));
						$sStart = $dtStart->format('Y-m-d H:i:s');
						$sEnd = $dtEnd->format('Y-m-d H:i:s');
						$stmt->execute();
					}
				}
			}
			elseif ($nCycle == 2) #biweekly
			{
				if (date_diff($dtStart,$dtEnd)->days < 14)
				{
					for ($i = 1; $i < $nCount; $i++)
					{
						$dtStart->add(new DateInterval('P14D'));
						$dtEnd->add(new DateInterval('P14D'));
						$sStart = $dtStart->format('Y-m-d H:i:s');
						$sEnd = $dtEnd->format('Y-m-d H:i:s');
						$stmt->execute();							
					}
				}

			}
			elseif ($nCycle == 3) #monthly
			{
				if (date_diff($dtStart,$dtEnd) < 31)
				{
					$diDiff = date_diff($dtStart,$dtEnd);

					$tday = date("d", $sEnd);
					$tmonth = date("m", $sEnd);
					$tyear = date("m", $sEnd);
		
					for ($i = 1; $i < $nCount-1; $i++)
					{			
						if ($tmonth == 12)
						{
							$tmonth = 1;
							$tyear++;
						}
						else
						{
							$tmonth++;
						}
						if ($tday > date("d", "$tmonth/1/$tyear"))
						{
							$dtEnd = new DateTime("$tmonth/" . date("d", "$tmonth/1/$tyear") . "/$tyear");
						}
						else
						{
							$dtEnd = new DateTime("$tmonth/" . $tday . "/$tyear");
						}
						$dtStart = $dtEnd->sub($diDiff);
						$sStart = $dtStart->format('Y-m-d H:i:s');
						$sEnd = $dtEnd->format('Y-m-d H:i:s');
						$stmt->execute();
					}
					
				}
			}
			elseif ($nCycle == 4) #yearly
			{
				$dtStart->add(new DateInterval('P1Y'));
				$dtEnd->add(new DateInterval('P1Y'));
				$sStart = $dtStart->format('Y-m-d H:i:s');
				$sEnd = $dtEnd->format('Y-m-d H:i:s');
				$stmt->execute();		
			}
		}
		$db->commit();
		return "";
	}
	catch (Exception $e)
	{
		$db->rollBack();
		return $e->getMessage();	
	}
	$db = null;
}
?>