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
					<?php 
						include "../php/event.php";

						$row = findEvent($_GET['id']);
						
						
							echo "<br>";
							$start = date_create($row["ed_start"]);
							$end = date_create($row["ed_end"]);

							echo $row["eh_title"] ;
							echo $row["eh_description"] ;
							echo $row["eh_address"];
							echo $row["eh_city"];
							echo date_format($start,"M j, Y - h:i A");
							echo date_format($start,"M j, Y - h:i A");
							echo $row["eh_rating"];	
							echo $row["eh_TAGSBRO"];	
					?>

				</div><!-- content-mid -->

				<div style="clear:both;"></div>
							</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>