<html>
<body>
	<h1>Login Status</h1>
	<?php
	require 'dbhandler.php';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$location = $_POST['location'];
	$star = $_POST['star'];
	$swimmingpool = $_POST['swimmingpool'];
	$fitnessclub = $_POST['fitnessclub'];
	$buffetrestaurant = $_POST['buffetrestaurant'];
	$restaurant = $_POST['restaurant'];
	$querycontent = dbhandler::insertIntoHotel($name, $location, $star, $swimmingpool, $fitnessclub, $buffetrestaurant, $restaurant);
	echo "<p> $name $location $star $swimmingpool $fitnessclub $buffetrestaurant $restaurant $querycontent''</p>";
	?>
</body>
</html>