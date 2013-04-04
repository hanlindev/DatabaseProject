<?php
//set uo according to your own machine setting
include('config.php');

session_start();
function clear($message)
{
	if(!get_magic_quotes_gpc())
		$message = addslashes($message);
	
	$message = strip_tags($message);
	$message = htmlentities($message);
	return trim($message);
}
if(!$_SESSION['login'])
{
	header('Location: index.html');
	exit;
}
else
{
	$email = clear($_SESSION['login'][0]); 
	$password = clear($_SESSION['login'][1]);
	mysql_connect($localhost,$mysql_user_name,$mysql_password);
	mysql_select_db($schema);
	$sql = mysql_query("SELECT * FROM user WHERE email = '$email' AND password = '$password'");
	$row = mysql_fetch_array($sql);
	if($row&&!$row['isAdmin']){
		echo 'Welcome '.$row['user_name'];
		echo '<a href="checklogin?log=off">log off</a>
';

	}
	else if ($row&&$row['isAdmin']){
		echo "You are admin";
		echo '
<a href="checklogin?log=off">log off</a>
';
	}
	else 
	{
		header('Location: index.html');
		exit;
	}
}
?>
<!DOCTYPE html>

<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Hotel Booking</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>

<div class="header">
	<ul id="navigation">
		<li>
			<a href="home.php" id="home">Home</a>
		</li>
		<li>
			<a href="about.php" id="email">About</a>
		</li>
		<li>
			<a href="userpage.php" id="user">My Account</a>
		</li>
	</ul>
	<p>CS2102 Project Group 8</p>
</div>

<table border = "1" style = " position: fixed;
  top: 40%;
  left: 40%;
  margin-top: -50px;
  margin-left: -100px;">
	<tr>
		<th>Hotel ID</th>
		<th>Availability</th>
		<th>Room Class</th>
		<th>Bed Size</th>
		<th>No of Beds</th>
		<th>Book</th>
	</tr>

	<?php
require 'Modules/dbhandler.php';
$country = $_POST["country"]; 
$city = $_POST["city"];		  
$street = $_POST["street"];
$no_to_book = $_POST["no_to_book"];
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
$arrival_date = $_POST['arrival_date'];
$departure_date = $_POST['departure_date'];

$hotelInfo = dbhandler::getAssocArray('country', $country, 'city', $city, 'street', $street, 'star', $star);
$roomInfo = dbhandler::getAssocArray('room_class', $roomClass, 'bed_size', $bedSize, 'no_bed', $bedNo);
$hotelFeatures = dbhandler::getAssocArray('sustain_certified', $sustain, 'aircon', $aircon, 'meeting_rm', $meeting,
'pets_allowed', $pets, 'restaurant', $restaurant, 'car_park', $carpark, 'internet', $internet, 'child_facility', $child,
 'no_smoking', $nosmoking, 'biz_centre', $bizcentre, 'reduced_mobility_rm', $disabled, 'fitness_clus', $fitness,
 'swimming_pool', $swim, 'thalassotherapy_centre', $thalassotherapy, 'golf', $golf, 'tennis', $tennis);
$bookingInfo = dbhandler::getAssocArray('checkin', $arrival_date, 'checkout', $departure_date);

$dbh = new dbhandler();
$hotels = $dbh->
	findAvailableRooms($hotelInfo, $roomInfo, $hotelFeatures, $bookingInfo);
if (!$hotels) {
	echo "
	<p>Oops no hotel</p>
	";
} else {
foreach($hotels as $row) {
	$hotelid = $row["hotelid"];
	$availability = $row["availability"];
	$availability = (empty($availability)) ? $row["room_count"] : $availability;
	$room_class = $row['room_class'];
	$bed_size = $row['bed_size'];
	$no_bed = $row['no_bed'];
	//$hotelname = $row['hotelname'];

echo "
	<tr>
		<td>$hotelid</td>
		<td>$availability</td>
		<td>$room_class</td>
		<td>$bed_size</td>
		<td>$no_bed</td>
		<td>
			<button onclick=\"location.href='book.php?hotelid=".$hotelid."&availability=".$availability."&room_class=".$room_class."&bed_size=".$bed_size."&no_bed=".$no_bed."&arrival_date=".$arrival_date."&departure_date=".$departure_date."&no_to_book=".$no_to_book.'\'">Book</button>
		</td>
	</tr>
	';
}
}
   	 	
?>
</table>
</body>
</html>