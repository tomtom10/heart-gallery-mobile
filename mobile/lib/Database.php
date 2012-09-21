<?php

require_once dirname(__FILE__) . '/db.php';

Database::configure(MYSQL_HOST, MYSQL_DATABASE, MYSQL_USERNAME, MYSQL_PASSWORD);

class Database {
	private static $host;
	private static $database;
	private static $username;
	private static $password;
	private static $connection = false;

	public static function configure($host, $database, $username, $password) {
		self::$host = $host;
		self::$database = $database;
		self::$username = $username;
		self::$password = $password;
	}

	private static function connect() {
		if (!self::$connection) {
			self::$connection = mysql_connect(self::$host, self::$username, self::$password);
			mysql_select_db(self::$database);
			mysql_set_charset("UTF8");
		}
	}

	public static function close() {
		if (self::$connection) {
			mysql_close(self::$connection);
			self::$connection = false;
		}
	}

	public static function query($query) {
		self::connect();
		$args = array_slice(func_get_args(), 1);
		$escapedArgs = array_map('mysql_real_escape_string', $args);
		array_unshift($escapedArgs, $query);
		$formattedQuery = call_user_func_array('sprintf', $escapedArgs);
		return mysql_query($formattedQuery);
	}

	public static function toResult($resource) {
		return mysql_fetch_assoc($resource);
	}

	public static function toArray($resource) {
		$result = array();
		while ($row = mysql_fetch_assoc($resource)) {
			array_push($result, $row);
		}
		return $result;
	}
}
