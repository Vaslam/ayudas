<?php

class Controller {
    
    public static function getAction() {
        if(isset($_POST["action"])) {
            return $_POST["action"];
        } else if(isset($_GET["action"])) {
            return $_GET["action"];
        }
        return "def";
    }
    
    public static function validateTokenPost() {
        return (!empty($_POST["token"]) && !empty($_SESSION["sessionid"])) && 
               ($_POST["token"] === $_SESSION["sessionid"]);
    }
    
    public static function validateTokenGet() {
        return (!empty($_GET["token"]) && !empty($_SESSION["sessionid"])) && 
               ($_GET["token"] === $_SESSION["sessionid"]);
    }
    
    public static function validateSessionId() {
        return !empty($_SESSION["sessionid"]) && 
               (session_id() === $_SESSION["sessionid"]);
    }
    
}