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
					include_once '../php/interests.php';
					$aInterests = SearchInterests();
					if (count($aInterests) == 0)
					{
						echo "No Interests";
					}
					else
					{
						# showing the results  
						echo "<table>
							<tr>
								<th style='width:150px; border-left:1px solid black; border-bottom:1px solid black'> Interest ID</th>
								<th style='width:250px; border-left:1px solid black; border-bottom:1px solid black'> Descrition</th>
								<th style='width:150px; border-left:1px solid black; border-bottom:1px solid black'> Parent Interest</th>
								<th colspan='2' style='width:100px; border-left:1px solid black; border-bottom:1px solid black'>Actions</th>
							</tr>";
							
						foreach ($aInterests as &$row) 
						{
							echo 	"<tr>" .
							    		"<td>" . $row["in_id"] . "</td>" .
							    		"<td>" . $row["in_description"] . "</td>" .
							    		"<td>" . $row["in_id_parent"] . "</td>" .
							    		"<td><a href='edit_interest.php?InterestID=" . $row["in_id"] . "'>Edit</a></td>" .  
							    		"<td><a href='delete_interest.php?InterestID=" . $row["in_id"] . "'>Delete</a></td>" .  
						    		"</tr>";	
						}

						echo "<tr><td colspan ='5'><a href='new_interest.php'>Add New Interest</a></td></tr></table>";

					}
					?>
				</div><!-- content-mid -->

				<div style="clear:both;"></div>
			</div><!-- page content-->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>