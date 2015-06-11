<?php
include_once("class-Category.php");

class ProductCategory extends Category {
    
    public function __construct($id = null, $tablename = "productcategories", $itemtype = ITEM_TYPE_PRODUCT_CATEGORY) {
        $this->requiresfolder = true;
        parent::__construct($id, $tablename, $itemtype);
    }
    
    public function remove() {
        
        if(!empty($this->id)) {
            $this->getById(true);
            $query = "UPDATE ".$this->tablename." SET category = ".$this->category." WHERE category = ".$this->id;
            if($this->conn->query($query)) {
                $query = "UPDATE products SET category = ".$this->category." WHERE category = ".$this->id;
                return parent::remove();
            }
        }
        return false;
    }
    
}