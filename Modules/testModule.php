<html>
<body>
	<h1>Login Status</h1>
	<?php
	require 'dbhandler.php';
	/*
	$username = $_POST['username'];
	$password = $_POST['password'];
	$name = '\''.$_POST['name'].'\'';
	$location = '\''.$_POST['location'].'\'';
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
	$querycontent = dbhandler::insertIntoHotel($name, $location, $star, $sustain, $aircon, $meeting, $pets, $restaurant, $carpark, $internet, $child, $nosmoking, $bizcentre, $disabled, $fitness, $swim, $thalassotherapy, $golf, $tennis);
	*/
	/*
	$hotelname = $_POST['hotelname'];
	$constraints["hotelname"] = 'hotelname = \''.$hotelname.'\'';
	dbhandler::deleteFromHotel($constraints);
	echo "<p> $querycontent</p>";
	*/
	$hotelid = $_POST['hotelid'];
	$roomclass = $_POST['roomclass'];
	$bedsize = $_POST['bedsize'];
	$nobed = $_POST['nobed'];
	$roomdesc = '\''.$_POST['roomdesc'].'\'';
	$roomcount = $_POST['roomcount'];
	$result = dbhandler::insertIntoFacility($hotelid, $roomclass, $bedsize, $nobed, $roomdesc, $roomcount);
	echo "<p> $result </p>";
	?>
</body>
</html>