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

					include "../php/admin_tools.php"; 
					if (isset($_SESSION['user_id']))
					{
						$aUserInfo = getUserInfo($_SESSION['user_id']);
						if (!is_null($aUserInfo))
						{
							if ($aUserInfo['us_admin'])
							{
								echo "Display Events table<br />";
								echo "Display Users table<br />";
								echo "Display Interest table<br />";
							}
							else
							{
								echo "Insufficient security<br />";
							}
						}
						else
						{
							echo "Invalid User<br />";
						}
					}
					else
					{
						echo "please log in<br />";
					}
					?>
				</div><!-- content-mid -->

				<div style="clear:both;"></div>
			</div><!-- page content-->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>