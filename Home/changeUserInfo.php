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
	if($row) {
		//change password here
		$new_user_name = $_POST['new_user_name'];
		$new_password = $_POST['new_password'];
		$new_password = sha1($new_password);
		//echo $new_user_name;
		//echo $new_password;
		$sql = mysql_query("UPDATE user SET user_name = '$new_user_name', password = '$new_password' WHERE email = '$email'");
		echo 'Your User Name and Password has been successfully changed';
		echo '<a href="index.html">Go back to Login page</a>';
	}
	else 
	{
		echo "You r not logged in, unable to change password";
		header('Location: userpage.php');
		exit;
	}
}
?>