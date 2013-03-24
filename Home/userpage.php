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
	if($row&&!$row['isAdmin'])
		echo 'Welcome '.$row['user_name'];
	else if ($row&&$row['isAdmin']){
		echo "You are admin";
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
					<a href="index.html" id="home">Home</a>
				</li>
				<li>
					<a href="#" id="email">Email</a>
				</li>
			</ul>
			<p>CS2102 Project Group 8</p>
			<div id="featured">
            <h1 align="center" id="title"><kbd>Room Booking System</kbd></h1>
			  <div class="first"></div>
			  <div>
			    <h3>Change User Info</h3>
			    <form action="changeUserInfo.php" method="post">
			      User Name:
			      <input name="new_user_name" type="text">
			      New Password:
			      <input name="new_password" type="text">
			      <input id="change" type="submit" value=""/>
		        </form>
		      </div>
			  <div>
			    <h3>My booking history</h3>
					<?php 
						//use php code to get the list of all bookings
					?>
		      </div>
			</div>
		</div> 

</body>
</html>  