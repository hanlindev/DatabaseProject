<?php
require '../Modules/dbhandler.php';
require 'valuenamemapping.php';
	
function drawTable()
{
	$dbh = new dbhandler();
	try {
		$booking = $dbh->
findAllBooking();
	}
	catch(Exception $e){
				echo "
<h3>No Booking</h3>
";
		return;
	}


	if (empty($booking)){
		echo "
<h3>No Booking</h3>
";
		return;
	}
	else {
		echo "
<h3>Booking List For All Users</h3>
<table id=\"booking_list\">
	<thread>
		<tr>
			<th>Ref No</th>
			<th>User ID</th>
			<th>Hotel Name</th>
			<th>Room Class</th>
			<th>Bed Size</th>
			<th>No of Beds</th>
			<th>No of Rooms Booked</th>
			<th>Check In Date</th>
			<th>Check Out Date</th>
			<th>Modify Date</th>
			<th>Cancel Booking</th>
		</tr>
	</thread>
	<tbody>
		";
		$count = -1;
		foreach($booking as $row) {
			$count ++;
			$uid=$row['uid'];
			$ref=$row['ref'];
			$hotel_name = $row['hotelname'];
			$room_class=$row['room_class'];
			$bed_size=$row['bed_size'];
			$no_bed=$row['no_bed'];
			$no_reserving = $row['count'];
			$checkin_date    = $row['checkin'];
			$checkout_date   = $row['checkout'];
			$room_class_name = getRoomClassName($room_class);
			$bed_size_name   = getBedSizeName($bed_size);

			echo "
		<tr>
			<td name=\"refNo".$count."\">$ref</td>
			<td>$uid</td>
			<td>$hotel_name</td>
			<td>$room_class_name</td>
			<td>$bed_size_name</td>
			<td>$no_bed</td>
			<td>$no_reserving</td>
			<td>
				current check in date: ".$checkin_date.
			"
				<input name=\"checkin_date".$count."\" type=\"date\"  value =\"".$checkin_date."\" onchange=\"updateCheckInDate(this,".$count.")\"  ></td>
			<td>
				current check out date: ".$checkout_date.
			"
				<input name=\"checkout_date".$count."\" type=\"date\" value =\"".$checkout_date."\" onchange=\"updateCheckOutDate(this,".$count.")\"  ></td>

			<form action = \"modifydate.php\" method = \"post\">

				<td>
					<input type=\"submit\" name=\"submit\" value=\"modify date\"></td>
				<input type=\"hidden\" value=\"".$ref."\" name=\"referenceNo\" />
				<input type=\"hidden\" value=\"".$checkin_date."\" name=\"new_Checkin_date\" />
				<input type=\"hidden\" value=\"".$checkout_date."\" name=\"new_Checkout_date\" />
			</form>
			<td>
				<button onclick=\"location.href='cancelbook.php?ref=".$ref.'\'">Cancel Booking</button>
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

drawCancelledOrderTable(){
		$dbh = new dbhandler();
	try {
		$booking = $dbh->
findAllCanceledBooking();
	}
	catch(Exception $e){
				echo "
<h3>No Booking</h3>
";
		return;
	}


	if (empty($booking)){
		echo "
<h3>No Booking</h3>
";
		return;
	}
	else {
		echo "
<h3>Booking List For All Users</h3>
<table id=\"booking_list\">
	<thread>
		<tr>
			<th>Ref No</th>
			<th>User ID</th>
			<th>Hotel Name</th>
			<th>Room Class</th>
			<th>Bed Size</th>
			<th>No of Beds</th>
			<th>No of Rooms Booked</th>
			<th>Check In Date</th>
			<th>Check Out Date</th>
		</tr>
	</thread>
	<tbody>
		";

		foreach($booking as $row) {

			$uid=$row['uid'];
			$ref=$row['ref'];
			$hotel_name = $row['hotelname'];
			$room_class=$row['room_class'];
			$bed_size=$row['bed_size'];
			$no_bed=$row['no_bed'];
			$no_reserving = $row['count'];
			$checkin_date    = $row['checkin'];
			$checkout_date   = $row['checkout'];
			$room_class_name = getRoomClassName($room_class);
			$bed_size_name   = getBedSizeName($bed_size);

			echo "
		<tr>
			<td>$ref</td>
			<td>$uid</td>
			<td>$hotel_name</td>
			<td>$room_class_name</td>
			<td>$bed_size_name</td>
			<td>$no_bed</td>
			<td>$no_reserving</td>
			<td>$checkin_date</td>
			<td>$checkout_date</td>
		</tr>
		";
		}
	}
	echo "
	</tbody>
</table>
";
}
?>