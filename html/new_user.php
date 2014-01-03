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
					<fieldset>
						<legend>New User</legend>
						<p>
							In order to make your account, we need to collect a few pieces of information.  Please fill out the following form to register.
						</p>
						<form action = "../php/register.php" method = "post">
							<label for="username">Username:</label><br />
							<input type="text" id = "username" name = "username"/><br />
							<label for="realname">Real Name:</label> <br />
							<input type="text" id = "realname" name = "realname"/><br />
							<label for="email">E-mail Address:</label> <br />
							<input type="text" id = "email" name = "email"/><br />
							<label for="password">Password:</label> <br />
							<input type="password" id = "password" name = "password"/><br />
							<label for="passcheck">Password Check:</label> <br />
							<input type="password" id = "passcheck" name = "passcheck"/><br />
            				<input type="submit">
						</form>
					</fieldset>
							</div><!-- content-mid -->


				<div style="clear:both;"></div>
							</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>