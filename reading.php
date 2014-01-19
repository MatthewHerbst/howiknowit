<?php
//Handle database connections
include "db.php";

//Connect to the database
connectDB();

//Grab the title
$title = $_REQUEST['title'];

//Grab the content
$content = $_REQUEST['content'];


?>

!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>How-I-Know-It: Smart Read!</title>
	<script type='text/javascript' src='js/parseText.js'> </script>
</head>
<body>
	<!-- Nav bar -->
	<div id='navbar'>
		<a href='index.php'> Back To Home </a>
	</div>

	<!-- Where the content will be placed and viewed -->
	<div id='content'>
		<div id='title'>
			<h2> <?php echo $title; ?> </h2>
		</div>
		<div id='text'>
			<?php
				//postContent();
			?>
		</div>
	</div>
</body>
</html>