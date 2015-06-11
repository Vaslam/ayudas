<?php
include_once("../config.php");
if(!empty($_POST)) {
    $json = json_encode($_POST);
    file_put_contents(BASE_PATH."/admin/socialnetworkconfig.json", $json);
    header("Location: ".APP_URL."/admin/social?msg=".MSG_UPDATE_SUCCESS);
    
} else {
    header("Location: ".APP_URL."/admin/social?msg=".MSG_UPDATE_FAILED);
}
