<html>
<body>
	<h1>Login Status</h1>
	<?php
	require 'dbhandler.php';

	$dbh = new dbhandler();

	$hotelid = $_POST['hotelid'];
	$roomclass = $_POST['roomclass'];
	$bedsize = $_POST['bedsize'];
	$nobed = $_POST['nobed'];
	$roomdesc = '\''.$_POST['roomdesc'].'\'';
	$email = "'".$_POST['email']."'";
	$result = $dbh->insertIntoBooking("'12332'", $email, "'20130201'", "'20130210'", "'successful'");
	$dbh->sendQuery();
	?>
	<a href="../index.html">Back</a>
</body>
</html>