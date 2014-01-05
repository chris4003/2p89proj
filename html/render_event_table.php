<?php
	if (count($aEvents) == 0)
	{
		echo "No results";
	}
	else
	{
		# showing the results  
		echo "<table>
			<tr>
				<th></th>
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
?>