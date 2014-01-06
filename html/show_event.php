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
					<?php include "../html/flash_message.php"; ?>
					<?php 
						include "../php/event.php";

						$event = findEventByDateID($_GET['id']);
						
						$start = date_create($event["ed_start"]);
						$end = date_create($event["ed_end"]);

						echo "<table style='border: 1px solid black;'><tr><td>";
						echo "<h1>".$event["eh_title"]."</h1><br />" ;
						echo "Address:<br />";
						echo "&nbsp;" . $event["eh_address"]."<br />";
						echo "&nbsp;" . $event["eh_city"]."<br /><br />";
						echo "Start: <br />&nbsp;".date_format($start,"M j, Y - h:i A")."<br />";
						echo "End: <br />&nbsp;".date_format($start,"M j, Y - h:i A")."<br /><br>";

						echo "<p>Tags:<br />&nbsp;".$event["tags"]."</p>";
						echo "</td><td align=Center>";
						if ($event["eh_image_name"] != "")
						{
		    				echo "<img class='thumbnail' src='../assets/images/uploaded/" . $event["eh_image_name"] . "'/>";
						}
		    			else
		    			{
		    				echo "<img class='thumbnail' src='../assets/images/No_image.jpg' />";
		    			}
						echo "</td></tr><tr><td colspan='2'>";
						echo "<p>&nbsp;".$event["eh_description"]."</p>";
						echo "</td></tr></table>";

						
						
					?>

				</div><!-- content-mid -->

				<div style="clear:both;"></div>
							</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>