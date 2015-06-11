<?php
include_once("class-AdministrableItem.php");

class Product extends AdministrableItem {
    
    public $reference;
    public $content;
    public $price;
    public $stock;
    public $active;
    public $featured;
    public $category;
    public $url;
    
    protected $managesStock = false;
    protected $hasCategory = true;
    protected $categoriesTable = "productcategories";
    
    public function __construct($id = null, $tablename = "products", $itemtype = ITEM_TYPE_PRODUCT) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename." VALUES (
                        null,
                        :reference,
                        :title,
                        :content,
                        :price,
                        :stock,
                        :active,
                        :featured,
                        :category,
                        :url)";
        }
        
        if(empty($queryParams)) {
            $queryParams = [
                ":reference"=>$this->reference,
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":price"=>$this->price,
                ":stock"=>$this->stock,
                ":active"=>$this->active,
                ":featured"=>$this->featured,
                ":category"=>$this->category,
                ":url"=>$this->url
            ];
        }
        return parent::add($query, $queryParams);
    }
    
    public function update($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "UPDATE ".$this->tablename." SET
                        reference = :reference,
                        title = :title,
                        content = :content,
                        price = :price,
                        stock = :stock,
                        active = :active,
                        featured = :featured,
                        category = :category,
                        url = :url WHERE id = ".$this->id;
        }
        
        if(empty($queryParams)) {
            $queryParams = [
                ":reference"=>$this->reference,
                ":content"=>$this->content,
                ":title"=>$this->title,
                ":price"=>$this->price,
                ":stock"=>$this->stock,
                ":active"=>$this->active,
                ":featured"=>$this->featured,
                ":category"=>$this->category,
                ":url"=>$this->url
            ];
        }
        return parent::update($query, $queryParams);
    }
    
    public function find($params = array()) {   
        $whereused = false;
        
        /*
         * -- BASE QUERY
         */
        $query = "SELECT SQL_CALC_FOUND_ROWS ".$this->tablename.".*";
        if($this->hasCategory === true) {
            $query .= ", ".$this->categoriesTable.".title AS categoryname";
        }
        $query .=" FROM ".$this->tablename;
        if($this->hasCategory) {
            $query .= " LEFT JOIN ".$this->categoriesTable." ON ".$this->tablename.".category = ".$this->categoriesTable.".id";
        }
        //echo $query; exit; //DEBUG
        
        /*
         *  -- CONDITIONS
         */
        
        //SEARCH ALGORITHM
        if(!empty($params["search"])) {
            $query .= " WHERE (
                        ".$this->tablename.".title LIKE :search OR
                        ".$this->tablename.".content LIKE :search OR
                        ".$this->tablename.".reference LIKE :search
                        )";
            $whereused = true;
        }
        
        if(!empty($params["cat"])) {
            if($whereused) {
                $query .= " AND ".$this->tablename.".category = ".$params["cat"];
            } else {
                $query .= " WHERE ".$this->tablename.".category = ".$params["cat"];
                $whereused = true;
            }
        }
        
        if(!empty($params["activeonly"])) {
            if($whereused) {
                $query .= " AND ".$this->tablename.".active = 1";
            } else {
                $query .= " WHERE ".$this->tablename.".active = 1";
                $whereused = true;
            }
        }
        
        //echo $query; exit; //DEBUG
        $query .= " ORDER BY ".$this->tablename.".id DESC";

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
            $q->bindValue(":search", "%".$params["search"]."%");
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
    
    public function updateStock($newStock, $id = null) {
        if(empty($id)) {
            if(empty($this->id)) {
                return false;
            }
            $id = $this->id;
        }
        if(!empty($id) && is_int($newStock)) {
            $query = "UPDATE ".$this->tablename." SET stock = ".$newStock. "
                        WHERE id = ".$id;
            return $this->conn->query($query);
        }
        return false;
    }
    
    public function removeFromStock($howMany, $id = null) {
        if(empty($id)) {
            if(empty($this->id)) {
                return false;
            }
            $id = $this->id;
        }
        if(!empty($id) && is_int($howMany)) {
            $query = "UPDATE ".$this->tablename." SET stock = (stock - ".$howMany.")
                        WHERE id = ".$id;
            return $this->conn->query($query);
        }
        return false;
    }
    
    public function addToStock($howMany, $id = null) {
        if(empty($id)) {
            if(empty($this->id)) {
                return false;
            }
            $id = $this->id;
        }
        if(is_int($howMany)) {
            $query = "UPDATE ".$this->tablename." SET stock = (stock + ".$howMany.")
                        WHERE id = ".$id;
            return $this->conn->query($query);
        }
        return false;
    }
    
}