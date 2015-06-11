<?php
include_once("../models/class-Portfolio.php");
$port = new Portfolio((int)$_GET["id"]);
$pic = $port->getMainImage();
?>
<h1 class="page-header">Actualizar Cliente - Portafolio</h1>
<form id="loadtrigger" action="../controllers/controller-Portfolio.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $port->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $port->title; ?>"/><br/>
            Orden<br/>
            <input class="number form-control" type="text" name="theorder" size="11" value="<?php echo $port->theorder; ?>"/><br/>
            <?php
            $featured = $port->featured == "1" ? "checked" : "";
            ?>
            Destacado <input type="checkbox" name="featured" value="1" <?php echo $featured; ?>/><br/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            Archivos: <input name="files[]" type="file" multiple="true" />
            <br/>
            <button class="btn btn-sm btn-primary" type="submit">
                Insertar
            </button>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <a class="fancybox" href="<?php echo $pic; ?>"><img class="edit-item-image" src="<?php echo $pic; ?>"/></a>
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"><?php echo $port->content; ?></textarea>
    <br/>
    <?php
    AdminPanelHTML::renderAdminItemImageGallery($port);
    AdminPanelHTML::renderAdminItemFileList($port);
    ?>
</form>