#!/usr/bin/php-cgi
<?php 
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
				<?php #loads events k
					include '../php/event.php';
					if ($_GET) 
					{
					    $pTitle = $_GET["title"];
					    $pDescription = $_GET["description"];
					    $pAddress = $_GET["address"];
					    $pEventStart = $_GET["eventstart"];
					    $pEventEnd = $_GET["eventend"];
					    $pInterests = $_GET["tagids"];

					    $aEvents = SearchEvent($pTitle, $pDescription,$pAddress, $pEventStart, $pEventEnd, $pInterests);
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
									<th colspan='5'>Events</th>
								</tr>
								<tr>
									<td> Title</td>
									<td> Address</td>
									<td> Start</td>
									<td> End</td>
									<td> Rating</td>
								</tr>";

								
							foreach ($aEvents as &$row) 
							{
								$start = date_create($row["ed_start"]);
								$end = date_create($row["ed_end"]);
								echo "<tr>" .
							    		"<td><a href='show_event.php?id=" . $row["eh_id"] . "'>" . $row["eh_title"] . "</a></td>" .
							    		"<td>" . $row["eh_address"] . "</td>" .
							    		"<td>" . date_format($start,"M j, Y H:i") . "</td>" .
							    		"<td>" . date_format($end,"M j, Y H:i") . "</td>" .
							    		"<td>" . $row["eh_rating"] . "</td>" .
							    	"</tr>";							
							}

							echo "</table>";
						}
					}
					#var_dump($_SESSION);
				?>

				</div><!-- content-mid -->
				<div id="right_bar" style="height:200px;">
					<p>
						Search for events by ... 
					</p>
					<form action = "index.php" method = "get">
				         <div class="labelOrder">
				            <label for="title">Title:</label> <input type="text" id = "title" name = "title"/><br />
				            <label for="description">Description:</label> <input type="text" id = "description" name = "description" ><br />
				            <label for="description">Address:</label> <input type="text" id = "address" name = "address" ><br />
				            <label for="eventstart">Start:</label> <input type="text" id = "eventstart" name = "eventstart"/><br />
				            <label for="eventend">End:</label> <input type="text" id = "eventend" name = "eventend"/><br />   
				            <script>
				            	/* shows time on datepicker, could be hidden using the alt-name input(hidden) and altformat parameter*/
					            $( "#eventstart" ).datepicker({dateFormat: "mm/dd/yy 00:00:00"});
					            $( "#eventend" ).datepicker({dateFormat: "mm/dd/yy 23:59:59"});
				            </script>


				            Tags: 
				            <select id="tag_select" onChange="tagPicked()">
	                           <?php
	                              include '../php/interests.php';
	                              getInterestsOptions();
	                           ?>
				            </select>
				            <input type="text" id = "tags" name = "tags"/>
				            <a href="javascript:clearTags()">Clear</a><br />
				            <input type="hidden" id = "tagids" name = "tagids"/>
			            	<br />
				            <input type="submit" value="Search" />
				         </div>
				      </form>
					
				</div>
				<div style="clear:both;"></div>
			</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>