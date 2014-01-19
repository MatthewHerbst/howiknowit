<?php
//Handle database connections
include "db.php";

//Connect to the database
connectDB();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>How-I-Know-It</title>
</head>
<body>
	<p>How-I-Know-It is a service meant to be integrated with an online reading platform. Do you ever find yourself halfway through Dante's Inferno,
	wondering how you know the name of the person he just found in the depths of Hell? Sure, any platform today gives you the ability the click the
	word and will then promptly show you the Wikipedia entry, but that's not really what you're looking for, is it? What you want to know is where
	and when you've come across this person's name in the past. This is the purpose of How-I-Know-It. Currently, you can demo the technology by
	entering a story. The story is then displayed to you with special words giving you the ability to see where they have come up in other stories.</p>
	<br />
	
	<!-- Form for submitting new content which the user can then read -->
	<div id='form'>
		<form action='reading.php' method='post' >
			Title <input type='text' name='title' required> <br />
			Please paste the document text <br />
			<textarea id='content' name='content' cols='100' rows='20' required> </textarea> <br />
			<button type="submit">Know it now!</button>
            <!-- <input type='hidden' name='cmd' value='process' /> -->
		</form>
	</div>

	<!-- List of content that the user has submitted -->
	<div id='mydocs'>
		<h3>My Media</h3>
		<?php
			$media = getMedia();
			if(count($media) > 0) {
				$title = "title";
				for($i = 0; $i < count($media); ++$i) {
					echo "<p class='media'>" . $media[$i] . "</p><br />";
				} 
			} else {
				echo "You have not added any media items yet.";
			}
		?>
	</div>
</body>
</html>