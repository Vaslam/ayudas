<?php
include_once("../models/class-SlideShow.php");
$slide = new SlideShow((int)$_GET["id"]);
$pic = $slide->getMainImage();
?>
<h1 class="page-header">Editar Slide</h1>
<form action="../controllers/controller-SlideShow.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $slide->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $slide->title; ?>"/>
            Orden<br/>
            <input class="form-control number" type="text" name="theorder" size="11" value="<?php echo $slide->theorder; ?>"/><br/>
            <?php
            $active = $slide->active == "1" ? "checked" :  "";
            ?>
            Activo <input type="checkbox" name="active" value="1" <?php echo $active; ?>/><br/><br/>
            Tipo<br/>
            <select class="form-control" name="category">
                <option value="1" <?php if ($slide->category == 1) { echo "selected='selected'"; } ?>>Foto Principal</option>
                <option value="2" <?php if ($slide->category == 2) { echo "selected='selected'"; } ?>>HTML</option>
            </select><br/>
            Imagen Principal: <input type="file" name="picture"/>
            <br/><br/>
            <button class="btn btn-sm btn-primary btn-block" type="submit">
                Guardar
            </button>
        </div>
        <div class="col-lg-offset-1 col-lg-5 col-md-offset-1 col-md-5 col-sm-12 col-xs-12">
            <hr class="hidden-lg hidden-ms visible-sm visible-xs"/>
            <a class="fancybox" href="<?php echo $pic; ?>"><img class="edit-item-image" src="<?php echo $pic; ?>"/></a>
        </div>
    </div>
    <br/><br/>
    Contenido del Caption
    <textarea name="content" id="simple_content"><?php echo $slide->content; ?></textarea>
</form>