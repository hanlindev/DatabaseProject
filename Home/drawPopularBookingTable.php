<?php 
/*==========  Setup  ==========*/
require '../Modules/dbhandler.php';
require 'valuenamemapping.php';
$dbh = new dbhandler();
$hotels = $dbh->topTen();
/*==========  Draw table  ==========*/
if (!$hotels) {
	return;
} else {
	$i = 1;
	foreach($hotels as $row) {

		$hotelid         = $row["hotelid"];
		$room_class      = $row['room_class'];
		$bed_size        = $row['bed_size'];
		$no_bed          = $row['no_bed'];
		$hotelname       = $row['hotelname'];
		$room_class_name = getRoomClassName($room_class);
		$bed_size_name   = getBedSizeName($bed_size);

		echo "
				<tr>
					<td>$i</td>
					<td>$hotelname</td>
					<td>$room_class_name</td>
					<td>$bed_size_name</td>
					<td>$no_bed</td>
				</tr>
				";
		$i++;
		}
}


?>