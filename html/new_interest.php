#!/usr/bin/php-cgi
<?php 
	$pagetype = 2;
    include 'html_head.html'; 
    	?>
		<title> wewt.com </title>
		<script src="../assets/javascripts/validation.js"></script>
	</head>

	<body>
		<div id="main">
			<?php 
				include 'header.html'; 
				include 'nav_bar.html';
				$referer = end(explode("/", $_SERVER['HTTP_REFERER']));
			?>
			<div id="page_content">
				<div id="content_mid">
					<?php include "../html/flash_message.php"; ?>
					<fieldset>
						<legend>New Interest</legend>
						<form action = "../php/create_interest_script.php" method = "post" onsubmit="return validateNewInterest(this);">
							<input type="hidden" name="referer" value="<?php echo $referer;?>">
							<label for="description">Description*:</label><br />
							<input type="text" id = "description" name = "description"/><br />
							<label for="parentid">Parent Interest*:</label> <br />
							<select id="parentid" name="parentid">
                           	<?php
                              include '../php/interests.php';
                              getInterestsOptions();
                            ?>
	                        </select>
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