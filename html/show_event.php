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

						$row = findEvent($_GET['id']);
						
						$start = date_create($row["ed_start"]);
						$end = date_create($row["ed_end"]);

						echo "<h1>".$row["eh_title"]."</h1><br>" ;
						echo $row["eh_address"]."<br>";
						echo $row["eh_city"]."<br>";
						echo "Start: ".date_format($start,"M j, Y - h:i A")."<br>";
						echo "End: &nbsp;".date_format($start,"M j, Y - h:i A")."<br>";
						echo "<p>".$row["eh_description"]."</p>";
						echo "<p>Tags:<br>".$row["tags"]."</p>";
					?>

				</div><!-- content-mid -->

				<div style="clear:both;"></div>
							</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>