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

						$event = findEvent($_GET['id']);
						
						$start = date_create($event["ed_start"]);
						$end = date_create($event["ed_end"]);

						if ($event['us_id'] == $_SESSION['user_id']){ #user owns this event
							echo "<h1>".$event["eh_title"]."</h1><br>" ;
							echo "<a href='../php/delete_event.php?id=".$event["ed_id"]."'>Delete this event</a><br>";
							echo "<form action='../php/update_event.php' method='POST'>";
							echo "<input type='hidden' value='{$event['ed_id']}'/>";
							echo "some form fields in hereEEEEEEEEEE<br>";
							echo "<input type='submit'>";
							echo "</form>";
						}
						else {
							echo "<h1>".$event["eh_title"]."</h1><br>" ;
							echo $event["eh_address"]."<br>";
							echo $event["eh_city"]."<br>";
							echo "Start: ".date_format($start,"M j, Y - h:i A")."<br>";
							echo "End: &nbsp;".date_format($start,"M j, Y - h:i A")."<br>";
							echo "<p>".$event["eh_description"]."</p>";
							echo "<p>Tags:<br>".$event["tags"]."</p>";
						}
						
					?>

				</div><!-- content-mid -->

				<div style="clear:both;"></div>
							</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>