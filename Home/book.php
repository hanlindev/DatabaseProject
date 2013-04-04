<?php
//include database configuration
include('config.php');
$hotelid = $_GET['hotelid'];
$availability = $_GET['availability'];
$room_class = $_GET['room_class'];
$bed_size = $_GET['bed_size'];
$no_bed = $_GET['no_bed'];
$departure_date = $_GET['depature_date'];
$arrival_date = $_GET['arrival_date'];
$no_to_book = $_GET['no_to_book'];
//For debuging
/*
echo $hotelid."\n";
echo $availability."\n";
echo $room_class."\n";
echo $bed_size."\n";
echo $no_bed."\n";
*/
//call book function
?>

