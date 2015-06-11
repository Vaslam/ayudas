<?php
include_once("../config.php");
include_once("../modules/class-Controller.php");
include_once("../models/class-Admin.php");

$returnPage = "../admin/users";
$action = Controller::getAction();

switch($action) {
    case "add":
        if(empty($_POST["username"]) || empty($_POST["pass1"]) || !Controller::validateTokenPost()) {
          $msg = MSG_EMPTY_FIELD;  
        } else if($_POST["pass1"] !== $_POST["pass2"]) {
            $msg = MSG_PASSWORD_MATCH_ERROR;
            $returnPage = "../admin/add-user";
        } else {
            $admin = new Admin();
            $admin->name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
            $admin->lastname = filter_var($_POST["lastname"], FILTER_SANITIZE_STRING);
            $admin->username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
            $admin->email = filter_var($_POST["name"], FILTER_SANITIZE_EMAIL);
            $admin->phonenumber = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
            $admin->cellphonenumber = filter_var($_POST["cellphone"], FILTER_SANITIZE_STRING);
            $admin->info = nl2br($_POST["info"]);
            $admin->password = md5($_POST["pass1"]);
            $admin->permissionid = $_POST["permission"];
            $admin->active = 1;
            
            if($admin->add()) {
                $msg = MSG_INSERT_SUCCESS;
            } else {
                $msg = MSG_INSERT_FAILED;
            }
        }
        header("Location: ".$returnPage."?msg=".$msg);
        break;
    
    case "update":
        if(empty($_POST["id"]) || !Controller::validateTokenPost()) {
            $msg = MSG_EMPTY_FIELD;  
        } else if(!empty($_POST["pass1"]) && ($_POST["pass1"] !== $_POST["pass2"])) {
            $msg = MSG_PASSWORD_MATCH_ERROR;
        } else {
            $returnPage = "../admin/edit-user?id=".$_POST["id"];
            $admin = new Admin();
            $admin->id = $_POST["id"];
            
            $admin->email = filter_var($_POST["name"], FILTER_SANITIZE_EMAIL);
            $admin->phonenumber = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
            $admin->cellphonenumber = filter_var($_POST["cellphone"], FILTER_SANITIZE_STRING);
            
            if(empty($_POST["isadmin"])) {
                $admin->info = nl2br($_POST["info"]);
                $admin->name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
                $admin->lastname = $_POST["lastname"];
                $admin->permissionid = $_POST["permission"];
            }
            
            $admin->active = 1;
            
            if(!empty($_POST["pass1"])) {
                $admin->password = md5($_POST["pass1"]);
            } else {
                $admin->password = null;
            }
            
            if($admin->update()) {
                $msg = MSG_UPDATE_SUCCESS;
            } else {
                $msg = MSG_UPDATE_FAILED;
            }
        }
        header("Location: ".$returnPage."&msg=".$msg);
        break;
    
    case "delete":
        if(!empty($_GET["id"]) && Controller::validateTokenGet()) {
            $admin = new Admin($_GET["id"]);
            if($admin->username != "admin" && $admin->id != 1) {
                if($admin->remove()) {
                    $msg = MSG_DELETE_SUCCESS;
                } else {
                    $msg = MSG_DELETE_FAILED;
                }
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
