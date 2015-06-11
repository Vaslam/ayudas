<?php
include_once("class-HTML.php");
include_once("class-Utils.php");

class AdminPanelHTML extends HTML {
    
    public static function renderHeaders() {
		?>
		<!doctype html>
		<html>
		<head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!-- Important line for device responsiveness -->
            <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
            
            <!-- Bootstrap CSS-->
            <link href="<?php echo CSS_URL; ?>/admin/bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>/admin/sb-admin.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>/style.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>/admin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
            <!-- CK Editor for content editing -->
            <script src="<?php echo JS_URL; ?>/ckeditor/ckeditor.js"></script>
            <title>Panel Administrativo</title>
		</head>
		<body class="admin">
		<?php
	}
    
    public static function renderBottom() {
        include("../views/includes/admin-footer.php");
        include("../views/includes/ajax-loader.php");
        ?>
            <!-- jQuery, very important -->
            <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
            <script src="<?php echo JS_URL; ?>/jquery.js"></script>
            <!-- Base Bootstrap Javascript -->
            <script src="<?php echo JS_URL; ?>/admin/bootstrap.min.js"></script>
            <!-- Admin Bootstrap Template Javascript -->
            <script src="<?php echo JS_URL; ?>/admin/sb-admin.js"></script>
            <!-- Global Javascript -->
            <script src="<?php echo JS_URL; ?>/module.js"></script>
		</body>
		</html>
		<?php
    }
    
    public static function renderTopPanelFrame() {
        ?>
        <div id="wrapper">
            <?php
            include_once("../views/includes/admin-menu.php");
            ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <?php
                    AdminPanelHTML::renderMessageCodeFromUrl();
    }
    
    public static function renderBottomPanelFrame() {
        ?>
                </div>
            </div>
        </div>
        <?php
    }
    
    public static function renderAdminItemImageGallery($obj) {
        $images = $obj->getImageGallery();	
        if(empty($images)) {
            ?>
            <div class="alert alert-dismissible alert-info">
                No se han adjuntado im&aacute;genes a la galer&iacute;a
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning">
                Eliminar imagenes seleccionadas <input type="checkbox" name="deleteimages" value="1"/>
            </div>
            <div class="row">
                <?php
                foreach($images as $image) {
                    ?>
                    <div class="col-md-3 col-sm-6 col-xs-6 gallery-image-container-admin">
                        <a class="fancybox" rel="group" href="<?php echo $image; ?>">
                            <div class="image " style="background-image: url('<?php echo $image; ?>');"></div>
                        </a>
                        <span class="imagecheck">Eliminar <input name="photostodelete[]" type="checkbox" value="<?php echo $image; ?>"/></span>
                    </div>
                    <?php
                }
            ?>
            </div>
            <?php
        }
    }
    
    public static function renderAdminItemFileList($obj) {
        $files = $obj->getFiles();
        if(!empty($files)) {
            ?>
            <div class="row files-container">
                <div class="alert alert-warning">
                    Eliminar archivos seleccionados <input type="checkbox" name="deletefiles" value="1"/>
                </div>
                <?php
                foreach($files as $file) {
                    $ext = strtoupper(Utils::getFileExtension($file));
                    $linkClass = "";
                    if(in_array($ext, Utils::$allowedImageExts)) {$icon = "image.png"; $linkClass = "fancybox"; }
                    if(in_array($ext, Utils::$allowedPDFexts)) {$icon = "pdf.png";}
                    if(in_array($ext, Utils::$allowedOfficeExts)) {$icon = "document.png";}
                    $exploded = explode("/", $file);
                    $filename = end($exploded);
                    ?>
                    <div class="col-lg-2 col-md-2 col sm-4 col-xs-6 file-icon">
                        <span class="imagecheck">Eliminar <input name="filestodelete[]" type="checkbox" value="<?php echo $file; ?>"/></span>  
                        <a rel="group" class="<?php echo $linkClass; ?>" href="<?php echo $file; ?>" target="_blank"><img src="<?php echo IMAGES_URL."/".$icon; ?>" style="width: 100%; max-width: 128px; min-width: 64px;" /></a>
                        <span><?php echo $filename; ?></span>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-dismissible alert-info">
                No se han adjuntado archivos
            </div>
            <?php
        }
    }
    
    
    public static function renderCategoriesList($class = "Category", $current = 0, $exclude = null) {
        /*
        * TODO: Make the categories list appear in order, and then using an array sorting algorithm,
        * make it appear with sub-items:
        * 
        * Eg:
        *      Parent Category
        *          Child Category
        *          Another Child Category
        *              Child of Child Category
        *      Another Parent Category
        * --------------------------------------
        * 
        */
        include_once("../models/class-Category.php");
        $obj = new $class();
        $categories = $obj->find();
        ?>
        <select name="category" class="form-control">
            <option value="0">NINGUNA</option>
            <?php
            if(!empty($categories)) {
                foreach($categories as $category) {
                    if(!empty($exclude)) {
                        if($category["id"] == $exclude) {
                            continue;
                        }
                    }
                    $selected = "";
                    if($category["id"] == $current) {
                       $selected = "selected='selected'";
                    }
                    ?>
                    <option <?php echo $selected; ?> value="<?php echo $category["id"]; ?>"><?php echo $category["title"]; ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <?php
    }
    
    public static function renderCategoriesPath($obj, $id) {
        $arr = $obj->getParentsInfo($id);
        if(!empty($arr)) {
            ?>
            <ol class="breadcrumb">
                <li>
                    <a href="?adminpage=categories&task=list&cat=0">
                        Categor&iacute;as principales
                    </a>
                </li>
                <?php
                foreach($arr as $val) {
                    ?>
                    <li>
                        <a href="?adminpage=categories&task=list&cat=<?php echo $val["id"]; ?>">
                            <?php echo $val["title"]; ?>
                        </a>
                    </li>
                    <?php
                }
            ?>
            </ol>
            <?php
        }
    }
    
}
