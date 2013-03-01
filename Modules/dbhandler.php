<?php
// This module is used for handling interaction with the database
class dbhandler {
	// For security we can store these information outside the document
	// root but for simplicity we just store it here for now.
	private static $username = "root";
	private static $password = "789789789";
	private static $server = "localhost";
	private static $database = "testProject";


	/**
	 * sendQuery
	 * @param $queryContent is the complete content of the query as
	 *        a string
	 * @param result of query, false on failure, mysqli_result object
	 *        on successful SELECT, SHOW, DESCRIBE, EXPLAIN queries,
	 *        and true on other successful queries.
	 * Send the query to our server. This is the backend method. So
	 * you should not use this to send your query directly. Use the
	 * public methods instead.
	 */
	private static function sendQuery($queryContent) {
		$mysqli = new mysqli(dbhandler::$server, dbhandler::$username, dbhandler::$password, dbhandler::$database);
		if ($mysqli->connect_error) {
			die('Connect error ('.$mysqli->connect_errno.') '.$mysqli->connect_error);
		}
		$queryResult = $mysqli->query($queryContent);
		$mysqli->close();
		//return $queryResult;
		return $queryContent;//for debugging
	}

	/**
	 * insertIntoHotel
	 * @param $tableName is the table into which we are inserting
	 * @param $rowInfo is the array of attribute values of the row that 
	 *        is going to be inserted. Please refer to the specification
	 *        of hotel table for the order of attributes. You have to
	 *        strictly follow the order of attributes!
	 * @return returns the result of sendQuery method
	 * A generic method used for inserting attributes to a specified
	 * table.
	 */
	private static function insertIntoTable($tableName, $rowInfo) {
		$queryContent = "INSERT INTO $tableName VALUES(";
		$comma = "";
		foreach ($rowInfo as $info) {
			$queryContent .= $comma.'\''.$info.'\'';
			$comma = ",";
		}
		$queryContent .= ");";
		return dbhandler::sendQuery($queryContent);
	}

	/**
	 * generateRowInfoArray
	 * @param a variable-length list of attributes in the order specified by
	 *        the table definition.
	 * @return the info array containing the attributes
	 * We can do this in all our public methods but it's not a good idea.
	 * We'd better have a strict rule on parameter passing for those methods.
	 */
	private static function generateRowInfoArray() {
		$attributes = func_get_args();
		return $attributes;
	}

	/**
	 * insertIntoHotel
	 * @param attributes of a hotel
	 * @return return result of sendQuery method
	 * public interface to insert a row into hotel table
	 */
	public static function insertIntoHotel($name, $location, $star, $swimming_pool, $fitness_club, $buffet_restaurant, $restaurant) {
		$rowInfo = dbhandler::generateRowInfoArray($name, $location, $star, $swimming_pool, $fitness_club, $buffet_restaurant, $restaurant);
		return dbhandler::insertIntoTable("hotel", $rowInfo);
	}

	public static function testClass($username, $password) {
		echo "<p>lalala( ".$username." hohoho ".$password." wuwuwuwu</p>";
	}
}
