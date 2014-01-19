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
	<title>How-I-Know-It</title>
</head>
<body>
	<div id='list'>
		<?php
			$locations = whereIsThisWord($word);
		?>
	</div>
</body>
</html>