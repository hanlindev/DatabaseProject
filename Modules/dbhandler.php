<?php
// This module is used for handling interaction with the database
class dbhandler {
	// For security we can store these information outside the document
	// root but for simplicity we just store it here for now.
	private static $username = 'root';
	private static $password = '';
	private static $server = 'localhost';
	private static $database = 'CS2102';

	private $queryQueue;

	function __construct() {
		$this->queryQueue = array();
	}

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
	public function sendQuery($queryContent) {
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
	 * sendQueries
	 * @return query results of all queued queries as an array if transaction is successful,
	 *         throws exception when query fails.
	 *         Each element in the array is an array of rows in the result set indexed by the
	 *         column names as well as 0-indexed column numbers.
	 */
	private function sendQueries() {
		//PDO transaction
		//Start connection
		try {
			$serverName = dbhandler::$server;
			$dbName = dbhandler::$database;
			$options = array(PDO::ATTR_AUTOCOMMIT=>FALSE);
			$dbh = new PDO("mysql:host=$serverName;dbname=$dbName", dbhandler::$username, dbhandler::$password, $options);
		} catch (PDOException $e) {
			echo "Error connecting to database: ".$e->getMessage()."<br/>";
			die();
		}

		//Transaction
		try {
			$queryResults = array();
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$dbh->beginTransaction();

			foreach ($this->queryQueue as $query) {
				// Check query type
				$queryType = $this->getQueryType($query);
				$aResult;
				if (strcmp($queryType, "SELECT") == 0) 
				{
					$aResult = $dbh->query($query);
					$resultArray = $aResult->fetchAll();
					if (empty($resultArray)) {
						throw new Exception("Empty query result");
					}
					array_push($queryResults, $resultArray);
				} else {
					$aResult = $dbh->exec($query);
					if ($aResult == 0) {
						throw new Exception("Empty query result");
					} else {
						array_push($queryResults, true);
					}
				}
			}
			$dbh->commit();
			$this->queryQueue = array();
			return $queryResults;
		} catch(Exception $e) {
			$this->queryQueue = array();
			$dbh->rollBack();
			throw $e;
		}
	}

	/**
	 * getQueryType
	 * @param query is the query string
	 * @return the first word in the query string which is always the type of query
	 */
	private function getQueryType($query) {
		$arr = explode(' ',trim($query));
		return $arr[0];
	}

	/**
	 * queueQuery
	 * Queries are sent in transactions, so the user code need to queue queries by calling
	 * the query methods and at last, call sendQuery method to commit this transaction.
	 */
	private function queueQuery($queryContent) {
		array_push($this->queryQueue, $queryContent);
		return "Query queued";
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
	 * A generic method used for inserting attributes to a specified
	 * table.
	 */
	private function insertIntoTable($tableName, $attrList, $rowInfo) {
		$attrListString = dbhandler::getCommaSeparatedString($attrList);
		$rowInfoString = dbhandler::getCommaSeparatedString($rowInfo);

		$queryContent = " INSERT INTO $tableName($attrListString) VALUES($rowInfoString);";
		$this->queueQuery($queryContent);
		return $queryContent;
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
	 * public interface to insert a row into hotel table
	 */
	public function insertIntoHotel($name, $country, $city, $street, $star, $sustain, $aircon, 
		$meeting, $pets, $restaurant, $carpark, $internet, $child, $nosmoking, $bizcentre, 
		$disabled, $fitness, $swim, $thalassotherapy, $golf, $tennis) {
		$attrList = dbhandler::generateRowInfoArray("hotelname", "country", "city", "street", "star", "sustain_certified",
			"aircon", "meeting_rm", "pets_allowed", "restaurant", "car_park", "internet", "child_facility",
			"no_smoking", "biz_centre", "reduced_mobility_rm", "fitness_club", "swimming_pool",
			"thalassotherapy_centre", "golf", "tennis");
		$rowInfo = dbhandler::generateRowInfoArray($name, $street, $star, $sustain, $aircon, 
		$meeting, $pets, $restaurant, $carpark, $internet, $child, $nosmoking, $bizcentre, 
		$disabled, $fitness, $swim, $thalassotherapy, $golf, $tennis);
		return $this->insertIntoTable("hotel", $attrList, $rowInfo);
	}

	/**
	 * insertIntoFacility
	 * @param attributes of a facility. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * public interface to insert a row into facility table
	 */
	public function insertIntoFacility($hotelid, $room_class, $bed_size, $no_bed, $room_desc, $room_count) {
		$attrList = dbhandler::generateRowInfoArray("hotelid", "room_class", "bed_size", "no_bed",
			"room_desc", "room_count");
		$rowInfo = dbhandler::generateRowInfoArray($hotelid, $room_class, $bed_size, $no_bed, $room_desc, $room_count);
		return $this->insertIntoTable("facility", $attrList, $rowInfo);
	}

	/**
	 * insertIntoUser
	 * @param attributes of a user. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * public interface to insert a row into user table
	 */
	public function insertIntoUser($email, $password, $user_name, $isAdmin) {
		$attrList = dbhandler::generateRowInfoArray("email", "password", "user_name", "isAdmin");
		$rowInfo = dbhandler::generateRowInfoArray($email, $password, $user_name, $isAdmin);
		return $this->insertIntoTable("user", $attrList, $rowInfo);
	}

	/**
	 * insertIntoBooking
	 * @param attributes of a booking. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * public interface to insert a row into booking table
	 */
	public function insertIntoBooking($ref, $uid, $checkin, $checkout, $status) {
		$attrList = dbhandler::generateRowInfoArray("ref", "uid", "checkin", "checkout", "status");
		$rowInfo = dbhandler::generateRowInfoArray($ref, $uid, $checkin, $checkout, $status);
		return $this->insertIntoTable("booking", $attrList, $rowInfo);
	}

	/**
	 * insertIntoReserve
	 * @param attributes of a reserve. NOTE: the user is responsible to ensure the attributes
	 *        are of the correct types. Speciically, strings should already have single
	 *        quotes enclosing them; dates should be in the correct format etc.
	 * public interface to insert a row into reserve table
	 */
	public function insertIntoReserve($ref, $hotelid, $room_class, $bed_size, $no_bed, $count) {
		$attrList = dbhandler::generateRowInfoArray("ref", "hotelid", "room_class", "bed_size", "no_bed", "count");
		$rowInfo = dbhandler::generateRowInfoArray($ref, $hotelid, $room_class, $bed_size, $no_bed, $count);
		return $this->insertIntoTable("reserve", $attrList, $rowInfo);
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
	private function deleteFromTable($tableName, $where) {
		$queryContent = "DELETE FROM $tableName WHERE $where;";
		return $this->queueQuery($queryContent);
	}

	/**
	 * deleteFromHotel
	 * @param $constraints obeys the contract of deleteFromTable method's $constraints
	 *        parameter. In short, pass the full constraint.
	 * @return result returned by the query
	 * Public interface provided to delete from hotel table
	 */
	public function deleteFromHotel($constraints) {
		return $this->deleteFromTable("hotel", $constraints);
	}

	public function deleteFromFacility($constraints) {
		return $this->deleteFromTable("facility", $constraints);
	}

	public function deleteFromUser($constraints) {
		return $this->deleteFromTable("user", $constraints);
	}

	public function deleteFromBooking($constraints) {
		return $this->deleteFromTable("booking", $constraints);
	}

	public function deleteFromReserve($constraints) {
		return $this->deleteFromTable("reserve", $constraints);
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
	private function updateTable($tableName, $set, $where) {
		$queryContent = "UPDATE $tableName SET $set WHERE $where;";
		return $this->queueQuery($queryContent);
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
	public function updateHotel($set, $where) {
		return $this->updateTable("hotel", $set, $where);
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
	public function updateFacility($set, $where) {
		return $this->updateTable("user", $set, $where);
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
	public function updateUser($set, $where) {
		return $this->updateTable("user", $set, $where);
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
	public function updateBooking($set, $where) {
		return $this->updateTable("booking", $set, $where);
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
	public function updateReserve($set, $where) {
		return $this->updateTable("reserve", $set, $where);
	}

	//----------------------Select Queries--------------------------------------
	/**
	 * selectFromTable
	 * this is too usage-oriented so no specialized method
	 */
	public function selectFromTable($select, $from, $where, $groupby) {
		$queryContent = "SELECT $select FROM $from WHERE $where GROUP BY $groupby";
		return $this->queueQuery($queryContent);
	}

	//----------------------Useful functions------------------------------------
	public static function getAssocArray() {
		$args = func_get_args();
		$iter = new ArrayIterator($args);
		$rv = array();
		while ($iter->valid()) {
			$attr = $iter->current();
			$iter->next();
			$value = $iter->current();
			$iter->next();
			if ($value != '' && $value != 0) {
				$rv[$attr] = $value;
			}
		}
		return $rv;
	}

	/**
	 * findAvailableRooms
	 * @return an array of rows of matching results, in each row there are
	 *         hotelid, hotelname, room_class, bed_size, no_bed, room_count 
	 *         and availability columns. The row is represented as an 
	 *         associative array with column names as indices
	 */
	public function findAvailableRooms($hotelInfo, $roomInfo, $hotelFeatures, $bookingInfo) {
		$this->findAvailableRoomsQuery($hotelInfo, $roomInfo, $hotelFeatures, $bookingInfo);
		$rv = $this->sendQueries();
		return $rv[0];
	}

	private function findAvailableRoomsQuery($hotelInfo, $roomInfo, $hotelFeatures, $bookingInfo, $hotelids = NULL) {
		$checkinDate = $bookingInfo['checkin'];
		$checkoutDate = $bookingInfo['checkout'];
		// Get available rooms from matching hotels
		// Get available rooms from matching hotels
		$roomConditions = <<<EOD
SELECT f.hotelid, h.hotelname, f.room_class, f.bed_size, f.no_bed, f.room_count
FROM hotel h, facility f
WHERE h.hotelid=f.hotelid
EOD;
		// Fill in the optional information
		foreach ($hotelInfo as $attr => $value) {
			if (strcmp($attr, "star") != 0) {
				$roomConditions .= " AND h.$attr LIKE '%$value%'";
			} else {
				$roomConditions .= " AND h.$attr=$value";
			}
		}
		foreach ($roomInfo as $attr => $value) {
			$roomConditions .= " AND f.$attr = $value";
		}
		foreach ($hotelFeatures as $attr => $value) {
			$roomConditions .= " AND h.$attr = $value";
		}

		$orHotelids = "";
		$orz = "";
		if (!empty($hotelids)) {
			foreach ($hotelids as $index=>$id) {
				$orHotelids .= " $orz f.hotelid=$id";
				$orz = 'OR';
			}
			$orHotelid = " AND ($hotelids)";
		}

		// Construct time conditions
		$timeCondition = '';
		if (!empty($checkinDate) && !empty($checkoutDate)) {
			$timeCondition .=<<<EOD
AND ((b.checkout>'$checkinDate' AND b.checkout<'$checkoutDate') OR
		(b.checkin>='$checkinDate' AND b.checkin<'$checkoutDate') OR
		(b.checkin<='$checkinDate' AND b.checkout>='$checkoutDate'))
EOD;
		}
		$findRoomCountQuery = <<<EOD
$roomConditions
GROUP BY f.hotelid, h.hotelname, f.room_class, f.bed_size, f.no_bed, f.room_count
HAVING f.room_count > (
	SELECT SUM(r.count)
	FROM reserve r, booking b
	WHERE r.hotelid=f.hotelid AND r.room_class=f.room_class AND r.bed_size=f.bed_size
	AND r.no_bed=f.no_bed AND r.ref=b.ref AND b.status='successful' $orHotelids $timeCondition)
UNION
$roomConditions AND NOT EXISTS(
	SELECT *
	FROM reserve r, booking b
	WHERE r.hotelid=f.hotelid AND r.room_class=f.room_class AND r.bed_size=f.bed_size AND
			r.no_bed=f.no_bed AND r.ref=b.ref AND b.status='successful' $timeCondition)
EOD;
		
		// Get reserved number of rooms of the same type
		$findReserveCountQuery = <<<EOD
SELECT SUM(r.count) as rCount, r.hotelid, r.room_class, r.bed_size, r.no_bed
FROM facility f, reserve r, booking b
WHERE r.hotelid=f.hotelid AND r.room_class=f.room_class AND r.bed_size=f.bed_size
AND r.no_bed=f.no_bed AND r.ref=b.ref AND b.status='successful'
$timeCondition
GROUP BY r.hotelid, r.room_class, r.bed_size, r.no_bed
EOD;
		$joinResults = <<<EOD
SELECT ro.hotelid, ro.hotelname, ro.room_class, ro.bed_size, ro.no_bed, ro.room_count, ro.room_count - re.rCount AS availability
FROM ($findRoomCountQuery) AS ro
LEFT JOIN ($findReserveCountQuery) AS re
ON ro.hotelid = re.hotelid AND ro.room_class = re.room_class AND ro.bed_size = re.bed_size AND ro.no_bed = re.no_bed;
EOD;
		$this->queueQuery($joinResults);
	}
	/**
	 * changeUserNamePassword
	 * @param email the primary key of the row
	 * @param name to be changed
	 * @param password to be changed
	 * given the email, change the name and password accordingly
	 */
	public function changeUserNamePassword($email, $name, $password) {
		// TODO implement this
	}

	/**
	 * placeBooking
	 * @param userid is the email of the user that is the primary key of the user table
	 * @param hotelid, room_class, bed_size and no_bed together are the primary key of the facility table
	 * @param no_reserving is the number of rooms of this type that the user is going to book
	 * @param checkin and checkout are the dates when the user checkin and out
	 * @return an array of booking info if the booking is confirmed or null if it fails, most probably because there is no more vacancy
	 * It will take the information of the room and the booking as parameters. Then it will generate a ref from the id
	 * and time of booking.
	 */
	public function placeBooking($userid, $hotelid, $room_class, $bed_size, $no_bed, $no_reserving, $checkin, $checkout, $aRef=NULL) {
		// Check for availability first if no room with the specified primary keys, the the transaction will fail early
		// This is to prevent conflicting with other bookings placed when the current use is making his decision.
		try {
			$hotelInfo = array();// empty because we already have a hotelid
			$roomInfo = array();
			$hotelFeatures = array();// same as hotelInfo
			$bookingInfo = array();
			$roomInfo["hotelid"] = $hotelid;
			$roomInfo["room_class"] = $room_class;
			$roomInfo["bed_size"] = $bed_size;
			$roomInfo["no_bed"] = $no_bed;
			$bookingInfo["checkin"] = $checkin;
			$bookingInfo["checkout"] = $checkout;
			$this->findAvailableRoomsQuery($hotelInfo, $roomInfo, $hotelFeatures, $bookingInfo);

			$userid = "'$userid'";
			$checkin = "'$checkin'";
			$checkout = "'$checkout'";
			$rawRef = (is_null($aRef)) ? $this->generateRef() : $aRef;
			$ref = "'$rawRef'";
			
			// Queue insert into booking query
			if (is_null($aRef)) {
				// Is no ref is provided, this is a new booking record so we need to create it.
				$this->insertIntoBooking($ref, $userid, $checkin, $checkout, "'successful'");
			}

			// Queue insert into reserve query
			$this->insertIntoReserve($ref, $hotelid, $room_class, $bed_size, $no_bed, $no_reserving);

			$result = $this->sendQueries();

			// Return result
			if (empty($result)) {
				return NULL;
			} else {
				return $rawRef;
			}
		} catch(Exception $e) {
			return NULL;
		}
	}

	/**
	 * generateRef
	 * Generate a 16-char ref string number for this booking without querying the database. The likelyhood of collision with other bookings
	 * is very low. It can only happen when both of the below conditions are fulfilled.
	 *    1. More than one order is being processed within a millionth of a second at the same time.
	 *    2. The two orders generates the same random number in the range of 0 ~ 99
	 * I believe this is low enough to be acceptable and in case of collision we can just retry more times and the chance
	 * will approach 0 in a few attempts. So even when it happens, it is not so scary :)
	 * Reference: http://www.redtamo.com/default/create_order_sn.html
	 */
	private function generateRef() {
		date_default_timezone_set('Asia/Singapore');
		$year_code = array('A','B','C','D','E','F','G','H','I','J');
		$order_sn = $year_code[intval(date('Y'))-2013].
			strtoupper(dechex(date('m'))).date('d').
			substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
		return $order_sn;
	}

		/**
	 * topTen
	 * return an array of information of the top 10 booked hotels. The array is in the same format as
	 * that returned by the findAvailability method.
	 */
	public function topTen() {
		$query = <<<EOD
SELECT r.hotelid, h.hotelname, r.room_class, r.bed_size, r.no_bed, SUM(r.count) AS totalCount
FROM reserve r, hotel h
WHERE r.hotelid=h.hotelid
GROUP BY r.hotelid, r.room_class, r.bed_size, r.no_bed
ORDER BY SUM(r.count) DESC;
EOD;
		$this->queueQuery($query);
		$result = $this->sendQueries();
		$result = $result[0];
		$rv = array();
		$index = 0;
		foreach ($result AS $rowIndex => $row) {
			if ($rowIndex == 10) {
				break;
			} else {
				array_push($rv, $row);
			}
		}

		return $rv;
	}

	/**
	 * findAllBooking
	 * @param email is the primary key of the user table
	 * @return an array of all bookings' information including
	 *         ref, hotelname, room_class, no_reserving, checkin, checkout
	 */
	public function findAllBookingByEmail($email) {
		$queryContent=<<<EOD
SELECT r.ref, h.hotelname, r.room_class, r.bed_size, r.no_bed, r.count, b.checkin, b.checkout, b.status
FROM reserve r, hotel h, booking b
WHERE h.hotelid=r.hotelid AND r.ref=b.ref AND b.uid='$email' AND b.status='successful'
ORDER BY b.checkin ASC;
EOD;
		$this->queueQuery($queryContent);
		$rv = $this->sendQueries();
		$rv = $rv[0];
		return $rv;
	}

	/**
	 * findAllBooking
	 * @return an array of all booking records
	 */
	public function findAllBooking() {
		$queryContent=<<<EOD
SELECT r.ref, h.hotelname, r.room_class, r.bed_size, r.no_bed, r.count, b.uid, b.checkin, b.checkout, b.status
FROM reserve r, hotel h, booking b
WHERE h.hotelid=r.hotelid AND r.ref=b.ref
ORDER BY b.checkin ASC;
EOD;
		$this->queueQuery($queryContent);
		$rv = $this->sendQueries();
		$rv = $rv[0];
		return $rv;
	}

	/**
	 * cancelBook
	 * @param ref the reference number of the booking we are going to cancel
	 * @param email the uid field of the booking record
	 * @param isAdmin whether the user that is attempting to remove the record
	 *        is an administrator. If he is, he can cancel any record. Otherwise
	 *        he can only cancel the record with his own email as uid
	 */
	public function cancelOrder($ref, $email, $isAdmin) {
		try {
			$uid = ($isAdmin)? "": " AND uid='$email'";
			$query = "UPDATE booking SET status='cancelled' WHERE ref='$ref' $uid;";
			$this->queueQuery($query);
			$rv = $this->sendQueries();
			$rv = $rv[0];
			if ($rv) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
	}


	/**
	 * modifyDate
	 * @param ref
	 * @param email
	 * @param isAdmin
	 * @param checkin
	 * @param checkout
	 * the security feature is the same as cancelBook method
	 */
	public function modifyDate($ref, $email, $isAdmin, $checkin, $checkout) {
		try {
			$uid = ($isAdmin)? "": " AND uid='$email'";
			// This is an array with the following elements "hotelid, room_class, bed_size,
			// no_bed, count" all indexed by their attribute names
			$facilitiesBooked = $this->getAllReservation($ref, $email);
			$this->removeAllReservation($ref);
			$this->updateBooking("checkin='$checkin', checkout='$checkout'", "ref='$ref'");

			// Place the orders again with the new date and if anyone creates a conflict
			// exception will be thrown and changes rolled back.
			foreach($facilitiesBooked as $index=>$reserve) {
				$this->placeBooking($email, $reserve['hotelid'], $reserve['room_class'], $reserve['bed_size'], $reserve['no_bed'], $reserve['count'], $checkin, $checkout, $ref);
			}

			$this->sendQueries();
			// Successful
			return true;
		} catch(Exception $e) {
			return false;
		}
	}

	/**
	 * getAllReservation
	 * @param $ref, $email
	 * @return an array of rows of reservations with this ref
	 * it sends the query and returns the result
	 */
	private function getAllReservation($ref, $email) {
		try {
			$query = "SELECT r.hotelid, r.room_class, r.bed_size, r.no_bed, r.count FROM reserve r, booking b WHERE r.ref='$ref' AND r.ref=b.ref AND b.uid='$email';";
			$this->queueQuery($query);
			$rv = $this->sendQueries();
			$rv = $rv[0];
			return $rv;
		} catch(Exception $e) {
			throw $e;
		}
	}

	/**
	 * removeAllReservation only queue the queries but not send them.
	 */
	private function removeAllReservation($ref) {
		$constraint = "ref='$ref'";
		$this->deleteFromReserve($constraint);
		$this->sendQueries();
	}

}
?>