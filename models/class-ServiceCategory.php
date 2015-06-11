<?php
include_once("class-Category.php");

class ServiceCategory extends Category {
    
    public function __construct($id = null, $tablename = "servicecategories", $itemtype = ITEM_TYPE_SERVICE_CATEGORY) {
        parent::__construct($id, $tablename, $itemtype);
    }
    
}