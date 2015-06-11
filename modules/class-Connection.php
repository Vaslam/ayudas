<?php

class Connection {
	
	public static function connect() {
		$conn = new PDO("mysql:host=".DB_SERVER."; dbname=".DB_SELECTED_DB.";charset = utf8", 
                        DB_USER, DB_PASSWORD);
		return $conn;
	}
	
}
