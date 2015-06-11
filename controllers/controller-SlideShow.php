<?php
include_once("../config.php");
include_once("../modules/class-Controller.php");
include_once("../models/class-SlideShow.php");

$returnPage = "../admin/slideshow";
$item = new SlideShow();
$action = Controller::getAction();

switch($action) {
    case "add":
        if(!empty($_POST["title"]) && Controller::validateTokenPost()) {
            $title = strip_tags($_POST["title"]);
            $item->title = !empty($title) ? $title : "Invalid Title";
            $item->content = $_POST["content"];
            $item->theorder = (int)$_POST["theorder"];
            $item->active = !empty($_POST["active"]) ? (int)$_POST["active"] : 0;
            $item->category = (int)$_POST["category"];
            if($item->add()) {
                if(!empty($_FILES["picture"]["name"])) {
                    $item->setMainImage($_FILES["picture"]);
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
            $returnPage = "../admin/edit-slideshow?id=".$_POST["id"];
            $item->id = (int)$_POST["id"];
            $item->getById(true);
            $item->title = strip_tags($_POST["title"]);
            $item->content = $_POST["content"];
            $item->theorder = (int)$_POST["theorder"];
            $item->active = !empty($_POST["active"]) ? (int)$_POST["active"] : 0;
            $item->category = (int)$_POST["category"];

            if($item->update() === true) {
                $msg = MSG_UPDATE_SUCCESS;
            } else {
                $msg = MSG_UPDATE_FAILED;
            }
            if(!empty($_FILES["picture"]["name"])) {
                $item->setMainImage($_FILES["picture"]);
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
        
    default:
        header("Location: ".$returnPage);
        break;
}