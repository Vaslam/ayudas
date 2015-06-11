<?php
include_once("class-AdministrableItem.php");

class Article extends AdministrableItem {
    
    public $content;
    public $datemodified;
    
    public function __construct($id = null, $tablename = "articles", $itemtype = ITEM_TYPE_ARTICLE) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename." VALUES (
                        null,
                        :title,
                        :content,
                        :datemodified);";
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":datemodified"=>$this->datemodified
            ];
        }
        return parent::add($query, $queryParams);
    }
    
    public function update($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "UPDATE ".$this->tablename." SET 
                        title = :title,
                        content = :content,
                        datemodified = :datemodified WHERE id = ".$this->id;
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":datemodified"=>$this->datemodified
            ];
        }
        return parent::update($query, $queryParams);
    }
    
}