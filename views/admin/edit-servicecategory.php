<?php
include_once("../models/class-Category.php");
$category = new Category((int)$_GET["id"], "servicecategories", ITEM_TYPE_SERVICE_CATEGORY);
$pic = $category->getMainImage();
?>
<h1 class="page-header">Ingresar Categor&iacute;a de Servicio</h1>
<form id="loadtrigger" action="../controllers/controller-Category.php" method="post" enctype="multipart/form-data">   
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $category->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <input type="hidden" name="class" value="ServiceCategory"/>
    <input type="hidden" name="returnpage" value="servicecategories"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $category->title; ?>"/>
            Orden<br/>
            <input class="number form-control" type="text" name="order" size="11" value="<?php echo $category->theorder; ?>"/><br/>
            <?php
            $active = $category->active == "1" ? "checked" :  "";
            ?>
            Activo <input type="checkbox" name="active" value="1" <?php echo $active; ?>/><br/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            <br/>
        </div>
        <div class="col-lg-offset-1 col-lg-5 col-md-offset-1 col-md-5 col-sm-12 col-xs-12">
            Categoria<br/>
            <?php 
            AdminPanelHTML::renderCategoriesList("servicecategories", ITEM_TYPE_SERVICE_CATEGORY, $category->category, $category->id);
            ?>
            <br/>
            <button class="btn btn-sm btn-primary" type="submit">
                Guardar
            </button>
            <br/><br/>
            <a class="fancybox" href="<?php echo $pic; ?>"><img class="edit-item-image" src="<?php echo $pic; ?>"/></a>
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"><?php echo $category->content; ?></textarea>
    <br/>
    <?php
    AdminPanelHTML::renderAdminItemImageGallery($category);
    ?>
</form>