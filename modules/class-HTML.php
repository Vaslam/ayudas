<?php

include_once(BASE_PATH."/models/class-Page.php");

class HTML {
	
	public static function renderHeaders() {
		?>
		<!doctype html>
		<html>
		<head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="<?php echo CSS_URL; ?>/public/bootstrap/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>/public/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
            <link href="<?php echo CSS_URL; ?>/public/template.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>/style.css" rel="stylesheet">
            <title><?php echo COMPANY_NAME; ?></title>
            <meta name="keywords" content="<?php echo META_KEYWORDS; ?>"/>
            <meta name="description" content="<?php echo META_DESCRIPTION; ?>"/>
            <base href="<?php echo APP_URL; ?>/">
		</head>
        <body class="public">
		<?php
        include(BASE_PATH."/views/includes/mainmenu.php");
	}
	
	public static function renderBottom() {
        include(BASE_PATH."/views/includes/bottom.php");
		?>
            <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
            <script src="<?php echo JS_URL; ?>/jquery.js"></script>
            <script src="<?php echo JS_URL; ?>/public/bootstrap.min.js"></script>
            <script src="<?php echo JS_URL; ?>/module.js"></script>
            <script src="<?php echo JS_URL; ?>/public/shopping-cart.js"></script>
		</body>
		</html>
		<?php
	}
    
    public static function renderUserMessage($text, $type = "info") {
        ?>
        <div class="alert alert-<?php echo $type; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
            <?php echo $text; ?>
        </div>
        <?php
    }
    
    public static function renderMessageCode($code, $_type = null) {
        $arrMessages = json_decode(file_get_contents(BASE_PATH."/admin/adminmessages.json"), true);
        $text = $arrMessages[(string)$code]["text"];
        $type = empty($_type) ? $arrMessages[(string)$code]["type"] : $_type;
        ?>
        <div class="alert alert-<?php echo $type; ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
            <?php echo $text; ?>
        </div>
        <?php
    }
    
    public static function renderMessageCodeFromUrl() {
        if(!empty($_GET["msg"])) {
            self::renderMessageCode((int)$_GET["msg"]);
        }
    }
    
    public static function renderPaginationBar($obj, $params) {
        if(!is_object($obj) || !is_a($obj, "AdministrableItem")) {
            return false;
        }
        
        $params["returnCount"] = true;
        $array = $obj->find($params);
        $set = !empty($params["set"]) ? $params["set"] : 1;
        $perSet = !empty($params["limit"]) ? $params["limit"] : 99999;
        $pages = ceil((int)$array["totalCount"] / (int)$perSet);
        
        if($pages > 1 && $set <= $pages) {
            $query = preg_replace('/&set=\d*/i', '', str_replace("url=", "", http_build_query($_GET)));
            ?>
            <ul class="pagination">
            <?php
            if($set > 1) {
                ?>
                <li><a href="<?php echo $query; ?>&set=1">Primero</a></li>
                <li><a href="<?php echo $query; ?>&set=<?php echo ((int)$set - 1) ?>"><<</a></li>
                <?php
            }

            for($i = 1; $i <= $pages; $i++) {
                $class = $set == $i ? "active" : "";
                $get_add = $set + 5;
                $get_minus = $set - 5;
                if(!($i > $get_add || $i < $get_minus)) {
                    ?>
                    <li class="<?php echo $class; ?>"><a href="<?php echo $query; ?>&set=<?php echo $i.""; ?>"><?php echo $i; ?></a></li>
                    <?php
                }
            }
            
            if($set < $pages) {
                ?>
                <li><a href="<?php echo $query; ?>&set=<?php echo ((int)$set + 1); ?>">>></a></li>
                <li><a href="<?php echo $query; ?>&set=<?php echo $pages; ?>">&Uacute;ltimo >>></a></li>
                <?php
            }
            ?>
           </ul>
           <?php
        }
        unset($array["totalCount"]);
        return $array;
    }
    
    public static function paginateAministrableItemResult($obj, $params) {
        if(!is_object($obj) || !is_a($obj, "AdministrableItem")) {
            return false;
        }
        
        $params["returnCount"] = true;
        $array = [];
        $array["resultSet"] = $obj->find($params);
        $set = !empty($params["set"]) ? $params["set"] : 1;
        $perSet = !empty($params["limit"]) ? $params["limit"] : 99999;
        $pages = ceil((int)$array["resultSet"]["totalCount"] / (int)$perSet);
        $html = "";
        
        if($pages > 1 && $set <= $pages) {
            $query = preg_replace('/&set=\d*/i', '', str_replace("url=", "", http_build_query($_GET)));
            $html .= '<ul class="pagination">';
            if($set > 1) {
                $html .= '
                    <li><a href="'.$query.'&set=1">Primero</a></li>
                    <li><a href="'.$query.'&set='.((int)$set - 1).'"><<</a></li>';
            }

            for($i = 1; $i <= $pages; $i++) {
                $class = $set == $i ? "active" : "";
                $get_add = $set + 5;
                $get_minus = $set - 5;
                if(!($i > $get_add || $i < $get_minus)) {
                    $html .= '<li class="'.$class.'"><a href="'.$query.'&set='.$i.'">'.$i.'</a></li>';
                }
            }
            
            if($set < $pages) {
                $html .= '
                    <li><a href="'.$query.'&set='.((int)$set + 1).'">>></a></li>
                    <li><a href="'.$query.'&set='.$pages.'">&Uacute;ltimo</a></li>';
            }
            ?>
           </ul>
           <?php
        }
        unset($array["resultSet"]["totalCount"]);
        $array["HTML"] = $html;
        return $array;
    }
    
    public static function renderItemImageGallery($obj) {
        $images = $obj->getImageGallery((int)$obj->id);	
        if(!empty($images)) {
            ?>
            <div class="row">
                <?php
                foreach($images as $image) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 gallery-image-container">
                        <a class="fancybox" rel="group" href="<?php echo $image; ?>">
                            <div class="image " style="background-image: url('<?php echo $image; ?>');"></div>
                        </a>
                    </div>
                    <?php
                }
            ?>
            </div>
            <?php
        }
    }
    
    public static function renderCategoriesPath($obj, $id) {
        $arr = $obj->getParentsInfo($id);
        if(!empty($arr)) {
            ?>
            <a href="<?php echo APP_URL."/productos"; ?>">
                Principales
            </a> 
            <?php
            foreach($arr as $val) {
                ?>
                &nbsp;>&nbsp;
                <a href="<?php echo APP_URL."/productos/".$val["id"]; ?>">
                    <?php echo $val["title"]; ?>
                </a>
                <?php
            }
        }
    }
    
    public static function getCategoriesPath($obj, $id) {
        $arr = $obj->getParentsInfo($id);
        $html = "";
        if(!empty($arr)) {
            $html .= " 
            <a href='".APP_URL."/productos'>
                Productos
            </a>";
           
            foreach($arr as $val) {
                $html .= "&nbsp;>&nbsp;
                <a href='".APP_URL."/productos/".$val["id"]."'>
                    ".$val["title"]."
                </a>";
            }
        }
        return $html;
    }
    
}

