<?php
// This module is used for handling interaction with the database
class dbhandler {
	// For security we can store these information outside the document
	// root but for simplicity we just store it here for now.
	private static $username = "root";
	private static $password = "CHENxi0810";
	private static $server = localhost;
	private static $database = "hotel";


	/**
	 * sendQuery
	 * @param $queryContent is the complete content of the query as
	 *        a string
	 * Send the query to our server. This is the backend method. So
	 * you should not use this to send your query directly. Use the
	 * public methods instead.
	 */
	private static function sendQuery($queryContent) {
		mysql_connect($server,$username, $password);
		@mysql_select_db($database) or die("Unable to select database");
		mysql_query($queryContent);
		mysql_close();
	}

	/**
	 * insertIntoHotel
	 * @param $tableName is the table into which we are inserting
	 * @param $rowInfo is the array of attribute values of the row that 
	 *        is going to be inserted. Please refer to the specification
	 *        of hotel table for the order of attributes. You have to
	 *        strictly follow the order of attributes!
	 * A generic method used for inserting attributes to a specified
	 * table.
	 */
	private static function insertIntoTable($tableName, $rowInfo) {
		
	}

	public static function testClass($username, $password) {
		echo "<p>lalala ".$username." hohoho ".$password." wuwuwuwu</p>";
	}
}
