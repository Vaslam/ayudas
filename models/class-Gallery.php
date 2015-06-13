<?php
include_once("class-AdministrableItem.php");

class Gallery extends AdministrableItem {
    
    public $description;
    public $theorder;
    
    public function __construct($id = null, $tablename = "galleries", $itemtype = ITEM_TYPE_GALLERY) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename." VALUES(
                null, :title, :description, :theorder
                )";
        }
        if(empty($queryParams = [])) {
            $queryParams = [
                ":title"=>$this->title,
                ":description"=>$this->description,
                ":theorder"=>$this->theorder
            ];
        }
        
        return parent::add($query, $queryParams);
    }
    
    public function update($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "UPDATE ".$this->tablename." SET 
                        title = :title,
                        description = :description,
                        theorder = :theorder 
                        WHERE id = ".$this->id;
        }
        if(empty($queryParams = [])) {
            $queryParams = [
                ":title"=>$this->title,
                ":description"=>$this->description,
                ":theorder"=>$this->theorder
            ];
        }
        return parent::update($query, $queryParams);
    }
    
}