<?php
include_once("../models/class-Article.php");
$article = new Article((int)$_GET["id"]);
$pic = $article->getMainImage();
?>
<h1 class="page-header">Editar Articulo / Actualidad</h1>
<ol class="breadcrumb">
    <li>
        <a href="articles" class="confirm-leave"><span class="fa fa-fw fa-comment"> </span>Articulos / Actualidad</a>
    </li>
    <li>
        <a href="add-article"><span class="fa fa-fw fa-plus"> </span>Nuevo</a>
    </li>
    <li>
        <span class="fa fa-fw fa-pencil"> </span>Editar
    </li>
</ol>
<form id="loadtrigger" action="<?php echo APP_URL; ?>/controllers/controller-Article.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $article->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-sm-5">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $article->title; ?>" required/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            Archivos: <input name="files[]" type="file" multiple="true" /><br/>
        </div>
        <div class="col-md-offset-1 col-sm-5">
            Im&aacute;gen Principal<br/>
            <a class="fancybox" href="<?php echo $pic; ?>"><img class="edit-item-image" src="<?php echo $pic; ?>"/></a>
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"><?php echo $article->content; ?></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
    <br/>
    <?php
    AdminPanelHTML::renderAdminItemImageGallery($article);
    AdminPanelHTML::renderAdminItemFileList($article);
    ?>
</form>