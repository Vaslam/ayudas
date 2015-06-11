<?php
include_once("class-AdministrableItem.php");

class Plan extends AdministrableItem {
    
    public $content;
    public $price;
    
    public function __construct($id = null, $tablename = "plans", $itemtype = ITEM_TYPE_PLAN) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename." VALUES(
                null, :title, :content, :price
                )";
        }
        if(empty($queryParams = [])) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":price"=>$this->price
            ];
        }
        
        return parent::add($query, $queryParams);
    }
    
    public function update($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "UPDATE ".$this->tablename." SET 
                        title = :title,
                        content = :content,
                        price = :price 
                        WHERE id = ".$this->id;
        }
        if(empty($queryParams = [])) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":price"=>$this->price
            ];
        }
        return parent::update($query, $queryParams);
    }
}
