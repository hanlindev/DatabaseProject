<html>

	<head></head>

	<body style = "color: yellow; font-size: 20px">

<?php //This block verify the user identity: match the email and password.
	require 'pageaccess.php';
	require '../Modules/dbhandler.php';
	
	$ref = $_REQUEST["referenceNo"];
	$checkIn = $_REQUEST["new_Checkin_date"];
	$checkOut = $_REQUEST["new_Checkout_date"];
	
	//echo $ref;
	echo $checkIn;
	echo $checkOut;
	try {
		$dbh = new dbhandler();
		if ($dbh->modifyDate($ref, $email, $isAdmin, $checkIn, $checkOut)){
			echo "<br/>Date of Order $ref has been succesfully changed<br/>";
			echo "<br/>The New Check In Date is $checkIn";
			echo "<br/>The New Check Out Date is $checkOut";
		}
	else {
		echo "<br/>Modify Date of order $ref failed!<br/>";
	}

	}
	catch (Exception $e){
		echo "<br/>Modify Date of order $ref failed!<br/>";
	}

	echo '<a href=userpage.php>Click Here To Go Back To User Page</a><br/>';


?>
</body>
</html>