<?php
include_once("../config.php");
include_once("../modules/class-Controller.php");
include_once("../models/class-Admin.php");

$action = Controller::getAction();
$returnPage = "../admin/login";
$successPage = "../admin/home";

switch($action) {

    case "login":
        $username = trim($_POST["username"]);
        $pass = trim($_POST["pass"]);
        if(empty($username) || empty($pass)) {
            $msg = MSG_INVALID_LOGIN_DATA;
            header("Location: ".$returnPage."?msg=".$msg);
        } else {
            $admin = new Admin();
            $admininfo = $admin->login($_POST["username"], $_POST["pass"]);
            if(empty($admininfo)) {
                $msg = MSG_LOGIN_FAILED;
                header("Location: ".$returnPage."?msg=".$msg);
            } else {
                $_SESSION["admininfo"] = $admininfo;
                $_SESSION["sessionid"] = session_id();
                header("Location: ".$successPage);
            }
        }
        break;

    case "logout":
        $admin = new Admin();
        $admin->logout();
        header("Location: ".$returnPage);
        break;
    
    default:
        header("Location: ".$returnPage);
        break;

}
