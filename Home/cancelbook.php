<?php
	require 'pageaccess.php';
	require '../Modules/dbhandler.php';

	$ref = $_GET['ref'];
	$dbh = new dbhandler();
	if ($dbh->cancelOrder($ref, $email, $isAdmin)){
		echo "<br/>Order $ref has been succesfully canceled<br/>";
	}
	else {
		echo "<br/>Cancel order $ref failed!<br/>";
	}

	echo '<a href=userpage.php>Click Here To Go Back To User Page</a><br/>';

?>