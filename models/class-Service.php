<?php
include_once("class-AdministrableItem.php");

class Service extends AdministrableItem {
    
    public $content;
    public $theorder;
    public $category;
    public $featured;
    public $active;
    public $keywords;
    
    public function __construct($id = null, $tablename = "services", $itemtype = ITEM_TYPE_SERVICE) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename." VALUES (
                        null,
                        :title,
                        :content,
                        :theorder,
                        :category,
                        :featured,
                        :active,
                        :keywords)";
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":theorder"=>$this->theorder,
                ":category"=>$this->category,
                ":featured"=>$this->featured,
                ":active"=>$this->active,
                ":keywords"=>$this->keywords
            ];
        }
        return parent::add($query, $queryParams);
    }
    
    public function update($query = null, $queryParams = []) {
         if(empty($query)) {
            $query = "UPDATE ".$this->tablename." SET 
                        title = :title,
                        content = :content,
                        theorder = :theorder,
                        category = :category,
                        featured = :featured,
                        active = :active,
                        keywords = :keywords WHERE id = ".$this->id;
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":theorder"=>$this->theorder,
                ":category"=>$this->category,
                ":featured"=>$this->featured,
                ":active"=>$this->active,
                ":keywords"=>$this->keywords
            ];
        }
        return parent::update($query, $queryParams);
    }
    
    public function find($params = array()) {
        /*
         * -- BASE QUERY
         */
        $whereused = false;
        $query = "SELECT ".$this->tablename.".*,
                    servicecategories.title AS categoryname
                    FROM ".$this->tablename."
                    LEFT JOIN servicecategories ON ".$this->tablename.".category = servicecategories.id";
        //echo $query; exit; //DEBUG
        
        /*
         *  -- CONDITIONS
         */
        
        //SEARCH ALGORITHM
        if(!empty($params["search"])) {
            $query .= " WHERE (".$this->tablename.".content LIKE :search OR
                        ".$this->tablename.".title LIKE :search)"; 
            $whereused = true;
        }
        
        if(!empty($params["cat"])) {
            if($whereused) {
                $query .= " AND ".$this->tablename.".category = :search";
            } else {
                $query .= " WHERE (" . $this->tablename . ".content LIKE :search OR
                        " . $this->tablename . ".title LIKE :search)";
                $whereused = true;
            }
        }
        
        if(!empty($params["featuredOnly"])) {
            if(!$whereused) {
                $query .= " WHERE ".$this->tablename.".featured = 1"; 
                $whereused = true;
            } else if($whereused) {
                $query .= " AND ".$this->tablename.".featured = 1"; 
            }
        } else if(!empty($params["notFeatured"])) {
            if(!$whereused) {
                $query .= " WHERE ".$this->tablename.".featured = 0"; 
                $whereused = true;
            } else if($whereused) {
                $query .= " AND ".$this->tablename.".featured = 0"; 
            }
        }
        
        //Returning inactive or active items
        if(!empty($params["activeonly"])) {
            if(!$whereused) {
                $query .= " WHERE ".$this->tablename.".active = 1"; 
                $whereused = true;
            } else if($whereused) {
                $query .= " AND ".$this->tablename.".active = 1"; 
            }
        } else if(!empty($params["inactiveonly"])) {
            if(!$whereused) {
                $query .= " WHERE ".$this->tablename.".active = 0"; 
                $whereused = true;
            } else if($whereused) {
                $query .= " AND ".$this->tablename.".active = 0"; 
            }
        } // ELSE Return both anyway
        //echo $query; exit; //DEBUG
        $query .= " ORDER BY ".$this->tablename.".theorder DESC, ".$this->tablename.".id DESC";

        //For pagination
        if(!empty($params["limit"]) && !empty($params["set"])) {
            $set = ($params["set"] - 1) * $params["limit"];
            $query .= " LIMIT ".$set.", ".$params["limit"];
        }
        //var_dump($params);
        //echo $query; exit; //DEBUG
        /*
         *  -- END OF QUERY ALGORITHM
         */
        
        $q = $this->conn->prepare($query);
        if(isset($params["search"])) {
            if(is_numeric($params["search"])) {
                $q->bindValue(":search", (int)$params["search"]);
            } else {
                $q->bindValue(":search", "'%".$params["search"]."%'");
            }
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
    
}