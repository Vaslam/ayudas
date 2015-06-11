<?php
include_once("class-AdministrableItem.php");

class Repository extends AdministrableItem {
    
    public $content;
    
    public function __construct($id = null, $tablename = "repositories", $itemtype = ITEM_TYPE_REPOSITORY) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename." VALUES (
                        null,
                        :title,
                        :content)";
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content
            ];
        }
        return parent::add($query, $queryParams);
    }
    
    public function update($query = null, $queryParams = []) {
         if(empty($query)) {
            $query = "UPDATE ".$this->tablename." SET 
                        title = :title,
                        content = :content WHERE id = ".$this->id;
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content
            ];
        }
        return parent::update($query, $queryParams);
    }
    
}