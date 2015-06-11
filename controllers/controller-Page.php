<?php
include_once("../config.php");
include_once("../modules/class-Controller.php");
include_once("../models/class-Page.php");

$page = new Page();
$returnPage = "../admin/edit-page";
$action = Controller::getAction();

switch($action) {

    case "update":
        $trimtitle = trim($_POST["title"]);
        if(empty($trimtitle)) {
            $msg = "EMPTY_FIELD";
        } else {
            $page->id = $_GET["id"];
            $page->title = strip_tags($_POST["title"]);
            $page->content = $_POST["content"];
            if($page->update()) {
                $msg = MSG_UPDATE_SUCCESS;
            } else {
                $msg = MSG_UPDATE_FAILED;
            }
        }
        header("Location:".$returnPage."&p=".$_GET["id"]."&msg=".$msg);
        break;

    case "delete":
        if(!$page->isDefault($_GET["id"])) {
            if($page->remove($_GET["id"])) {
                $msg = MSG_DELETE_SUCCESS;
            } else {
                $msg = MSG_DELETE_FAILED;
            }
            header("Location: ".$returnPage);
        } else {
            header("Location: ".$returnPage."?adminpage=page&p=".$_GET["id"]);
        }
        break;
        
    default:
        header("Location: ".$returnPage);
        break;
}