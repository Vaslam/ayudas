<?php
/*
 * -- IMPORTANT: --
 * This config file must be in the ROOT folder of the application
 * if you move this from its current location, the application wont
 * work properly
 */
session_name("ayudas"); //Change this ALWAYS when creating a new app
session_start();
date_default_timezone_set("America/New_York");

//DEBUG
error_reporting(E_ALL);
ini_set("display_errors", 1); 

/*
 * --- Creates absolute and qualified paths!
 */
define("APP_URL", "http://".$_SERVER["HTTP_HOST"]."/ayudas"); //For image/script/css/link sources
define("BASE_PATH", str_replace("\\", "/", dirname(__FILE__))); //For includes
//
//Helpful constants
define("IMAGES_URL", APP_URL."/img");
define("JS_URL", APP_URL."/js");
define("CSS_URL", APP_URL."/css");
define("UPLOADS_URL", APP_URL."/uploads");

define("COMPANY_LOGO", IMAGES_URL."/Logo.png");
define("SOCIAL_ICONS_SET", IMAGES_URL."/social/flat");

//Pages and static content
define("PAGE_HOME", 1);
define("PAGE_TOP", 2);
define("PAGE_BOTTOM", 3);
define("PAGE_ABOUT", 4);
define("PAGE_CONTACT", 5);
define("PAGE_PURCHASE_BOTTOM", 6);
define("PAGE_CLIENTS", 7);

//Company info
define("COMPANY_NAME", "Ayudas para Todos");
define("COMPANY_EMAIL", "");
define("META_KEYWORDS", "");
define("META_DESCRIPTION", "");

//**********************************************************************
//Remember to change this when working Local or on the Production Server
define("DB_SERVER", "localhost"); 
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_SELECTED_DB", "ayudas");
//**********************************************************************

define("DATE_FORMAT", "Y-m-d");
define("CURRENCY", "COP");
define("DECIMAL_LENGTH", 0);
define("FILE_MAX_SIZE", 10000000); //10MB
define("IMAGE_MAX_SIZE", 10000000); //10MB

/*
 * -- Shopping Cart
 */
define("SHOPPING_CART_MAX_ITEMS", 40);

/*
 * -- Messages
 */
define("MSG_EMPTY_FIELD", 1);
define("MSG_INVALID_PICTURE", 2);
define("MSG_INVALID_EMAIL", 3);
define("MSG_INSERT_SUCCESS", 4);
define("MSG_INSERT_FAILED", 5);
define("MSG_DELETE_SUCCESS", 6);
define("MSG_DELETE_FAILED", 7);
define("MSG_UPDATE_SUCCESS", 8);
define("MSG_UPDATE_FAILED", 9);
define("MSG_LOGIN_FAILED", 10);
define("MSG_PASSWORD_MATCH_ERROR", 11);
define("MSG_INVALID_LOGIN_DATA", 12);
define("MSG_USER_EXISTS", 13);
define("MSG_EMAIL_SENT", 14);
define("MSG_EMAIL_FAILED", 15);
define("MSG_INVALID_PERMISSION", 16);

/*
 * -- Administrable Item Types (Used by models)
 */
define("ITEM_TYPE_ADMIN", 1);
define("ITEM_TYPE_PAGE", 2);
define("ITEM_TYPE_REPOSITORY", 3);
define("ITEM_TYPE_SLIDESHOW", 4);
define("ITEM_TYPE_SERVICE", 5);
define("ITEM_TYPE_SERVICE_CATEGORY", 6);
define("ITEM_TYPE_PRODUCT", 9);
define("ITEM_TYPE_PRODUCT_CATEGORY", 10);
define("ITEM_TYPE_ARTICLE", 11);
define("ITEM_TYPE_PLAN", 12);
