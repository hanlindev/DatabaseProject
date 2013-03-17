<html>
<body>
	<h1>Login Status</h1>
	<?php
	require 'dbhandler.php';

	$dbh = new dbhandler();
	$result = $dbh->updateHotel("star=4", "hotelname='Hotel China' AND star=5");
	$dbh->sendQuery();
	?>
	<a href="../index.html">Back</a>
</body>
</html>