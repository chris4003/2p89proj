#!/usr/bin/php-cgi
<?php 
      include 'html_head.html'; 
      ?>
		<title> wewt.com </title>
		<script src="../assets/javascripts/ajax_tools.js"></script>
		
	</head>

	<body>
		
		<div id="main">
		<?php include 'header.html'; ?>

		<?php include 'nav_bar.html'; ?>
			<div id="page_content">
				<div id="content_mid">
					<?php include "../html/flash_message.php"; ?>
					<h1>Events</h1>
					<script> 
						getEventTable();
					</script>

				</div><!-- content-mid -->
				<div id="right_bar" >
					<p>
						Search for events by ... 
					</p>
					<form id="search_form" method="get" onsubmit="return getEventTable();">
					
				         <div class="labelOrder">
				            <label for="title">Title:</label> <input type="text" id = "title" name = "title"/><br />
				            <label for="description">Description:</label> <input type="text" id = "description" name = "description" ><br />
				            <label for="city">City:</label> <input type="text" id = "city" name = "city" ><br />
				            <label for="eventstart">Start:</label> <input type="text" id = "eventstart" name = "eventstart"/><br />
				            <label for="eventend">End:</label> <input type="text" id = "eventend" name = "eventend"/><br />   
				            <script>
				            	/* shows time on datepicker, could be hidden using the alt-name input(hidden) and altformat parameter*/
					            $( "#eventstart" ).datepicker({dateFormat: "mm/dd/yy 00:00"});
					            $( "#eventend" ).datepicker({dateFormat: "mm/dd/yy 23:59"});
				            </script>


				            Tags: 
				            <select id="tag_select" onChange="tagPicked()">
	                           <?php
	                              include '../php/interests.php';
	                              getInterestsOptions();
	                           ?>
				            </select>
				            <input type="text" id = "tags" name = "tags" readonly/>
				            <a href="javascript:clearTags()">Clear</a><br />
				            <input type="hidden" id = "tagids" name = "tagids"/>
			            	<br />
				            <input type="submit" value="Search" />
				            <input type="reset" value="Clear All Fields" />
				         </div>
				      </form>
				<div style="clear:both;"></div>
					
				</div>
				<div style="clear:both;"></div>
			</div><!-- page content bro -->
		<?php include 'footer.html'; ?>
		</div> <!-- main -->
	</body>
</html>