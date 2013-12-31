#!/usr/bin/php-cgi
<!DOCTYPE html>
<!--
index.html

Chris Thompson and Vincent Morsaint
4843348

Brock University, COSC 2P89
Fall/winter
-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="assets/stylesheets/style.css">
		<title> wewt.com </title>
	</head>

	<body>
		<?php include 'html/header.html'; ?>
		<div id="main">

		<?php include 'html/nav_bar.html'; ?>
			<div id="page_content">
				<div id="content_mid">
					page-content
					<a href="http://www.wikipedia.org/" class="bottomlink"><img src="http://www4.images.coolspotters.com/photos/528991/l-space-swanky-one-piece-profile.jpg"  alt="wo" /></a> 
					
				</div><!-- content-mid -->
				<div id="right_bar" style="height:200px;">
					Sidebar wewt <br />
					tags<br />
					
				</div>
				<div style="clear:both;"></div>
			</div>
		</div> <!-- main -->
		<?php include 'html/footer.html'; ?>
	</body>
</html>