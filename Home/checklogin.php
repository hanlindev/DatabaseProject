<?php

	//set uo according to your own machine setting
	$localhost = '127.0.0.1';
	$mysql_user_name = 'root';
	$mysql_password  = '';
	$database_name = 'CS2102';

	ob_start();
	session_start();
	$log = $_GET['log'];
	function clear($message)
	{
		if(!get_magic_quotes_gpc())
			$message = addslashes($message);
		$message = strip_tags($message);
		$message = htmlentities($message);
		return trim($message);
	}
	if($log == 'off')
	{
		unset($_SESSION['login']);
		setcookie('login', '', time() - 86400);
		session_destroy();
		session_regenerate_id(true);
		ob_end_clean();
		echo 'Logged out';
	}
	else if ($_POST['submit'])
	{
		mysql_connect($localhost,$mysql_user_name,$mysql_password);
		mysql_select_db($database_name);

		$email = clear($_POST['email']);
		$password = clear($_POST['password']);
		$password = sha1($_POST['password']);
		$result = mysql_query("SELECT * FROM user WHERE email = '$email' AND password = '$password'");
		if($output = mysql_fetch_array($result))
		{
			session_regenerate_id(true);
			ob_end_clean();
			echo "Successfully Logged In!\n";
			echo 'Welcome ' . $output['email']."\n";
			//echo 'isAdmin'.$output['isAdmin'];
			echo '<a href="?log=off">log off</a>'."\n";
			
			$_SESSION['login'] = array($email, $password);
			echo '<a href=home.php>Go to Home page</a>'."\n";
		}
		else
			echo 'Login failed';
	}
	else
	{
		ob_end_clean();
		header("location:index.html");
	}
	
?>