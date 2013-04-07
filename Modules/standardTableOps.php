<?php
require "dbhandler.php";
$dbh = new dbhandler();

function standardOperation($operation) {
	$table = $_POST['table'];
	switch($opeartion) {
		case "INSERT":
			return insertTo($table);
			break;
		case "UPDATE":
			return update($table);
			break;
		case "DELETE":
			return deleteFrom($table);
			break;
	}
}

function insertTo($table) {
	try {
		switch($table) {
			case "hotel":
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

				$dbh->insertIntoHotel($name, $location, $star, $sustain, $aircon, $meeting, $pets, $restaurant, $carpark, $internet, $child, $nosmoking, $bizcentre, $disabled, $fitness, $swim, $thalassotherapy, $golf, $tennis);
				$dbh->sendQueries();
				return true;
			case "facility":
				$hotelid = $_POST['hotelid'];
				$roomclass = $_POST['roomclass'];
				$bedsize = $_POST['bedsize'];
				$nobed = $_POST['nobed'];
				$roomdesc = '\''.$_POST['roomdesc'].'\'';
				$roomcount = $_POST['roomcount'];

				$dbh->insertIntoFacility($hotelid, $roomclass, $bedsize, $nobed, $roomdesc, $roomcount);
				$dbh->sendQuery();
				return true;
			case "reserve":
				$ref = $_POST['ref'];
				$ref = "$ref";

		}
	}
}