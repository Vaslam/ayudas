<?php
include_once("../models/class-ProductCategory.php");
if(empty($_GET["id"])) {
    AdminPanelHTML::renderUserMessage("No se ha establecido un ID para la edici&oacute;n", "danger");
    exit;
}
$cat = new ProductCategory((int)$_GET["id"]);
$img = $cat->getMainImage();
?>
<h1 class="page-header">Ingresar Categor&iacute;a de Producto</h1>
<ol class="breadcrumb">
    <li>
        <a href="productcategories">
            <span class="fa fa-fw fa-list-ul"> </span>Categor&iacute;as
        </a>
    </li>
    <li>
        <a href="add-productcategory">
            <span class="fa fa-fw fa-plus"> </span>Agregar Nueva
        </a>
    </li>
    <li>
        <span class="fa fa-fw fa-edit"> </span>Editar Categor&iacute;a
    </li>
</ol>
<form id="loadtrigger" action="../controllers/controller-Category.php" method="post" enctype="multipart/form-data"> 
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $cat->id; ?>"/>
    <input type="hidden" name="class" value="ProductCategory"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <input type="hidden" name="returnpage" value="edit-productcategory"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $cat->title; ?>"/>
            Orden<br/>
            <input class="number form-control" type="text" name="order" size="11" value="<?php echo $cat->theorder; ?>" /><br/>
            Activo <input type="checkbox" name="active" value="1" <?php echo $cat->active == 1 ? "checked" : ""; ?>/><br/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            <br/>
        </div>
        <div class="col-lg-offset-1 col-lg-5 col-md-offset-1 col-md-5 col-sm-12 col-xs-12">
            Categoria<br/>
            <?php 
            AdminPanelHTML::renderCategoriesList("ProductCategory", $cat->category, $cat->id);
            ?>
            <br/>
            <img class="edit-item-image" src="<?php echo $img; ?>"/>
            <br/>
            <button class="btn btn-primary" type="submit">
                <span class="fa fa-fw fa-save"> </span> Guardar
            </button>
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"><?php echo $cat->content; ?></textarea>
    <hr/>
    <?php
    AdminPanelHTML::renderAdminItemImageGallery($cat);
    ?>
</form>