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
			<a href="#" id="email">Email</a>
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
				<input name="change" type="submit" value=""/>
			</form>
		</div>
		<div>
			<h3>My booking history</h3>
			<?php 
						//use php code to get the list of all bookings
			?></div>
	</div>
</div>

</body>
</html>