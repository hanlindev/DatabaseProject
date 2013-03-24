<?php
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
	 	mysql_connect('127.0.0.1','root','');
	   mysql_select_db('CS2102');
	   $name = clear($_POST['name']);
	   $email = clear($_POST['email']);
	   $password = clear($_POST['password']);
	   $sql = mysql_query("SELECT * FROM user WHERE email = '$eamil'");
	if (!mysql_fetch_array($sql))
	{
		$password = sha1($_POST['password']);
		$sql2 = "INSERT INTO user (email, user_name, password) VALUES ('$email','$name', '$password')";
		mysql_query($sql2);
		mysql_close();
		echo 'You have been entered into our database.';
		sleep(2);
		header("location:home.php");
	}
	else {
		echo 'Name already in use.';
		header("location:index.html");
	}
}
?>