#!/usr/bin/php-cgi
<?php
	include '../php/event.php';
	if ($_GET)
	{
	    $pTitle = $_GET["title"];
	    $pDescription = $_GET["description"];
	    $pCity = $_GET["city"];
	    $pEventStart = $_GET["eventstart"];
	    $pEventEnd = $_GET["eventend"];
	    $pInterests = $_GET["tagids"];

	    $aEvents = SearchEvent($pTitle, $pDescription,$pCity, $pEventStart, $pEventEnd, $pInterests);
	    #date("Y/m/d 23:59:59")
  	}
  	else
  	{
  		$aEvents = SearchEvent("","","", date("Y/m/d H:i:s"),  date("Y/m/d 23:59:59", time()+(7*24*3600)));	
  	}

	if (!is_null($aEvents))
	{
		if (count($aEvents) == 0)
		{
			echo "No results";
		}
		else
		{
			# showing the results  
			echo "<table>
				<tr>
					<th> Thumbnail</th>
					<th> Title</th>
					<th> City</th>
					<th> Start</th>
					<th> End</th>
					<th> Tags</th>
				</tr>";

				
			foreach ($aEvents as &$row) 
			{
				$start = date_create($row["ed_start"]);
				$end = date_create($row["ed_end"]);

				$tablerow = "<tr>";
				if ($row["eh_image_name"] != "")
			    	$tablerow .= "<td><img class='thumbnail' src='../assets/images/uploaded/" . $row["eh_image_name"] . "'</td>";
			    else
			    	$tablerow .= "<td><img class='thumbnail' src='../assets/images/No_image.jpg'</td>";


			    $tablerow .=	"<td><a href='show_event.php?id=" . $row["ed_id"] . "'>" . $row["eh_title"] . "</a></td>" .
					    		"<td>" . $row["eh_city"] . "</td>" .
					    		"<td>" . date_format($start,"M j, Y - h:i A") . "</td>" .
					    		"<td>" . date_format($end,"M j, Y - h:i A") . "</td>" .
					    		"<td>" . $row["tags"] . "</td>" .
				    		"</tr>";	
			    echo $tablerow;						
			}

			echo "</table>";
		}
	}
	#var_dump($_SESSION);
?>