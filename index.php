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
		<?php
			$media = getMedia();
			if(count($media) > 0) {}
				foreach($media as $title) {
					echo "<p class='media'>".$title."</p><br />";
				} 
			} else {
				echo "You have not added any media items yet.";
			}
		?>
	</div>


	<script type='text/javascript'>
		
	</script>
</body>
</html>