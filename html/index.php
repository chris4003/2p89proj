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
		<table>
			<tr>
				<th colspan="6">Events</th>
			</tr>
			<tr>
				<td> Title</td>
				<td> Description</td>
				<td> Address</td>
				<td> Rating</td>
				<td> Start</td>
				<td> End</td>
				<td> Display Name</td>
			</tr>

		<?php #loads events k
		include '../php/globals.php';
		$db = new PDO("mysql:dbname={$DATABASE}; host={$SERVER}", $USERNAME, $PASSWORD);

		$sql = "select * from EventHeader natural join EventDates natural join Users";
		$stmt = $db->query($sql);  
	  
		# setting the fetch mode  
		$stmt->setFetchMode(PDO::FETCH_OBJ);  
		
		
		# showing the results  
		while($row = $stmt->fetch()) 
		{  
			echo "<tr>";
		    echo "<td>" . $row->eh_title . "</td>";  
		    echo "<td>" . $row->eh_description . "</td>";
		    echo "<td>" . $row->eh_address . "</td>";
		    echo "<td>" . $row->eh_rating . "</td>";
		    echo "<td>" . $row->ed_start . "</td>";
		    echo "<td>" . $row->ed_end . "</td>";
		    echo "<td>" . $row->us_displayname . "</td>";
		    echo "</tr>";
		}
		
		?>
		</table>

					<a href="http://www.wikipedia.org/" class="bottomlink"><img src="http://www4.images.coolspotters.com/photos/528991/l-space-swanky-one-piece-profile.jpg"  alt="wo" /></a> 
					
				</div><!-- content-mid -->
				<div id="right_bar" style="height:200px;">
					<form action = "index.php" method = "get">
				         <div class="labelOrder">
				            <label for="title">Title:</label> <input type="text" id = "title" name = "title"/><br />
				            <label for="description">Description:</label> <input type="text" id = "description" name = "description" ><br />
				            <label for="eventstart">Start:</label> <input type="text" id = "eventstart" name = "eventstart"/><br />
				            <label for="eventend">End:</label> <input type="text" id = "eventend" name = "eventend"/><br />   
				            <script>
					            $( "#eventstart" ).datepicker();
					            $( "#eventend" ).datepicker();
				            </script>

				            Tags: <input type="text" id = "tags" name = "tags"/><a href="javascript:clearTags()">Clear</a><br />
				            <input type="hidden" id = "tagids" name = "tagids"/>
				            <select id="tag_select" onChange="tagPicked()">
				            	<option value="0"></option>
				            	<option value="1">Food</option>
				            	<option value="2">Gaming</option>
				            	<option value="2">Movies</option>
				            </select>
				            	<?php
				            		#echo get_interests_select_box()
				            	?>
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