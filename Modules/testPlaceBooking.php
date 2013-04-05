<?php
require 'dbhandler.php';
$dbh = new dbhandler();
/*
$userid = $_POST['email'];
$hotelid = $_POST['hotelid'];
$room_class = $_POST['room_class'];
$bed_size = $_POST['bed_size'];
$no_bed = $_POST['no_bed'];
$no_res = $_POST['no_res'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
*/

$userid = 'hanlin.ta@gmail.com';
$hotelid = 1;
$room_class = 1;
$bed_size = 2;
$no_bed = 1;
$no_res = 2;
$checkin = '2013-02-03';
$checkout = '2013-02-09';

$rv = $dbh->placeBooking($userid, $hotelid, $room_class, $bed_size, $no_bed, $no_res, $checkin, $checkout);
echo "$rv";
?>