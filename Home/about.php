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

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Cruise Vacation</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
	</head>
	<body>
		<div class="header">
			<ul id="navigation">
				<li>
					<a href="index.html"><img src="images/icon-home.gif" alt=""/></a>
				</li>
				<li>
					<a href="#"><img src="images/icon-mail.gif" alt=""/></a>
				</li>
			</ul>
			<p>CS2102 Project Group 8</p>
</div> 
		<div class="content">
			<div id="about">
				<h2>Our Group</h2>
				
				<h3>We Have Five Members</h3>
				<p>Write something here</p>
				
		
			</div>
		</div>
	</body>
</html>  