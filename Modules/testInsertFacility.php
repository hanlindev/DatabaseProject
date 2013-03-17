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
	$roomcount = $_POST['roomcount'];
	$result = $dbh->insertIntoFacility($hotelid, $roomclass, $bedsize, $nobed, $roomdesc, $roomcount);
	$dbh->sendQuery();
	?>
	<a href="../index.html">Back</a>
</body>
</html>