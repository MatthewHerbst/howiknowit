<?php
//Handle database connections
include "db.php";

//Connect to the database
connectDB();

$word = $_GET['word'];
$media_id = $_GET['media_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>How-I-Know-It: <?php echo " " . $word; ?> </title>
</head>
<body>
	<!-- Nav bar -->
	<div id='navbar'>
		<a href='index.php'> Back To Home </a>
	</div>

	<!-- The list of locations where the word was found -->
	<div id='list'>
		<h3> How do you know <?php echo " " . $word; ?> 
		<?php
			//Get the list of media items this word is in
			$locations = whereIsThisWord($word);

			//Go through each location and print information about it to the page
			foreach($locations as $location) {
				echo 
					"<div class='location'>" .
						"<p class='title'><b>" . getTitle($location['media_id']) . "</b></p> <br />" .
						"<p class='paragraph'>" . getParagraph($location['paragraph_id']) . "</p> <br /><br />" .
					"</div>";
			}
		?>
	</div>
</body>
</html>