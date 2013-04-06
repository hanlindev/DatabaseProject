<html>

	<head></head>

	<body style = "color: yellow; font-size: 20px">

<?php //This block verify the user identity: match the email and password.

	$ref = $_REQUEST["referenceNo"];
	$checkIn = $_REQUEST["new_Checkin_date"];
	$checkOut = $_REQUEST["new_Checkout_date"];
	
	echo $ref;
	echo $checkIn;
	echo $checkOut;


?>
</body>
</html>