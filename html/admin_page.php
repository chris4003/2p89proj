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

						include "../php/admin_tools.php"; 
						if (isset($_SESSION['user_id']))
						{
							$aUserInfo = getUserInfo($_SESSION['user_id']);
							if (!is_null($aUserInfo))
							{
								if ($aUserInfo['us_admin'])
								{
									echo "<a href='../html/manageevents.php'>Manage Events table</a><br />";
									echo "<a href='../html/manageusers.php'>Manage Users table</a><br />";
									echo "<a href='../html/manageinterests.php'>Manage Interests table</a><br />";
								}
							}
						}
					?>
				</div><!-- content-mid -->

				<div style="clear:both;"></div>
			</div><!-- page content-->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>