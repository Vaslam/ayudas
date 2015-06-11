<?php
include_once("class-Connection.php");
include_once(BASE_PATH."/models/class-Product.php");

class ShoppingCart {
    
    public static function getCartItems($ids = null) {
        if(empty($ids)) {
            if(empty($_SESSION["cart"])) {
                return false;
            } else {
                $ids = $_SESSION["cart"];
            }
        }
        $prod = new Product();
        $query = "SELECT ".$prod->getTablename().".*,
                    productcategories.title AS categoryname
                    FROM ".$prod->getTablename()."
                    LEFT JOIN productcategories ON ".$prod->getTablename().".category = productcategories.id
                    WHERE ".$prod->getTablename().".id IN (";
        foreach($ids as $key => $value) {
            if(!empty($key) && !empty($value)) {
                $query .= $key.",";
            }
        }
        $query = rtrim($query, ",").");";
        $result = Connection::connect()->query($query);
        if(!empty($result)) {
			$productsArray = $result->fetchAll(PDO::FETCH_ASSOC);
			for($i = 0; $i < count($productsArray); $i++) {
				$productsArray[$i]["image"] = $prod->getMainImage($productsArray[$i]["id"], true);
                $productsArray[$i]["qty"] = $ids[$productsArray[$i]["id"]];
			}
			return $productsArray;
		} else {
			return false;
		}
    }
    
    public static function item($id, $qty) {
        $_SESSION["cart"][$id] = $qty;
    }
    
    public static function emptyCart() {
        unset($_SESSION["cart"]);
        return true;
    }
    
    public static function deleteItem($itemId) {
        unset($_SESSION["cart"][$itemId]);
        return true;
    }
    
    public static function getCount() {
        if(!empty($_SESSION["cart"])) {
            return count($_SESSION["cart"]);
        } 
        return 0;
    }
    
}
