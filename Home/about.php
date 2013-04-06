<?php
//Check if the current user have the access to current page
include ('pageaccess.php');
?>

<!DOCTYPE html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Room Booking System</title>
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
<div class="content">
	<div id="about">
		<h2>Our Group</h2>

		<h3>CS2102 Project Group 8</h3>
		<p>We are a group of five students from NUS~</p>
		<p>Chen Xi</p>
		<p>Cui Wei</p>
		<p>Han Lin</p>
		<p>Liu Tuo</p>
		<p>Zhang Yue</p>
	</div>
</div>
</body>
</html>