<?php
include_once("../config.php");
if(!empty($_POST)) {
    $json = json_encode($_POST, JSON_PRETTY_PRINT);
    file_put_contents(BASE_PATH."/admin/emailconfig.json", $json);
    header("Location: ".APP_URL."/admin/email?msg=".MSG_UPDATE_SUCCESS);
    
} else {
    header("Location: home");
}
