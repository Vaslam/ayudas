<?php
include_once("modules/class-HTML.php");

class ViewRender {
    
    private static $request = "home";
    
    public static function render() {
        $base = "views/";
        
        if(isset($_GET["url"])) {
            $_URL = explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
            if(file_exists($base.$_URL[0].".php")) {
                self::$request = $_URL[0];
                unset($_URL[0]);
            } else {
                header("Location: ".APP_URL."/not-found");
            }
        }
        
        $inc = $base.self::$request.".php";
        if(!isset($_URL)) {
            $_URL = [];
        } else {
            sort($_URL);
        }
        //echo $inc; exit; //DEBUG
        HTML::renderHeaders();
        include($inc);
        HTML::renderBottom();
    }
    
    public static function getRequest() {
        return self::$request;
    }
    
}