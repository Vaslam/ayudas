<?php
include_once("../models/class-Admin.php");

class AdminViewRender {
    
    public static function render() {
        $request = "home";
        $baseFolder = "../views/admin/";
        
        if(isset($_GET["url"])) {
            if(file_exists($baseFolder.$_GET["url"].".php")) {
                $request = $_GET["url"];
            } else {
                header("Location: home");
            }
        }
        
        $inc = $baseFolder.$request.".php";
        if($request !== "login") {
            $admin = new Admin();
            if($admin->validateAdminSession()) {
                AdminPanelHTML::renderTopPanelFrame();
                include($inc);
                AdminPanelHTML::renderBottomPanelFrame();
            } else {
                include($baseFolder."login.php");
            }
        } else {
            include($inc);
        }
        
    }
    
}