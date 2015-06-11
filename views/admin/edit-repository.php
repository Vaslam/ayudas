<?php
include_once("../models/class-Repository.php");
$service = new Repository((int)$_GET["id"]);
$pic = $service->getMainImage();
?>
<h1 class="page-header">Editar Repositorio</h1>
<ol class="breadcrumb">
    <li>
        <a href="repositories"><span class="fa fa-fw fa-folder-open"> </span>Repositorios</a>
    </li>
    <li>
        <a href="add-repository"><span class="fa fa-fw fa-plus"> </span>Nuevo Repositorio</a>
    </li>
</ol>
<form id="loadtrigger" action="../controllers/controller-Repository.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $service->id ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $service->title; ?>"/><br/>
            Descripci&oacute;n<br/>
            <input class="form-control" type="text" name="description" size="32" value="<?php echo $service->content; ?>"/><br/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            Archivos: <input name="files[]" type="file" multiple="true" />
            <br/>
            <button class="btn btn-primary" type="submit">
                <span class="fa fa-fw fa-save"> </span> Guardar
            </button>
        </div>
        <div class="col-lg-offset-1 col-lg-5 col-md-offset-1 col-md-5 col-sm-12 col-xs-12">
            <a class="fancybox" href="<?php echo $pic; ?>"><img class="edit-item-image" src="<?php echo $pic; ?>"/></a>
        </div>
    </div>
    <hr/>
    <?php
    AdminPanelHTML::renderAdminItemImageGallery($service);
    AdminPanelHTML::renderAdminItemFileList($service);
    ?>
</form>