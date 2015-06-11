<?php
include_once("../config.php");
include_once("../modules/class-AdminViewRender.php");
include_once("../modules/class-AdminPanelHTML.php");

AdminPanelHTML::renderHeaders();
AdminViewRender::render();        
AdminPanelHTML::renderBottom();
