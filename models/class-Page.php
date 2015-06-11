<?php
include_once("class-Model.php");

class Page extends Model {
    
    public $id;
    public $title;
    public $content;
    public $default;
    
    public function __construct() {
        parent::__construct();
        $this->tablename = "pages";
    }
    
    public function add() {
        $query = "INSERT INTO ".$this->tablename." VALUES 
                    (null, :title, :content, :default)";
        try {
            $this->conn->beginTransaction();
            $q = $this->conn->prepare($query);
            $q->execute(array(":title"=>$this->title, ":content"=>$this->content, ":default"=>$this->default));
            $lastInsertedId = $this->conn->lastInsertId();
            if($lastInsertedId > 0) {
                $this->id = $lastInsertedId;
                $this->conn->commit();
                return $this->id;
            } else {
                $this->errors[] = "Page could not be added to the database. No ID returned";
                $this->conn->rollBack();
                return false;
            }
        } catch(PDOException $e) {
            $this->errors[] = $e->getMessage();
            return false;
        }
    }
    
    public function getAll() {
        $query = "SELECT * FROM ".$this->tablename;
        $result = $this->conn->query($query);
        if($result) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $this->errors[] = "Could not retrieve pages from database";
        }
    }
    
    public function update() {
        if(empty($this->id)) {
            $this->errors[] = "Cannot update because ID is not set";
            return false;
        }
        $query = "UPDATE ".$this->tablename." SET 
                    title = :title,
                    content = :content
                    WHERE id = ".$this->id;
        
        $q = $this->conn->prepare($query);
        $q->execute(array(":title"=>$this->title, ":content"=>$this->content));
        if($q->rowCount() > 0) {
            return true;
        } 
        return false;
    }
    
    public function getById($id = null) {
        if(empty($id)) {
            $id = $this->id;
        }
        $query = "SELECT * FROM ".$this->tablename." WHERE id = ".$id;
        $result = $this->conn->query($query);
        if($result) {
            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            $this->errors[] = "Coult not retrieve information for this page";
        }
    }
	
	public function getContent($pageid) {
        if(empty($pageid)) {
            if(!empty($this->id)) {
                $pageid = $this->id;
            } else { 
                return false;
            }
        }
		$result = Connection::connect()->query("SELECT * FROM ".$this->tablename." WHERE id = ".$pageid);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row["content"];
	}
    
    public function remove($id) {
        if(!empty($id)) {
            $id = $this->id;
        }
        $result = $this->conn->query("DELETE FROM ".$this->tablename." WHERE id = ".$id);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function isDefault($id) {
        if(empty($id)) {
            $id = $this->id;
        }
        $pageinfo = $this->getById($id);
        if((int)$pageinfo["default"] == 1) {
            return true;
        } else {
            return false;
        }
    }
	
}
