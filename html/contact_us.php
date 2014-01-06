#!/usr/bin/php-cgi
<?php 
      include 'html_head.html'; 
      ?>
		<title> wewt.com </title>
		<script src="../assets/javascripts/validation.js"></script>
	</head>

	<body>
		
		<div id="main">
		<?php include 'header.html'; ?>

		<?php include 'nav_bar.html'; ?>
			<div id="page_content">
				<div id="content_mid">
					<?php include "../html/flash_message.php"; ?>
					<?php 
						if ($_POST)
						{
							include "../php/contact.php";
							$pName = $_POST["name"];
							$pEmail = $_POST["email"];
							$pSubject = $_POST["subject"];
							$pMessage = $_POST["message"];
							$return = createMessage($pName,$pEmail,$pSubject,$pMessage);
							if ($return == "")
							{
								echo "<p>Thanks! We got your message.</p>";	
							}
							else
							{
								echo $return;
							}
						}
						
					?>
					<form action = "contact_us.php" method = "post" onsubmit="return validateContact(this);">
						<p>
							Please let us know what you think:<br /><br />

							<label for="name">Name*:</label><br />
							 <input type="text" id = "name" name = "name"/><br />
							<label for="email">E-mail Address*:</label><br />
							 <input type="text" id = "email" name = "email"/><br />
							<label for="subject">Subject*:</label><br />
							 <input type="text" id = "subject" name = "subject"/><br />

		            		<label for="message">Message*:</label><br />
		            		 <textarea id = "message" name = "message" cols="40" rows="5">Enter your message here.</textarea><br />
            				
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