<?php
/**
*
* This PHP script checks if the current user has the right to visit this page
* Usually pages require user to login in to the system will call this script
* User will be redirected back to the login page if he fails to login in
*
**/

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
		$isAdmin = $row['isAdmin'];
		echo 'Welcome '.$row['user_name'];
		echo '<a href="checklogin.php?log=off">log off</a>
';
	}
	else if ($row&&$row['isAdmin']){
		$isAdmin = $row['isAdmin'];
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