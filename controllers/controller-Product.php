<?php
include_once("../config.php");
include_once("../modules/class-Controller.php");
include_once("../models/class-Product.php");

$action = Controller::getAction();
$returnPage = "../admin/products";

switch($action) {
    
    case "add":
        if(!empty($_POST["title"]) && Controller::validateTokenPost()) {
            $prod = new Product();
            $prod->title = strip_tags($_POST["title"]);
            $prod->reference = strip_tags($_POST["reference"]);
            $prod->price = str_replace(",", "", $_POST["price"]);
            $prod->content = $_POST["content"];
            $prod->category = (int)$_POST["category"];
            $prod->active = !empty($_POST["active"]) ? 1 : 0;
            $prod->featured = !empty($_POST["featured"]) ? 1 : 0;
            $prod->stock = 0;
            $prod->url = "";
            
            if($prod->add()) {
                if(!empty($_FILES["picture"]["name"])) {
                    $prod->setMainImage($_FILES["picture"], true);
                }
                if(!empty($_FILES["gallery"]["name"][0])) {
                    $prod->setImageGallery($_FILES["gallery"], true);
                }
                if(!empty($_FILES["files"]["name"][0])) {
                    $prod->setFiles($_FILES["files"]);
                }
                $msg = MSG_INSERT_SUCCESS;
            } else {
                $msg = MSG_INSERT_FAILED;
            }
        } else {
            $msg = MSG_EMPTY_FIELD;
        }
        
        header("Location: ".$returnPage."&msg=".$msg);
        break;
    
    case "update":
        if(!empty($_POST["title"]) && !empty($_POST["id"]) && Controller::validateTokenPost()) {
            $prod = new Product((int)$_POST["id"]);
            $prod->title = strip_tags($_POST["title"]);
            $prod->reference = strip_tags($_POST["reference"]);
            $prod->price = str_replace(",", "", $_POST["price"]);
            $prod->content = $_POST["content"];
            $prod->category = (int)$_POST["category"];
            $prod->active = !empty($_POST["active"]) ? 1 : 0;
            $prod->featured = !empty($_POST["featured"]) ? 1 : 0;
            $prod->stock = 0;
            $prod->url = "";
            
            if($prod->update() === true) {
                $returnPage = "../admin/edit-product?id=".$prod->id;
                $msg = MSG_UPDATE_SUCCESS;
            } else {
                $msg = MSG_UPDATE_FAILED;
            }
            if(!empty($_FILES["picture"]["name"])) {
                $prod->setMainImage($_FILES["picture"], true);
            }
			if(!empty($_POST["deleteimages"]) && $_POST["deleteimages"] == "1") {
                if(!empty($_POST["photostodelete"])) {
                    $prod->deleteImages($_POST["photostodelete"]);
                }
            }
            if(!empty($_FILES["gallery"]["name"][0])) {
                $prod->setImageGallery($_FILES["gallery"], true);
            }
            if(!empty($_FILES["files"]["name"][0])) {
                $prod->setFiles($_FILES["files"]);
            }
            
        } else {
            $msg = MSG_EMPTY_FIELD;
        }
        header("Location: ".$returnPage."&msg=".$msg);
        break;
    
    case "delete":
        if(!empty($_GET["id"]) && Controller::validateTokenGet()) {
            $prod = new Product();
            $prod->id = (int)$_GET["id"];
            if($prod->remove()) {
                $msg = MSG_DELETE_SUCCESS;
            } else {
                $msg = MSG_DELETE_FAILED;
            }
        } 
        header("Location: ".$returnPage."?msg=".$msg);
        break;
    
    case "deletegroup":
        if(!empty($_POST["todelete"]) && Controller::validateTokenPost()) {
            $prod = new Product();
            foreach($_POST["todelete"] as $todelete) {
                $prod->id = $todelete;
                $prod->getById(true);
                $prod->remove();
            }
            $msg = MSG_DELETE_SUCCESS;
        }
        header("Location: ".$returnPage."?msg=".$msg);
        break;
        
    default:
        header("Location: ".$returnPage);
        break;
    
}