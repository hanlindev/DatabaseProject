<html>
<body>
	<h1>Login Status</h1>
	<?php
	require 'dbhandler.php';

	$username = $_POST['username'];
	$password = $_POST['password'];
	dbhandler::testClass($username, $password);
	?>
</body>
</html>