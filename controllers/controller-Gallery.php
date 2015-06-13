<?php
include_once("../config.php");
include_once("../models/class-Gallery.php");
include_once("../modules/class-Controller.php");

$returnPage = "../admin/galleries";
$item = new Gallery();
$action = Controller::getAction();
    
switch($action) {
    case "add":
        if(!empty($_POST["title"]) && Controller::validateTokenPost()) {
            $item->title = strip_tags($_POST["title"]);
            $item->description = $_POST["content"];
            $item->theorder = (int)$_POST["order"];
            if($item->add()) {
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
        //var_dump($_FILES);
        //var_dump($item); exit;
        header("Location: ".$returnPage."&msg=".$msg);
        break;	

    case "update":
        if(!empty($_POST["title"]) && Controller::validateTokenPost()) {
            $returnPage = "../admin/edit-gallery?id=".$_POST["id"];
            $item->id = (int)$_POST["id"];
            $item->getById(true);
            $item->title = strip_tags($_POST["title"]);
            $item->description = nl2br($_POST["content"]);
            $item->theorder = (int)$_POST["order"];

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
        //var_dump($item); exit;
        header("Location: ".$returnPage."?id=".$_POST["id"]."&msg=".$msg);
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
        header("Location: ".$returnPage."?msg=".$msg);
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
    header("Location: ".$returnPage."&msg=".$msg);
    break;
}
