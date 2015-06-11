<?php
include_once("../models/class-Service.php");
$service = new Service((int)$_GET["id"]);
$pic = $service->getMainImage();
?>
<h1 class="page-header">Editar Servicio</h1>
<form id="loadtrigger" action="../controllers/controller-Service.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $service->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $service->title; ?>"/><br/>
            Orden<br/>
            <input class="number form-control" type="text" name="theorder" size="11" value="<?php echo $service->theorder; ?>"/><br/>
            <?php
            $featured = $service->featured == "1" ? "checked" : "";
            $active = $service->active == "1" ? "checked" :  "";
            ?>
            Destacado <input type="checkbox" name="featured" value="1" <?php echo $featured; ?>/><br/>
            Activo <input type="checkbox" name="active" value="1" <?php echo $active; ?>/><br/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            Archivos: <input name="files[]" type="file" multiple="true" />
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"><?php echo $service->content; ?></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
    <?php
    AdminPanelHTML::renderAdminItemImageGallery($service);
    AdminPanelHTML::renderAdminItemFileList($service);
    ?>
</form>