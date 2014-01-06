#!/usr/bin/php-cgi
<?php 
	$pagetype = 2;
      include 'html_head.html'; 
      ?>
		<title> wewt.com </title>
	</head>

	<body>
		
		<div id="main">
		<?php include 'header.html'; ?>
		<?php include 'nav_bar.html'; ?>
			<div id="page_content">
				<div id="content_mid">
					<?php include "../html/flash_message.php"; ?>
					<?php 

					include "../php/event_tools.php"; 
					$aEvents = SearchEvent();
					if (count($aEvents) == 0)
					{
						echo "No Data";
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
								<th> </th>
								<th> </th>
							</tr>";
							
						foreach ($aEvents as &$row) 
						{
							$start = date_create($row["ed_start"]);
							$end = date_create($row["ed_end"]);

							$tablerow = "<tr>";
						    $tablerow .=	"<td>" . $row["eh_title"] . "</td>" .
								    		"<td>" . $row["eh_city"] . "</td>" .
								    		"<td>" . date_format($start,"M j, Y - h:i A") . "</td>" .
								    		"<td>" . date_format($end,"M j, Y - h:i A") . "</td>" .
								    		"<td>" . $row["tags"] . "</td>" .
								    		"<td><a href='edit_event.php?id=" . $row["ed_id"] . "'>edit</td>" .  
								    		"<td><a href='delete_event.php?id=" . $row["ed_id"] . "'>delete</td>" .  
							    		"</tr>";	
						    echo $tablerow;
						    
						}

						echo "</table>";

					}
					?>
				</div><!-- content-mid -->

				<div style="clear:both;"></div>
			</div><!-- page content-->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>