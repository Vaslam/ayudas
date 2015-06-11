<?php
include_once(BASE_PATH."/modules/class-Connection.php");

abstract class Model {
    
    protected $tablename;
    protected $conn;
    protected $errors = array();
    
    public function __construct() {
        $this->conn = Connection::connect();
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    protected function setTablename($name) {
        $this->tablename = $name;
    }
    
    public function getTablename() {
        return $this->tablename;
    }
}
