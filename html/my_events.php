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
					<h1>Events</h1>
					<?php #loads events k
						include '../php/event.php';
						$aEvents = findEventsByUser($_SESSION['user_id']);	
					  	
						if (!is_null($aEvents))
						{
							include "render_event_table.php";
						}
					?>

				</div><!-- content-mid -->
				
			</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>