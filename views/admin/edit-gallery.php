<?php
include_once("../models/class-Gallery.php");
$Gallery = new Gallery((int)$_GET["id"]);
$pic = $Gallery->getMainImage();
?>
<h1 class="page-header">Editar Galer&iacute;a</h1>
<ol class="breadcrumb">
    <li>
        <a href="galleries" class="confirm-leave"><span class="fa fa-fw fa-photo"> </span>Galer&iacute;as</a>
    </li>
    <li>
        <a href="add-gallery"><span class="fa fa-fw fa-plus"> </span>Nueva</a>
    </li>
    <li>
        <span class="fa fa-fw fa-pencil"> </span>Editar
    </li>
</ol>
<form id="loadtrigger" action="<?php echo APP_URL; ?>/controllers/controller-Gallery.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $Gallery->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-sm-5">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $Gallery->title; ?>" required/><br/>
            Orden<br/>
            <input class="form-control number" type="text" name="order" size="32" value="<?php echo $Gallery->theorder; ?>"/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
        </div>
        <div class="col-md-offset-1 col-sm-5">
            Im&aacute;gen Principal<br/>
            <a class="fancybox" href="<?php echo $pic; ?>"><img class="edit-item-image" src="<?php echo $pic; ?>"/></a>
        </div>
    </div>
    <br/>
    <textarea name="content" class="form-control" rows="10"><?php echo $Gallery->description; ?></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
    <br/>
    <?php
    AdminPanelHTML::renderAdminItemImageGallery($Gallery);
    ?>
</form>