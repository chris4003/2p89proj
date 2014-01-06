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
					include_once '../php/user_tools.php';
					$aUsers = SearchUsers();
					if (count($aUsers) == 0)
					{
						echo "No Users";
					}
					else
					{
						# showing the results  
						echo "<table>
							<tr>
								<th style='width:150px;'> UserID</th>
								<th style='width:150px;'> Username</th>
								<th style='width:250px;'> Display Name</th>
								<th style='width:150px;'> Location</th>
								<th style='width:300px;'> Email</th>
								<th colspan='2' style='width:100px;'>Actions</th>
							</tr>";
							
						foreach ($aUsers as &$row) 
						{
							echo 	"<tr>" .
										"<td>" . $row["us_id"] . "</td>" .
					    				"<td>" . $row["us_name"] . ($row["us_admin"]?"*":"") ."</td>" .
							    		"<td>" . $row["us_displayname"] . "</td>" .
							    		"<td>" . $row["us_location"] . "</td>" .
							    		"<td>" . $row["us_email"] . "</td>" .
							    		"<td><a href='edit_user.php?UserID=" . $row["us_id"] . "'>Edit</td>" .  
							    		"<td><a href='delete_user.php?UserID=" . $row["us_id"] . "'>Delete</td>" .  
						    		"</tr>";	
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