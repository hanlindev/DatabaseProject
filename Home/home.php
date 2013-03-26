<?php
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
	mysql_connect('127.0.0.1','root','');
	mysql_select_db('CS2102');
	$sql = mysql_query("SELECT * FROM user WHERE email = '$email' AND password = '$password'");
	$row = mysql_fetch_array($sql);
	if($row&&!$row['isAdmin']){
		echo 'Welcome '.$row['user_name'];
		echo '<a href="checklogin?log=off">log off</a>';
	}
	else if ($row&&$row['isAdmin']){
		echo "You are admin";
		echo '<a href="checklogin?log=off">log off</a>';
	}
	else 
	{
		header('Location: index.html');
		exit;
	}
}
?>

<!DOCTYPE html>

<html><head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Room Booking System</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
	</head>
	<body>
		<div id="header">
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
			<div id="featured">
            <h1 align="center" id="title"><kbd>Room Booking System</kbd></h1>
			  <div class="first"></div>
			  <div>
              
				  <h3>Find A Hotel Room</h3>
			    <form action="">
				    Country:
				    <input id="location" name="country" type="text" value=""/>
				    City:
				    <input id="location" name="city" type="text" value=""/>
				    Street:
				    <input id="location" name="street"  type="text" value=""/>
                    Hotel Stars:
                    <select name = "star" id="room_class">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                    </select>
				    Room Class:
				    <select name="room_class" id="room_class">
				      <option value="0">Standard</option>
				      <option value="1">Superior</option>
				      <option value="2">Deluxe</option>
				      <option value="3">Executive</option>
				      <option value="4">Presidential</option>
			        </select>
				    
                    Room Category:
				    <select name="room_category" id="room_class">
				      <option value="0">Single</option>
				      <option value="1">Double</option>
				      <option value="2">Queen</option>
				      <option value="3">Olympic Queen</option>
				      <option value="4">King</option>
				      <option value="5">California King</option>
			        </select>
				    Bed Number:
				    <select name="bed_no" id="room_class">
				      <option value="1">1</option>
				      <option value="2">2</option>
				      <option value="3">3</option>
				      <option value="4">4</option>
				      <option value="5">5</option>
				      <option value="6">6</option>
				      <option value="7">6+</option>
			        </select>
			        Sustainable Certified: <input type="hidden" name="sustain" value="0">
					                       <input type="checkbox" name="sustain" value="1">
					Air Conditioner: <input type="hidden" name="aircon" value="0">
					                 <input type="checkbox" name="aircon" value="1">
					Meeting Room: <input type="hidden" name="meeting" value="0">
					              <input type="checkbox" name="meeting" value="1">
					Pets Allowed: <input type="hidden" name="pets" value="0">
					              <input type="checkbox" name="pets" value="1">
					Restaurant: <input type="hidden" name="restaurant" value="0">
					            <input type="checkbox" name="restaurant" value="1">
					Car Park: <input type="hidden" name="carpark" value="0">
					            <input type="checkbox" name="carpark" value="1">
					Internet: <input type="hidden" name="internet" value="0">
					            <input type="checkbox" name="internet" value="1">
					Child Facilities: <input type="hidden" name="child" value="0">
					            <input type="checkbox" name="child" value="1">
					100% No Smoking: <input type="hidden" name="nosmoking" value="0">
					            <input type="checkbox" name="nosmoking" value="1">
					Business Centre: <input type="hidden" name="bizcentre" value="0">
					            <input type="checkbox" name="bizcentre" value="1">
					Reduced Mobility Rooms: <input type="hidden" name="disabled" value="0">
					            <input type="checkbox" name="disabled" value="1">
					Fitness Club: <input type="hidden" name="fitness" value="0">
					            <input type="checkbox" name="fitness" value="1">
					Swimming Pool: <input type="hidden" name="swim" value="0">
					            <input type="checkbox" name="swim" value="1">
					Thalassotherapy Centre: <input type="hidden" name="thalassotherapy" value="0">
					            <input type="checkbox" name="thalassotherapy" value="1">
					Golf: <input type="hidden" name="golf" value="0">
					            <input type="checkbox" name="golf" value="1">
					Tennis: <input type="hidden" name="tennis" value="0">
		            <input type="checkbox" name="tennis" value="1">
				    Arrival Date:
				    <input id="date" name="arrival_date" type="date" />
				    Departure Date: d
				    <input id="date" name="departure_date" type="date" />
					<input id="search" type="submit" value=""/>
		        </form>
				  
				</div>
			</div>
		</div> 

</body>
</html>  