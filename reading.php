<?php
//Handle database connections
include "db.php";

//Connect to the database
connectDB();

//Grab the title
$title = $_REQUEST['title'];

//Grab the content
$content = $_REQUEST['content'];

//Create a new media entry for the content
$doc = array(
				"title" => $title,
				"content" => $content
			);

//Insert the media entry and get it's ObjectId
$media_id = insertIntoCollection("media", $doc);

//Parse the text to pull the paragraphs and the individual words
parseText($media_id, $content);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>How-I-Know-It: Smart Read!</title>
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
				echo howiknowit();
			?>
		</div>
	</div>
</body>
</html>