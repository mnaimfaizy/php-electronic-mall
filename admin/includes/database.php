<?php

class MySQLDatabase {

	# Database Connection Variables
	protected $_db_server = '192.168.1.104';
	protected $_db_user		= 'root';
	protected $_db_pass		= 'Kabul@123';
	protected $_db_name		= 'php_electronics_mall';
	protected  $_db_port 	= 33069;

	# Other variables used in the entire class
	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string;

	function __construct() {
		$this->open_connection();
		$this->magic_quotes_active = (bool) ini_get('magic_quotes_gpc');
		$this->real_escape_string = function_exists('mysqli_real_escape_string');
	}

	# open a connection to the database
	public function open_connection() {
		$this->connection = mysqli_connect($this->_db_server, $this->_db_user, $this->_db_pass, $this->_db_name, $this->_db_port);
		if(!$this->connection) {
			die("Database connection failed: " . mysqli_error());	# check database is connected or through errors
		}
	}

	# to close the opened connection
	public function close_connection() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql) {
		$this->last_query = $sql;
		$result = mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result) {
		if (!$result) {
			$output = "Database query failed: " . mysqli_error($this->connection) . "<br /><br />";
			$output .= "Last SQL query: " . $this->last_query;
			die($output);
		}
	}


	public function escape_value($value) {

		if($this->real_escape_string) { // PHP v4.3.0 or higher
		// undo any magic quote effects so mysql_real_escape_string can do the work
		if($this->magic_quotes_active) { $value = stripslashes($value); }
			$value = mysqli_real_escape_string($this->connection, $value);
		} else { // before PHP v4.3.0
		// If magic quotes aren't already on then add slases manually
		if(!$this->magic_quotes_active) { $value = addslashes($value); }
		// if magic quotes are active, then teh slashes already exist
		}
		return $value;
	}

	// "Database-neutral" methods
	public function fetch_array($result_set) {
		return mysqli_fetch_array($result_set);
	}

	public function num_rows($result_set) {
		return mysqli_num_rows($result_set);
	}

	public function insert_id() {
		// get the last id inserted over the current db connection
		return mysqli_insert_id($this->connection);
	}

	public function affected_rows() {
		return mysqli_affected_rows($this->connection);
	}

}

$database = new MySQLDatabase();
$db =& $database;
?>
