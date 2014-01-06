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
					<h1>Why log in?</h1>
					<p>
						Login in allows you to create and maintain your own events. 
						Two new options will appear in your menu when you are logged it, the "create event" option and the "my events" option.
						Through "my events", you can view, edit and delete your own events.  
						Eventually additional features will also be implemented for added functionability and ease-of-us for users who are logged in.
					</p>
				</div><!-- content-mid -->

				<div style="clear:both;"></div>
			</div><!-- page content-->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>