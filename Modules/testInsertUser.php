<html>
<body>
	<h1>Login Status</h1>
	<?php
	require 'dbhandler.php';

	$dbh = new dbhandler();
	
	$email = "'".$_POST['email']."'";
	$password = "'".$_POST['password']."'";
	$realname = "'".$_POST['realname']."'";
	$result = $dbh->insertIntoUser($email, $password, $realname, 0);
	$dbh->sendQuery();
	?>
	<a href="../index.html">Back</a>
</body>
	