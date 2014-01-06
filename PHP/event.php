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
		$stmt->bindValue(':headerID', $nHeaderID, PDO::PARAM_INT);
		$stmt->execute();
		
		$stmt = $db->prepare('DELETE FROM EventHeader WHERE eh_id = :headerID');
		$stmt->bindValue(':headerID', $nHeaderID, PDO::PARAM_INT);
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

function deleteEventDate($nDateID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;

	$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	try
	{
		$stmt = $db->prepare('SELECT eh_id FROM EventDates WHERE ed_id = :dateID');
		$stmt->bindValue(':dateID', $nDateID, PDO::PARAM_INT);
		$stmt->execute();

		$nEventID = $stmt->fetchColumn();
		if ($nEventID)
		{
			$stmt = $db->prepare('SELECT COUNT(ed_id) as datecount 
								FROM EventDates 
								WHERE eh_id = :headerID');			
			$stmt->bindValue(':headerID', $nEventID, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchColumn();
		}
		else
		{
			$result = 0;
		}
	}
	catch(Exception $e)
	{
		$result = 0;
	}

	try
	{
		$db->begintransaction();

		$stmt = $db->prepare('DELETE FROM EventDates WHERE ed_id = :dateID');
		$stmt->bindValue(':dateID', $nDateID, PDO::PARAM_INT);
		$stmt->execute();

		if ($result == 1)
		{
			$stmt = $db->prepare('DELETE FROM EventHeader WHERE eh_id = :headerID');
			$stmt->bindValue(':headerID', $nEventID, PDO::PARAM_INT);
			$stmt->execute();
		}


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


function findEventByDateID($nDateID)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$stmt = $db->prepare('SELECT eh_id, eh_address, eh_city, eh_title, eh_description, eh_rating, eh_image_name, us_id, ed_start, ed_end, ed_id
								from EventHeader natural join EventDates
							   WHERE ed_id = :dateID');

		$stmt->bindValue(':dateID', $nDateID, PDO::PARAM_INT);
		$stmt->execute();
	
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		addTagData($db,&$result);
	}
	catch (Exception $e)
	{
		echo "Select failed<br />" . $e->getMessage() . "<br />";	
		$result = null;
	}
	$db = null;
	return $result;
}
function findEventsByUser($user_id)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();
		$stmt = $db->prepare("SELECT EventHeader.eh_id, eh_title, eh_city, ed_start, ed_end, eh_rating, eh_image_name, ed_id
							   FROM EventHeader inner join EventDates on EventHeader.eh_id = EventDates.eh_id
							   WHERE us_id = :OwnerID");
		$stmt->bindValue(':OwnerID', $user_id, PDO::PARAM_INT);
		$stmt->execute();
	
		$result = $stmt->fetchall();

		foreach ($result as &$row) 
		{
			addTagData($db,&$row);
		}
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
function SearchEvent($sTitle = "", $sDescription = "", $sCity = "", $sStart = "", $sEnd = "", $sInterests = "")
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		$sFields = "SELECT EventHeader.eh_id, eh_title, eh_city, ed_start, ed_end, eh_rating, eh_image_name, ed_id
							   FROM EventHeader inner join EventDates on EventHeader.eh_id = EventDates.eh_id
							   WHERE ";
		
		if ($sTitle == "" && $sDescription == "" && $sCity == "" && $sStart == "" && $sEnd == "" && $sInterests == "")
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
			if ($sCity != "")
			{
				$sWhere .= ($sWhere==""?"":" AND ") . "eh_city LIKE '%" . $sCity . "%'";
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

		foreach ($result as &$row) 
		{
			addTagData($db,&$row);
		}
		
	}
	catch (Exception $e)
	{
		echo "Search failed<br />" . $e->getMessage() . "<br />";	
		$result = null;
	}
	$db = null;
	return $result;
}
function addTagData($db,$row){
	#########################################################################################
		#add tag data for the index page
		

			$stmt = $db->prepare("SELECT in_id, in_description from EventInterests natural join Interests where eh_id = " . $row["eh_id"]);
			$stmt->execute();
			$tags = $stmt->fetchall();

			$tagIDArray = array();
			$tagArray = array();
			foreach ($tags as &$tag) 
			{
				array_push($tagIDArray, $tag["in_id"] );
				array_push($tagArray, $tag["in_description"] );
			}
			$row["tagIDs"] = implode(",",$tagIDArray);
			$row["tags"] = implode(", ",$tagArray);
		
}

function modifyEventHead($nHeaderID, $sTitle, $sDescription, $sAddress, $sCity, $sOwner, $sTagsIDs, $sImage_name)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();
		$stmt = $db->prepare('UPDATE EventHeader SET eh_title = :title, eh_description = :description, eh_address = :address, 
						 		eh_city = :city, eh_image_name = :image, us_id = :owner 
								WHERE eh_id = :headerID');

		$stmt->bindValue(':headerID', $nHeaderID, PDO::PARAM_INT);
		$stmt->bindValue(':title', $sTitle, PDO::PARAM_STR);
		$stmt->bindValue(':description', $sDescription, PDO::PARAM_STR);
		$stmt->bindValue(':address', $sAddress, PDO::PARAM_STR);
		$stmt->bindValue(':city', $sCity, PDO::PARAM_STR);
		$stmt->bindValue(':image', $sImage_name, PDO::PARAM_STR);
		$stmt->bindValue(':owner', $sOwner, PDO::PARAM_STR);
		$stmt->execute();


		$stmt = $db->prepare('DELETE FROM  EventInterests 
									WHERE eh_id = :headerID');
		$stmt->bindValue(':headerID', $nHeaderID, PDO::PARAM_INT);
		$stmt->execute();		


		$aTagIDs = split(",",$sTagsIDs);
		$stmt = $db->prepare('INSERT INTO  EventInterests (eh_id, in_id) 
									VALUES (:headerID, :tagid)');
		$stmt->bindValue(':headerID', $nHeaderID, PDO::PARAM_INT);
		$stmt->bindParam(':tagid',$tagID);
		foreach ($aTagIDs as &$nTagID)
		{
			$tagID = $nTagID;
			$stmt->execute();	
		}

		
		$db->commit();
		return "";
	}
	catch (Exception $e)
	{
		return "Update Event Header failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}

function modifyEventDate($nDateID, $sStart, $sEnd)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;
	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		$stmt = $db->prepare('UPDATE EventDates set ed_start = :start, ed_end = :end 
								WHERE ed_id = :dateID');

		$dtStart = new DateTime($sStart);
		$dtEnd = new DateTime($sEnd);

		$tmpStart = $dtStart->format('Y-m-d H:i:s');
		$tmpEnd = $dtEnd->format('Y-m-d H:i:s');

		$stmt->bindValue(':dateID', $nDateID, PDO::PARAM_INT);
		$stmt->bindValue(':start', $tmpStart, PDO::PARAM_STR);
		$stmt->bindValue(':end', $tmpEnd, PDO::PARAM_STR);
		$stmt->execute();
	
		return "";
	}
	catch (Exception $e)
	{
		return "Update Event Date failed<br />" . $e->getMessage() . "<br />";	
	}
	$db = null;
}


function buildEvent($sTitle, $sDescription,$sAddress,$sCity, $sStart, $sEnd, $nCycle, $nCount, $sOwner,$sTags,$sImage_name)
{
	global $SERVER, $USERNAME, $PASSWORD, $DATABASE;

	try
	{
		
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$db->begintransaction();
		$stmt = $db->prepare('INSERT INTO  EventHeader (eh_title, eh_description, eh_address,eh_city,eh_image_name, us_id)
				VALUES (:title, :description, :address,:city,:image_name, :owner); SET @parenteh_ID = LAST_INSERT_ID();');

		$stmt->bindParam(':title', $sTitle);
		$stmt->bindParam(':description', $sDescription);
		$stmt->bindParam(':address', $sAddress);
		$stmt->bindParam(':city', $sCity);
		$stmt->bindParam(':image_name', $sImage_name);
		$stmt->bindParam(':owner', $sOwner);


		$stmt->execute();	


		$stmt = $db->prepare('INSERT INTO  EventDates (eh_id, ed_start, ed_end)
		VALUES (@parenteh_ID, :start, :end)');
		$dtStart = new DateTime($sStart);
		$dtEnd = new DateTime($sEnd);

		$tStart = $dtStart->format('Y-m-d H:i:s');
		$tEnd = $dtEnd->format('Y-m-d H:i:s');

		$stmt->bindParam(':start',$tStart);
		$stmt->bindParam(':end',$tEnd);


		#first event/once
		$stmt->execute();

		if ($nCount > 1)
		{
			if ($nCycle == 1) #weekly
			{
				if (date_diff($dtStart,$dtEnd)->days < 7)
				{
					for ($i = 1; $i < $nCount; $i++)
					{
						$dtStart->add(new DateInterval('P7D'));
						$dtEnd->add(new DateInterval('P7D'));
						$tStart = $dtStart->format('Y-m-d H:i:s');
						$tEnd = $dtEnd->format('Y-m-d H:i:s');
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
						$tStart = $dtStart->format('Y-m-d H:i:s');
						$tEnd = $dtEnd->format('Y-m-d H:i:s');
						$stmt->execute();							
					}
				}

			}
			elseif ($nCycle == 3) #monthly
			{
				$diDiff = date_diff($dtStart,$dtEnd);
				if ($diDiff->format('%d') < 31)
				{
					$tday = (int) $dtEnd->format("d");
					$tmonth = (int) $dtEnd->format("m");
					$tyear = (int) $dtEnd->format("y");
		
					for ($i = 1; $i < $nCount; $i++)
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
						#check to see if the day is greater than the last day of the month for that month.
						$monthDays = cal_days_in_month(CAL_GREGORIAN,$tmonth,$tyear);
						if ($tday > $monthDays)
						{
							$dtEnd = new DateTime("$tmonth/$monthDays/$tyear" . $dtEnd->format(" H:i:s"));
						}
						else
						{
							$dtEnd = new DateTime("$tmonth/$tday/$tyear" . $dtEnd->format(" H:i:s"));
						}
						$dtStart = clone $dtEnd;
						$dtStart->sub($diDiff);
						$tStart = $dtStart->format('Y-m-d H:i:s');
						$tEnd = $dtEnd->format('Y-m-d H:i:s');
						$stmt->execute();
					}
					
				}
			}
			elseif ($nCycle == 4) #yearly
			{
				$dtStart->add(new DateInterval('P1Y'));
				$dtEnd->add(new DateInterval('P1Y'));
				$tStart = $dtStart->format('Y-m-d H:i:s');
				$tEnd = $dtEnd->format('Y-m-d H:i:s');
				$stmt->execute();		
			}
		}

		$tags = split(",",$sTags);
		$stmt = $db->prepare('INSERT INTO  EventInterests (eh_id, in_id)
									VALUES (@parenteh_ID, :tagid)');

		$stmt->bindParam(':tagid',$tagid);
		foreach ($tags as &$tag){
			$tagid = $tag;
			$stmt->execute();	
		}
		
		$db->commit();
		$return = "";
	}
	catch (Exception $e)
	{
		$db->rollBack();
		$return = $e->getMessage();	
		file_put_contents("../assets/err.log", $return, FILE_APPEND);
	}
	$db = null;
	return $return;
}

?>