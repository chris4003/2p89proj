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

					include "../php/event.php"; 
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
									<th style='width:90px;'> Date ID</th>
									<th style='width:90px;'> Event ID</th>
									<th style='width:120px;'> Title</th>
									<th style='width:120px;'> City</th>
									<th style='width:90px;'> Start</th>
									<th style='width:90px;'> End</th>
									<th style='width:100px;'> Tags</th>
									<th colspan='3'  style='width:150px;'>Actions</th>
								</tr>";
							
						foreach ($aEvents as &$row) 
						{
							$start = date_create($row["ed_start"]);
							$end = date_create($row["ed_end"]);

							$tablerow = "<tr>" .
											"<td>" . $row["ed_id"] . "</td>" .
											"<td>" . $row["eh_id"] . "</td>" .
						    				"<td>" . $row["eh_title"] . "</td>" .
								    		"<td>" . $row["eh_city"] . "</td>" .
								    		"<td>" . date_format($start,"M j, Y    h:i A") . "</td>" .
								    		"<td>" . date_format($end,"M j, Y    h:i A") . "</td>" .
								    		"<td>" . $row["tags"] . "</td>" .
								    		"<td><a href='edit_event.php?ed_id=" . $row["ed_id"] . "'>Edit</a></td>" .  
								    		"<td><a href='delete_event.php?ed_id=" . $row["ed_id"] . "'>Delete Date</a></td>" .  
								    		"<td><a href='delete_event.php?eh_id=" . $row["eh_id"] . "'>Delete Event</a></td>" .  
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