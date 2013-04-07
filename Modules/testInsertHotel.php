<html>
<body>
	<h1>Login Status</h1>
	<?php
	require 'dbhandler.php';

	$dbh = new dbhandler();

	$hotelname = '\''.$_POST['hotelname'].'\'';
	$country = '\''.$_POST['country'].'\'';
	$city='\''.$_POST['city'].'\'';
	$street = '\''.$_POST['street'].'\'';
	$star = $_POST['star'];
	$sustain = $_POST['sustain'];
	$aircon = $_POST['aircon'];
	$meeting = $_POST['meeting'];
	$pets = $_POST['pets'];
	$restaurant = $_POST['restaurant'];
	$carpark = $_POST['carpark'];
	$internet = $_POST['internet'];
	$child = $_POST['child'];
	$nosmoking = $_POST['nosmoking'];
	$bizcentre = $_POST['bizcentre'];
	$disabled = $_POST['disabled'];
	$fitness = $_POST['fitness'];
	$swim = $_POST['swim'];
	$thalassotherapy = $_POST['thalassotherapy'];
	$golf = $_POST['golf'];
	$tennis = $_POST['tennis'];
	//echo "<p> $name, $location, $star, $sustain, $aircon, $meeting, $pets, $restaurant, $carpark, $internet, $child, $nosmoking, $bizcentre, $disabled, $fitness, $swim, $thalassotherapy, $golf, $tennis</p>";
	$querycontent = $dbh->insertIntoHotel($name, $location, $star, $sustain, $aircon, $meeting, $pets, $restaurant, $carpark, $internet, $child, $nosmoking, $bizcentre, $disabled, $fitness, $swim, $thalassotherapy, $golf, $tennis);
	$dbh->sendQuery();
	?>
	<a href="../index.html">Back</a>
</body>
</html>