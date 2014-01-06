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
					<h1>About wewt.com</h1>
					<p>
					WEWT.com is at your disposal to help you find any kind of event, promotion, deal or discount in your area. 
					As a business owner, wewt.com is also a great way to promote your business, as well as any special events you may be planning.
					In essence, wewt.com helps you find what you're looking for reliably and rapidly, bridging the gap between where you are and where you want to be.  <br>

					</p>
					<h1> How it works </h1>
					<h2> Creating an event: </h2>
					<p>
						If you're an event coordinator and would like to advertise an event on the site,
						 simply register with the site and start adding event information.
						   It's that simple!  If you just want to browse existing events,
						    you don't need to sign up, just go to our home page and search.<br><br>

						Recurring events can be saved for convenience.  
						So, for example, if every Saturday is ladies night,
						you can set an event each week without adding each one individually.
					</p>

					<h2> Interests(Tags): </h2>
					<p>
						When events are created, they are associated to any number of relevant area of interest.
						You can use these tags to sort and search for events that are tailored to you!
						To search for events by tag, use the search feature on our <a href="index.php">home page</a>.
					</p>
					<h5>If you're interested in becoming a partner or investing wewt.com, please contact us through the contact section of the site!</h5>
				</div><!-- content-mid -->

				<div style="clear:both;"></div>
			</div><!-- page content-->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>