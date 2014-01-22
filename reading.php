<?php
//Handle database connections
include "db.php";

//Connect to the database
connectDB();

$title = "";
$content = "";
$media_id = "";
$data_received = false;

if(isset($_REQUEST['title'])) {
	//Grab the title (and make input safe)
	$title = strip_tags($_REQUEST['title']);

	if(isset($_REQUEST['content'])) {
		//Grab the content (and make input safe)
		$content = strip_tags($_REQUEST['content']);

		//Create a new media entry for the content
		$doc = array(
						"title" => $title,
						"content" => $content
					);

		//Insert the media entry and get it's ObjectId
		$media_id = insertIntoCollection("media", $doc);

		//Parse the text to pull the paragraphs and the individual words
		parseText($media_id, $content);

		//Know to print the howIKnowIt data rather than the error message
		data_received = true;
	} else {
		$content = "No content data received. Please return to the <a href='index.php'>home page</a>.";
	}
} else {
	$title = "No title data received. Please return to the <a href='index.php'>home page</a>.";
	$content = "No title data received. Please return to the <a href='index.php'>home page</a>.";
}

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
				if(data_received) {
					echo howiknowit($media_id);
				} else {
					echo $content;
				}
			?>
		</div>
	</div>
</body>
</html>