<html>
<body>
	<h1>Login Status</h1>
	<?php
	require 'dbhandler.php';

	$dbh = new dbhandler();
	$hotelname = $_POST['hotelname'];
	echo "<p>$hotelname</p>";
	$constraints = 'hotelname = \''.$hotelname.'\'';
	echo "<p>$constraints</p>";
	$dbh->deleteFromHotel($constraints);
	$dbh->sendQuery();
	echo "<p> $querycontent</p>";
	?>
	<a href="../index.html">Back</a>
</body>
</html>