<?php
// This module is used for handling interaction with the database
class dbhandler {
	// For security we can store these information outside the document
	// root but for simplicity we just store it here for now.
	private static $username = "root";
	private static $password = "789789789";
	private static $server = "localhost";
	private static $database = "CS2102";


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
	//---------------------------- INSERT QUERY---------------------------//
	/**
	 * insertIntoTable
	 * @param $tableName is the table into which we are inserting
	 * @param $attrList a list of attributes that are going to be inserted
	 * @param $rowInfo is the array of attribute values of the row that 
	 *        is going to be inserted. Please refer to the specification
	 *        of hotel table for the order of attributes. You have to
	 *        strictly follow the order of attributes!
	 * @return returns the result of sendQuery method
	 * A generic method used for inserting attributes to a specified
	 * table.
	 */
	private static function insertIntoTable($tableName, $attrList, $rowInfo) {
		$attrListString = dbhandler::getCommaSeparatedString($attrList);
		$rowInfoString = dbhandler::getCommaSeparatedString($rowInfo);

		$queryContent = " INSERT INTO $tableName($attrListString) VALUES($rowInfoString);";
		return dbhandler::sendQuery($queryContent);
	}

	/**
	 * getCommaSeparatedString
	 * @param $array contains the elements to be combined
	 * @return the comma separated string from the array of elements
	 * Combines the elements in the array into a comma separated string
	 */
	private static function getCommaSeparatedString($array) {
		$result = "";
		$comma = "";
		foreach ($array as $element) {
			$result .= $comma.$element;
			$comma = ",";
		}
		return $result;
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
	 * @param attributes of a hotel. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * @return return result of sendQuery method
	 * public interface to insert a row into hotel table
	 */
	public static function insertIntoHotel($name, $location, $star, $sustain, $aircon, 
		$meeting, $pets, $restaurant, $carpark, $internet, $child, $nosmoking, $bizcentre, 
		$disabled, $fitness, $swim, $thalassotherapy, $golf, $tennis) {
		$attrList = dbhandler::generateRowInfoArray("hotelname", "location", "star", "sustain_certified",
			"aircon", "meeting_rm", "pets_allowed", "restaurant", "car_park", "internet", "child_facility",
			"no_smoking", "biz_centre", "reduced_mobility_rm", "fitness_club", "swimming_pool",
			"thalassotherapy_centre", "golf", "tennis");
		$rowInfo = dbhandler::generateRowInfoArray($name, $location, $star, $sustain, $aircon, 
		$meeting, $pets, $restaurant, $carpark, $internet, $child, $nosmoking, $bizcentre, 
		$disabled, $fitness, $swim, $thalassotherapy, $golf, $tennis);
		return dbhandler::insertIntoTable("hotel", $attrList, $rowInfo);
	}

	/**
	 * insertIntoFacility
	 * @param attributes of a facility. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * @return return result of sendQuery method
	 * public interface to insert a row into facility table
	 */
	public static function insertIntoFacility($hotelid, $room_class, $bed_size, $no_bed, $room_desc, $room_count) {
		$attrList = dbhandler::generateRowInfoArray("hotelid", "room_class", "bed_size", "no_bed",
			"room_desc", "room_count");
		$rowInfo = dbhandler::generateRowInfoArray($hotelid, $room_class, $bed_size, $no_bed, $room_desc, $room_count);
		return dbhandler::insertIntoTable("facility", $attrList, $rowInfo);
	}

	/**
	 * insertIntoUser
	 * @param attributes of a user. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * @return return result of sendQuery method
	 * public interface to insert a row into user table
	 */
	public static function insertIntoUser($email, $password, $user_name, $isAdmin) {
		$attrList = dbhandler::generateRowInfoArray("email", "password", "user_name", "isAdmin");
		$rowInfo = dbhandler::generateRowInfoArray($email, $password, $user_name, $isAdmin);
		return dbhandler::insertIntoTable("user", $attrList, $rowInfo);
	}

	/**
	 * insertIntoBooking
	 * @param attributes of a booking. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * @return return result of sendQuery method
	 * public interface to insert a row into booking table
	 */
	public static function insertIntoBooking($ref, $uid, $checkin, $checkout, $status) {
		$attrList = dbhandler::generateRowInfoArray("ref", "uid", "checkin", "checkout", "status");
		$rowInfo = dbhandler::generateRowInfoArray($ref, $uid, $checkin, $checkout, $status);
		return dbhandler::insertIntoTable("booking", $attrList, $rowInfo);
	}

	/**
	 * insertIntoReserve
	 * @param attributes of a reserve. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * @return return result of sendQuery method
	 * public interface to insert a row into reserve table
	 */
	public static function insertIntoReserve($ref, $hotelid, $room_class, $bed_size, $no_bed, $count) {
		$attrList = dbhandler::generateRowInfoArray("ref", "hotelid", "room_class", "bed_size", "no_bed", "count");
	}

	//------------------------------ DELETE QUERY --------------------------------------
	/**
	 * deleteFromTable
	 * @param $tableName is the table from which we delete the row
	 * @param $where is the constraint of the delete query. For example if we want to delete
	 *        all rows whose value attribute is greater than 1 but smaller than 10, you should
	 *        pass "value > 1 AND value < 1". Don't forget the single quote enclosing string
	 *        values. Eg if delete rows whose name is 'good job', you should pass in
	 *        "name = \'good job\'".
	 * @return result returned by the query
	 * Deletes a row from the specified table whose properties match the constraints. The
	 * user of his code is responsible to write correct constraints.
	 */
	private static function deleteFromTable($where) {
		$queryContent = "DELETE FROM $tableName WHERE $where;";
		return dbhandler::sendQuery($queryContent);
	}

	/**
	 * deleteFromHotel
	 * @param $constraints obeys the contract of deleteFromTable method's $constraints
	 *        parameter. In short, pass the full constraint.
	 * @return result returned by the query
	 * Public interface provided to delete from hotel table
	 */
	public static function deleteFromHotel($constraints) {
		return dbhandler::deleteFromTable("hotel", $constraints);
	}

	public static function deleteFromFacility($constraints) {
		return dbhandler::deleteFromTable("facility", $constraints);
	}

	public static function deleteFromUser($constraints) {
		return dbhandler::deleteFromTable("user", $constraints);
	}

	public static function deleteFromBooking($constraints) {
		return dbhandler::deleteFromTable("booking", $constraints);
	}

	public static function deleteFromReserve($constraints) {
		return dbhandler::deleteFromTable("reserve", $constraints);
	}

	//--------------------------Modify Query-------------------------------------------
	/**
	 * updateTable
	 * @param $tableName the table we want to update
	 * @param $set the value we want to pass to the set close
	 * @param $where the value we want to pass to the where close
	 * Example: if the query looks like:
	 *    UPDATE student
	 *    SET departmet='Computer Science'
	 *    WHERE department='CS';
	 * Then $test should be "department='Computer Science'" and $where should be
	 * "department='CS'"
	 */
	private static function updateTable($tableName, $set, $where) {
		$queryContent = "UPDATE $tableName SET $set WHERE $where;";
		return dbhandler::sendQuery($queryContent);
	}

	/** 
	 * updateHotel
	 * @param $set is the content of the set close
	 * @param $where is the content of the where close
	 * @return the result of the query returned by the server
	 * Example: if the query looks like:
	 *    UPDATE student
	 *    SET departmet='Computer Science'
	 *    WHERE department='CS';
	 * Then $test should be "department='Computer Science'" and $where should be
	 * "department='CS'"
	 */
	public static function updateHotel($set, $where) {
		return dbhandler::updateTable("hotel", $set, $where);
	}

	/** 
	 * updateFacility
	 * @param $set is the content of the set close
	 * @param $where is the content of the where close
	 * @return the result of the query returned by the server
	 * Example: if the query looks like:
	 *    UPDATE student
	 *    SET departmet='Computer Science'
	 *    WHERE department='CS';
	 * Then $test should be "department='Computer Science'" and $where should be
	 * "department='CS'"
	 */
	public static function updateFacility($set, $where) {
		return dbhandler::updateTable("user", $set, $where);
	}

	/** 
	 * updateUser
	 * @param $set is the content of the set close
	 * @param $where is the content of the where close
	 * @return the result of the query returned by the server
	 * Example: if the query looks like:
	 *    UPDATE student
	 *    SET departmet='Computer Science'
	 *    WHERE department='CS';
	 * Then $test should be "department='Computer Science'" and $where should be
	 * "department='CS'"
	 */
	public static function updateUser($set, $where) {
		return dbhandler::updateTable("user", $set, $where);
	}

	/** 
	 * updateBooking
	 * @param $set is the content of the set close
	 * @param $where is the content of the where close
	 * @return the result of the query returned by the server
	 * Example: if the query looks like:
	 *    UPDATE student
	 *    SET departmet='Computer Science'
	 *    WHERE department='CS';
	 * Then $test should be "department='Computer Science'" and $where should be
	 * "department='CS'"
	 */
	public static function updateBooking($set, $where) {
		return dbhandler::updateTable("booking", $set, $where);
	}

	/** 
	 * updateReserve
	 * @param $set is the content of the set close
	 * @param $where is the content of the where close
	 * @return the result of the query returned by the server
	 * Example: if the query looks like:
	 *    UPDATE student
	 *    SET departmet='Computer Science'
	 *    WHERE department='CS';
	 * Then $test should be "department='Computer Science'" and $where should be
	 * "department='CS'"
	 * Well the only thing modifiable here is the count~~
	 */
	public static function updateReserve($set, $where) {
		return dbhandler::updateTable("reserve", $set, $where);
	}


}
?>