<?php
include_once("class-AdministrableItem.php");

class Category extends AdministrableItem {
    
    public $category;
    public $content;
    public $theorder;
    public $active;
    
    protected $parentsInfo = array();
    
    public function __construct($id = null, $tablename = "categories", $itemtype = null) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = null, $queryParams = null) {
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename." VALUES (
                    null, :category, :title, :content,
                    :theorder, :active)";
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":category"=>$this->category,
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":theorder"=>$this->theorder,
                ":active"=>$this->active
            ];
        }
        return parent::add($query, $queryParams);
    }
    
    public function update($query = null, $queryParams = []) {
        if(empty($this->id)) {
            $this->errors[] = "Object ID is not set. Cannot Update";
            return false;
        }
        if(empty($query)) {
            $query = "UPDATE ".$this->tablename." 
                        SET 
                        category = :category,
                        title = :title, 
                        content = :content,
                        active = :active,
                        theorder = :theorder
                        WHERE id = ".$this->id;
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":category"=>$this->category,
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":active"=>$this->active,
                ":theorder"=>$this->theorder
            ];
        }
        return parent::update($query, $queryParams);
    }
    
    public function find($params = array()) {
        $whereused = false;
        /*
         * -- BASE QUERY
         */
        $query = "SELECT * FROM ".$this->tablename;
        //echo $query; exit; //DEBUG
        
        /*
         *  -- CONDITIONS
         */
        
        if(!empty($params["search"])) {
            $query .= " WHERE title LIKE :search OR content LIKE :search";
            $whereused = true;
        }
        
        if(isset($params["cat"])) {
            if($whereused) {
                $query .= " AND category = ".(int)$params["cat"];
            } else {
                $query .= " WHERE category = ".(int)$params["cat"];
                $whereused = true;
            }
        }
        
        //Returning inactive or active items
        if(!empty($params["activeonly"])) {
            if(!$whereused) {
                $query .= " WHERE active = 1"; 
            } else if($whereused) {
                $query .= " AND active = 1"; 
            }
        } else if(!empty($params["inactiveonly"])) {
            if(!$whereused) {
                $query .= " WHERE active = 0"; 
            } else if($whereused) {
                $query .= " AND active = 0"; 
            }
        } // ELSE Return both anyway
        //echo $query; exit; //DEBUG
        $query .= " ORDER BY theorder DESC, id DESC";

        //For pagination
        if(!empty($params["limit"]) && !empty($params["set"])) {
            $set = ($params["set"] - 1) * $params["limit"];
            $query .= " LIMIT ".$set.", ".$params["limit"];
        }
        //echo $query; //exit; //DEBUG
        /*
         *  -- END OF QUERY ALGORITHM
         */
        
        $q = $this->conn->prepare($query);
        if(!empty($params["search"])) {
            $q->bindValue(":search", "'%".$params["search"]."%'");
        }
		if($q->execute()) {
			$array = $q->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($params["returnCount"])) {
                $countQuery = "SELECT FOUND_ROWS()";
                $theCount = $this->conn->query($countQuery)->fetch(PDO::FETCH_COLUMN);
                $array["totalCount"] = $theCount;
            }
			return $array;
		} else {
            $this->errors[] = "Could not execute the prepared query";
			return false;
		}
	}
    
    public function remove() {
        if(!empty($this->id)) {
            $this->getById(true);
            $query = "UPDATE ".$this->tablename." SET category = ".$this->category." WHERE category = ".$this->id;
            if($this->conn->query($query)) {
                return parent::remove();
            } else {
                return false;
            }
        }
        return false;
    }
    
    public function getParentsInfo($id = null) {
        if(empty($id)) {
            if(empty($this->id)) {
                return false;
            } else {
                $id = $this->id;
            }
        }
        $query = "SELECT * FROM ".$this->tablename." WHERE id = ".$id;
        $result = $this->conn->query($query);
        if($result) {
            $this->parentsInfo[] = $result->fetch(PDO::FETCH_ASSOC);
            $count = count($this->parentsInfo) - 1;
            $this->getParentsInfo($this->parentsInfo[$count]["category"]);
        }
        return array_reverse($this->parentsInfo);
    }
	
}

include_once("class-ServiceCategory.php");
include_once("class-ProductCategory.php");