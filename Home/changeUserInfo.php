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
	if($row&&$_POST['submit']) {
		//change password here
		$new_user_name = $_POST['new_user_name'];
		$new_password = $_POST['new_password'];
		echo $new_user_name;
		echo $new_password;
	}
	else 
	{
		echo "You r not logged in, unable to change password";
		header('Location: userpage.php');
		exit;
	}
}
?>