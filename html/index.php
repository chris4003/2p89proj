#!/usr/bin/php-cgi
<?php 
      include 'html_head.html'; 
      ?>
		<title> wewt.com </title>
	</head>

	<body>
		<?php 
		include 'header.html'; 
		?>
		
		<div id="main">

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
		          	}
		          	else
		          	{
		          		$aEvents = SearchEvent("","","","","","");	
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
									<th colspan='6'>Events</th>
								</tr>
								<tr>
									<td> Title</td>
									<td> Description</td>
									<td> Address</td>
									<td> Start</td>
									<td> End</td>
									<td> Rating</td>
								</tr>";

								
							foreach ($aEvents as &$row) 
							{
								echo "<tr>" .
							    		"<td>" . $row["eh_title"] . "</td>" .
							    		"<td>" . $row["eh_description"] . "</td>" .
							    		"<td>" . $row["eh_address"] . "</td>" .
							    		"<td>" . $row["ed_start"] . "</td>" .
							    		"<td>" . $row["ed_end"] . "</td>" .
							    		"<td>" . $row["eh_rating"] . "</td>" .
							    	"</tr>";							
							}

							echo "</table>";
						}
					}
				?>

				</div><!-- content-mid -->
				<div id="right_bar" style="height:200px;">
					<form action = "index.php" method = "get">
				         <div class="labelOrder">
				            <label for="title">Title:</label> <input type="text" id = "title" name = "title"/><br />
				            <label for="description">Description:</label> <input type="text" id = "description" name = "description" ><br />
				            <label for="description">Address:</label> <input type="text" id = "address" name = "address" ><br />
				            <label for="eventstart">Start:</label> <input type="text" id = "eventstart" name = "eventstart"/><br />
				            <label for="eventend">End:</label> <input type="text" id = "eventend" name = "eventend"/><br />   
				            <script>
					            $( "#eventstart" ).datepicker();
					            $( "#eventend" ).datepicker();
				            </script>

				            Tags: <input type="text" id = "tags" name = "tags"/><a href="javascript:clearTags()">Clear</a><br />
				            <input type="hidden" id = "tagids" name = "tagids"/>
				            <select id="tag_select" onChange="tagPicked()">
	                           <?php
	                              include '../php/interests.php';
	                              getInterestsOptions();
	                           ?>
				            </select>
			            	<br />
				            <input type="submit" value="Search" />
				         </div>
				      </form>
					
				</div>
				<div style="clear:both;"></div>
			</div>
		</div> <!-- main -->
		<?php include 'footer.html'; ?>
	</body>
</html>