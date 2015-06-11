<?php
include_once("class-AdministrableItem.php");

class SlideShow extends AdministrableItem {
    
    public $content;
    public $category;
    public $active;
    public $theorder;
    
    public function __construct($id = null, $tablename = "slides", $itemtype = ITEM_TYPE_SLIDESHOW) {
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
                        :active)";
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":theorder"=>$this->theorder,
                ":category"=>$this->category,
                ":active"=>$this->active
            ];
        }
        return parent::add($query, $queryParams);
    }
    
    public function update($query = "", $queryParams = []) {
        if(empty($query)) {
            $query = "UPDATE ".$this->tablename." SET 
                        title = :title,
                        content = :content,
                        active = :active,
                        theorder = :theorder
                        WHERE id = ".$this->id;
        }
        if(empty($queryParams)) {
            $queryParams = [
                ":title"=>$this->title,
                ":content"=>$this->content,
                ":active"=>$this->active,
                ":theorder"=>$this->theorder
            ];
        }
        return parent::update($query, $queryParams);
    }
    
}
