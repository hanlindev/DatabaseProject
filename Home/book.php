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
//include value name mapping function
require 'valuenamemapping.php';


/*-----  End of Include Files  ------*/



/*=========================================================
=            Collecting Data Using POST Method            =
=========================================================*/
$hotelid       = $_GET['hotelid'];
$availability  = $_GET['availability'];
$room_class    = $_GET['room_class'];
$bed_size      = $_GET['bed_size'];
$no_bed        = $_GET['no_bed'];
$checkin_date  = $_GET['checkin_date'];
$checkout_date = $_GET['checkout_date'];
$no_reserving  = $_GET['no_reserving'];
$hotelname     = $_GET['hotelname'];
//For debuging
/*
echo 'hotelid'.$hotelid."\n";
echo 'availability'.$availability."\n";
echo 'room_class'.$room_class."\n";
echo 'bed_size'.$bed_size."\n";
echo 'no_bed'.$no_bed."\n";
echo 'email'.$email."\n";
echo 'checkout_date'.$checkout_date."\n";
echo 'checkin_date'.$checkin_date."\n";
echo 'no_reserving'.$no_reserving."\n";
*/


/*-----  End of Collecting Data Using POST Method  ------*/

/*=================================================================
=            Pass The Booking Information To dbhandler            =
=================================================================*/

$dbh = new dbhandler();
try {
	if ($dbh->placeBooking($email, $hotelid, $room_class, $bed_size, $no_bed, $no_reserving, $checkin_date, $checkout_date)){
		echo '<br/>Your booking has been successully placed<br/>';
		echo 'You Have booked '.$no_reserving.' '.getRoomClassName($room_class).' rooms with '.$no_bed.' '.getBedSizeName($bed_size).' beds in .'.$hotelname."<br/>";
		echo '<a href=home.php>Click Here To Go Back To Home Page</a>'."<br/>";
	}
	else {
		echo '<br/>Your booking has failed! <br/>';
		echo '<a href=home.php>Click Here To Go Back To Home Page</a>'."<br/>";
	}
}  catch(Exception $e) {
	if (strcmp($e->getMessage(), "Empty query result") == 0) {
		echo 'We are sorry but we are unable to secure your booking because some other people have taken all vacant rooms.<br/>';
		echo '<a href=home.php>Click Here To Go Back To Home Page</a><br/>';
	}
}

/*-----  End of Pass The Booking Information To dbhandler  ------*/



?>

