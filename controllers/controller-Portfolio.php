<?php
include_once("../config.php");
include_once("../modules/class-Controller.php");
include_once("../models/class-Portfolio.php");

$returnPage = "../admin/portfolio";
$item = new Portfolio();
$action = Controller::getAction();

switch($action) {
    case "add":
        if(!empty($_POST["title"]) && Controller::validateTokenPost()) {
            $item->title = strip_tags($_POST["title"]);
            $item->content = $_POST["content"];
            $item->theorder = (int)$_POST["theorder"];
            $item->active = !empty($_POST["active"]) ? (int)$_POST["active"] : 0;
            $item->featured = !empty($_POST["featured"]) ? (int)$_POST["featured"] : 0;
            if($item->add()) {
                if(!empty($_FILES["picture"]["name"])) {
                    $item->setMainImage($_FILES["picture"]);
                }
                if(!empty($_FILES["gallery"]["name"][0])) {
                    $item->setImageGallery($_FILES["gallery"]);
                }
                if(!empty($_FILES["files"]["name"][0])) {
                    $item->setFiles($_FILES["files"]);
                }
                $msg = MSG_INSERT_SUCCESS;
            } else {
                $msg = MSG_INSERT_FAILED;
            }
        } else {
            $msg = MSG_EMPTY_FIELD;
        }
        //var_dump($item); exit;
        header("Location: ".$returnPage."&msg=".$msg);
        break;	

    case "update":
        if(!empty($_POST["title"]) && !empty($_POST["id"]) && Controller::validateTokenPost()) {
            $returnPage = "../admin/edit-portfolio?id=".$_POST["id"];
            $item->id = (int)$_POST["id"];
            $item->getById(true);
            $title = strip_tags($_POST["title"]);
            $item->title = !empty($title) ? $title : null;
            $item->content = $_POST["content"];
            $item->theorder = (int)$_POST["theorder"];
            $item->active = !empty($_POST["active"]) ? (int)$_POST["active"] : 0;
            $item->featured = !empty($_POST["featured"]) ? (int)$_POST["featured"] : 0;

            if($item->update() === true) {
                $msg = MSG_UPDATE_SUCCESS;
            } else {
                $msg = MSG_UPDATE_FAILED;
            }
            if(!empty($_FILES["picture"]["name"])) {
                $item->setMainImage($_FILES["picture"]);
            }
            if(!empty($_FILES["gallery"]["name"][0])) {
                $item->setImageGallery($_FILES["gallery"]);
            }
            if(!empty($_FILES["files"]["name"][0])) {
                $item->setFiles($_FILES["files"]);
            }
            if(!empty($_POST["deleteimages"]) && $_POST["deleteimages"] == "1") {
                if(!empty($_POST["photostodelete"])) {
                    $item->deleteImages($_POST["photostodelete"]);
                }
            }
            if(!empty($_POST["deletefiles"]) && $_POST["deletefiles"] == "1") {
                if(!empty($_POST["filestodelete"])) {
                    $item->deleteFiles($_POST["filestodelete"]);
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
        if(!empty($_GET["id"]) && Controller::validateSessionId()) {
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