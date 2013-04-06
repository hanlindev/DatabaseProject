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
	<div id="header">
		<ul id="navigation">
			<li>
				<a href="home.php" id="home">Home</a>
			</li>
			<li>
				<a href="about.php" id="email">Email</a>
			</li>
			<li>
				<a href="userpage.php" id="user">My Account</a>
			</li>
		</ul>
		<p>CS2102 Project Group 8</p>
		<div id="featured">
			<h1 align="center" id="title">
				<kbd>Room Booking System</kbd>
			</h1>
			<div class="first"></div>
			<div>
				<h3>Change User Info</h3>
				<form action="changeUserInfo.php" method="post">
					User Name:
					<input name="new_user_name" type="text">
					New Password:
					<input name="new_password" type="password">
					<input name="change" type="submit" value="Submit"/>
				</form>
			</div>
			<div>

				<?php 
					//use php code to get the list of all bookings
					if ($isAdmin) {
						require 'drawAdminTable.php';
						drawTable();
					} else {
						require 'drawUserOrderTable.php';
						drawTable($email);
					}
					
			?></div>
		</div>
</div>

</body>
</html>