<?php
require '../Modules/dbhandler.php';
require 'valuenamemapping.php';
	
public function drawTable($email)
{
	$dbh = new new dbhandler();
	$booking = $dbh->
;

	if (empty($booking)){
		echo "
<h3>You Have Not Booked Any Rooms</h3>
";
		return;
	}
	else {
		echo "
<table>
	<thread>
		<tr>
			<th>Ref No</th>
			<th>Hotel Name</th>
			<th>Room Class</th>
			<th>Bed Size</th>
			<th>No of Beds</th>
			<th>No of Rooms Booked</th>
			<th>Check In Date</th>
			<th>Check Out Date</th>
			<th>Cancel Booking</th>
		</tr>
	</thread>
	<tbody>
		";
		foreach($booking as $row) {

			$ref=$row['ref'];
			$hotel_name = $row['hotelname'];
			$room_clas=$row['room_class'];
			$bed_size=$row['bed_size'];
			$no_reserving = $row['no_reserving'];
			$checkin_date    = $row['checkin_date'];
			$checkout_date   = $row['checkout_date'];
			$room_class_name = getRoomClassName($room_class);
			$bed_size_name   = getBedSizeName($bed_size);

			echo "
		<tr>
			<td>$ref</td>
			<td>$hotel_name</td>
			<td>$room_class_name</td>
			<td>$bed_size_name</td>
			<td>$no_bed</td>
			<td>$no_reserving</td>
			<td>$checkin_date</td>
			<td>$checkout_date</td>
			<td>
				<button onclick=\"location.href='cancelbook.php?ref=".$ref.'>Cancel Booking</button>
			</td>
		</tr>
		';
		}
	}
	echo "
	</tbody>
</table>
";
}
?>