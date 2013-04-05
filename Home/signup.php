<?php
/**
*
* This PHP script add the user information to the database system
* including the user name, use email (which is also the uid) and password
*
**/

//set uo according to your own machine setting
include('config.php');


function clear($message)
{
	if(!get_magic_quotes_gpc())
	{
		$message = addslashes($message);
	}
	$message = strip_tags($message);
	$message = htmlentities($message);
	return trim($message);
}
if ($_POST['submit'])
{
	   mysql_connect($localhost,$mysql_user_name,$mysql_password);
	   mysql_select_db($schema);

	   $name = clear($_POST['name']);
	   $email = clear($_POST['email']);
	   $password = clear($_POST['password']);
	   $sql = mysql_query("SELECT * FROM user WHERE email = '$email'");
	if (!mysql_fetch_array($sql))
	{
		$password = sha1($_POST['password']);
		$sql2 = "INSERT INTO user (email, user_name, password) VALUES ('$email','$name', '$password')";
		mysql_query($sql2);
		mysql_close();
		echo 'You have been entered into our database.';
		
		echo '<a href="index.html">Go back to Login page</a>';
	}
	else {
		echo 'Name already in use.';
		echo '<a href="index.html">Go back to Sign Up page</a>';
	}
}
?>