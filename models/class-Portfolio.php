<?php
include_once("class-AdministrableItem.php");

class Portfolio extends AdministrableItem {
    
    public $content;
    public $theorder;
    public $featured;
    
    public function __construct($id = null, $tablename = "portfolio", $itemtype = ITEM_TYPE_PORTFOLIO) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function add($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "INSERT INTO ".$this->tablename." VALUES(
                        null,
                        :title,
                        :content,
                        :featured,
                        :theorder)";
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":featured"=>$this->featured,
                ":theorder"=>$this->theorder
            ];
        }
        return parent::add($query, $queryParams);
    }
    
    public function update($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "UPDATE ".$this->tablename." SET
                        title = :title,
                        content = :content,
                        featured = :featured,
                        theorder = :theorder WHERE id = ".$this->id;
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":featured"=>$this->featured,
                ":theorder"=>$this->theorder
            ];
        }
        return parent::update($query, $queryParams);
    }
    
    public function getFeatured($limit) {
        return parent::getFeatured($limit);
    }
    
}