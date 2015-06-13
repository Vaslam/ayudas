<?php
include_once("../config.php");
include_once("../modules/class-Controller.php");
include_once("../models/class-Category.php");

$action = Controller::getAction();

if(!empty($_POST["class"]) || !empty($_GET["class"])) {
    
    if(!empty($_POST["class"])) {
        $item = new $_POST["class"];
    }
    
    switch($action) {
        case "add":
            if(!empty($_POST["title"]) && Controller::validateTokenPost()) {
                $item->title = strip_tags($_POST["title"]);
                $item->content = $_POST["content"];
                $item->theorder = $_POST["order"];
                $item->active = !empty($_POST["active"]) ? (int)$_POST["active"] : 0;
                $item->category = !empty($_POST["category"]) ? (int)$_POST["category"] : 0;
                
                $itemId = $item->add();
                if($itemId) {
                    if(!empty($_FILES["picture"]["name"])) {
                        $item->setMainImage($_FILES["picture"], true);
                    }
                    if(!empty($_FILES["gallery"]["name"][0])) {
                        $item->setImageGallery($_FILES["gallery"], true);
                    }
                    $msg = MSG_INSERT_SUCCESS;
                } else {
                    $msg = MSG_INSERT_FAILED;
                }
            } else {
                $msg = MSG_EMPTY_FIELD;
            }
            //var_dump($item);exit;
            header("Location: ../admin/".$_POST["returnpage"]."?id=".$itemId."&msg=".$msg);
            break;	

        case "delete":
            if(!empty($_GET["id"]) && Controller::validateTokenGet()) {
                $item->id = (int)$_GET["id"];
                if($item->remove()) {
                    $msg = MSG_DELETE_SUCCESS;
                } else {
                    $msg = MSG_DELETE_FAILED;
                }
            }
            header("Location: ../admin/".$_GET["returnpage"]."&msg=".$msg);
            break;

        case "update":
            if(!empty($_POST["title"]) && !empty($_POST["id"]) && Controller::validateTokenPost()) {
                $item->id = (int)$_POST["id"];
                $item->getById(true);
                $item->title = strip_tags($_POST["title"]);
                $item->content = $_POST["content"];
                $item->theorder = $_POST["order"];
                $item->active = !empty($_POST["active"]) ? (int)$_POST["active"] : 0;
                $item->category = !empty($_POST["category"]) ? (int)$_POST["category"] : 0;
                
                if($item->update() === true) {
                    $msg = MSG_UPDATE_SUCCESS;
                } else {
                    $msg = MSG_UPDATE_FAILED;
                }
                
                if(!empty($_FILES["picture"]["name"])) {
                    $item->setMainImage($_FILES["picture"], true);
                }
                if(!empty($_FILES["gallery"]["name"][0])) {
                    $item->setImageGallery($_FILES["gallery"], true);
                }
                if(!empty($_POST["deleteimages"]) && $_POST["deleteimages"] == "1") {
                    if(!empty($_POST["photostodelete"])) {
                        $item->deleteImages($_POST["photostodelete"]);
                    }
                }
            } else {
                $msg = MSG_EMPTY_FIELD;
            }
            header("Location: ../admin/".$_POST["returnpage"]."?id=".$_POST["id"]."&msg=".$msg);
            break;

        case "deletegroup":
            if(!empty($_POST["todelete"]) && Controller::validateTokenPost()) {
                foreach($_POST["todelete"] as $todelete) {
                    $item->id = $todelete;
                    $item->getById(true);
                    $item->remove();
                }
                $msg = MSG_DELETE_SUCCESS;
            }
            header("Location: ../admin/".$_POST["returnpage"]."?msg=".$msg);
            break;

        default:
            header("Location: ../admin/home");
    }
} else {
    echo "Invalid controller parameters";
    exit;
}
