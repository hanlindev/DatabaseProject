<?php
/*===========================================
=           Include Files            =
===========================================*/

//Check if the current user have the access to current page
include ('pageaccess.php');
//include database configuration
include('config.php');
//include dbhandler
require '../Modules/dbhandler.php';


/*-----  End of Include Files  ------*/



/*=========================================================
=            Collecting Data Using POST Method            =
=========================================================*/
$hotelid = $_GET['hotelid'];
$availability = $_GET['availability'];
$room_class = $_GET['room_class'];
$bed_size = $_GET['bed_size'];
$no_bed = $_GET['no_bed'];
$departure_date = $_GET['depature_date'];
$arrival_date = $_GET['arrival_date'];
$no_reserving = $_GET['no_reserving'];
//For debuging
/*
echo 'hotelid'.$hotelid."\n";
echo 'availability'.$availability."\n";
echo 'room_class'.$room_class."\n";
echo 'bed_size'.$bed_size."\n";
echo 'no_bed'.$no_bed."\n";
echo 'email'.$email."\n";
echo 'departure_date'.$departure_date."\n";
echo 'arrival_date'.$arrival_date."\n";
echo 'no_reserving'.$no_reserving."\n";
*/


/*-----  End of Collecting Data Using POST Method  ------*/

/*=================================================================
=            Pass The Booking Information To dbhandler            =
=================================================================*/

$dbh = new dbhandler();
if ($dbh->placeBooking($email, $hotelid, $room_class, $bed_size, $no_bed, $no_reserving, $arrival_date, $departure_date)){
	echo 'Your booking has been successully placed';
}
else {
	echo 'Your booking has failed! ';
	echo '<a href=home.php>Click Here To Go Back To Home Page</a>'
}

/*-----  End of Pass The Booking Information To dbhandler  ------*/



?>

