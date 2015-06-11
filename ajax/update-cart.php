<?php
include_once("../config.php");
include_once(BASE_PATH."/modules/class-Controller.php");
include_once(BASE_PATH."/modules/class-ShoppingCart.php");

$action = Controller::getAction();

switch($action) {
    case "add":
        if(!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }
        if(!empty($_POST["productid"])) {
            //Adds 1 as the default quantity when adding an item
            //the user will be able to change the quantity during
            //checkout process

            //$_SESSION["cart"][(string)$_POST["productid"]] = 1;
            ShoppingCart::item((string)$_POST["productid"], 1);
            echo "1";
        } else {
            echo "0";
        }
        break;
    case "emptycart":
        ShoppingCart::emptyCart();
        header("Location: ".APP_URL."/cart#cart-form");
        break;
    case "deleteitem":
        ShoppingCart::deleteItem($_GET["id"]);
        header("Location: ".APP_URL."/cart#cart-form");
        break;
    case "getcount":
        echo (string)ShoppingCart::getCount();
        break;
    case "updateqty":
        $prods = json_decode($_POST["prods"], true);
        //var_dump($prods); //Debug
        foreach($prods as $p) {
            ShoppingCart::item($p["id"], (int)$p["qty"]);
        }
        break;
    case "getsessiondata":
        var_dump($_SESSION);
        break;
    default:
        header("Location: ".APP_URL);
        break;
} 
