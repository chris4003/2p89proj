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

						$results = findEvent($_GET['id']);
						foreach ($results as &$row) 
						{
							$start = date_create($row["ed_start"]);
							$end = date_create($row["ed_end"]);
							echo $row["eh_title"] ;
							echo $row["eh_address"];
							echo date_format($start,"M j, Y") ;
							echo date_format($end,"M j, Y");
							echo $row["eh_rating"];	
						}
					?>

				</div><!-- content-mid -->

				<div style="clear:both;"></div>
							</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>