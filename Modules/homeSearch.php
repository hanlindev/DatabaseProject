<?php
	require 'dbhandler.php';
	function displayHotel($hotels) {
		if (!$hotels) {
			echo "<p> Oops no hotel</p>";
		} else {
			foreach($hotels as $row) {
				$id = $row["hotelid"];
				$availability = $row["availability"];
				echo "<p>$id have $availability left.</p>";
			}
		}
	}
	$country = $_POST["country"];
	$city = $_POST["city"];
	$street = $_POST["street"];
	$star = $_POST['star'];
	$roomClass = $_POST['room_class'];
	$bedSize = $_POST['bed_size'];
	$bedNo = $_POST['bed_no'];
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
	$arrival = $_POST['arrival_date'];
	$departure_date = $_POST['departure_date'];

	$hotelInfo = dbhandler::getAssocArray('country', $country, 'city', $city, 'street', $street, 'star', $star);
	$roomInfo = dbhandler::getAssocArray('room_class', $roomClass, 'bed_size', $bedSize, 'no_bed', $bedNo);
	$hotelFeatures = dbhandler::getAssocArray('sustain_certified', $sustain, 'aircon', $aircon, 'meeting_rm', $meeting,
	'pets_allowed', $pets, 'restaurant', $restaurant, 'car_park', $carpark, 'internet', $internet, 'child_facility', $child,
	 'no_smoking', $nosmoking, 'biz_centre', $bizcentre, 'reduced_mobility_rm', $disabled, 'fitness_clus', $fitness,
	 'swimming_pool', $swim, 'thalassotherapy_centre', $thalassotherapy, 'golf', $golf, 'tennis', $tennis);
	$bookingInfo = dbhandler::getAssocArray('checkin', $arrival, 'checkout', $departure_date);

	$dbh = new dbhandler();
	$hotels = $dbh->findAvailableRooms($hotelInfo, $roomInfo, $hotelFeatures, $bookingInfo);

	displayHotel($hotels[0]);
?>