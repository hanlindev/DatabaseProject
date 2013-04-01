<?php
	//set uo according to your own machine setting
	$localhost = '127.0.0.1';
	$mysql_user_name = 'root';
	$mysql_password  = '';
	$database_name = 'CS2102';

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
	mysql_select_db($database_name);
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
	<div class="search">
    	<ul id="search_result">
        	//search result here!
        </ul>
	
	</body>
</html>  