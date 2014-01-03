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
						if ($_POST)
							echo "<p>thanks we got your message</p>";
						
					?>
					<form action = "contact_us.php" method = "post">
						<p>
							If you want to contact us, we really don't care.  If you don't care that we don't care, use the form below :<br>

							<label for="name">Name:</label><br />
							 <input type="text" id = "name" name = "name"/><br />
							<label for="email">E-mail Address:</label><br />
							 <input type="text" id = "email" name = "email"/><br />
							<label for="subject">Subject:</label><br />
							 <input type="text" id = "subject" name = "subject"/><br />

		            		<label for="message">Message:</label><br />
		            		 <textarea id = "message" name = "message" cols="40" rows="5">Type your message here k.</textarea><br />
            				
						</p>
						<input type="submit">
					</form>

				</div><!-- content-mid -->

				
				<div style="clear:both;"></div>
			</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>