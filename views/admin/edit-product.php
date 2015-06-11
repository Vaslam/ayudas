<?php
include_once("../models/class-Product.php");
if(empty($_GET["id"])) {
    AdminPanelHTML::renderUserMessage("No se ha establecido el ID del producto a editar", "danger");
    return;
}
$product = new Product((int)$_GET["id"]);
$image = $product->getMainImage();
?>
<h1 class="page-header">Editar Producto</h1>
<ol class="breadcrumb">
    <li>
        <a href="products"><span class="fa fa-fw fa-shopping-cart"> </span>Productos</a>
    </li>
    <li>
        <a href="add-product">
            <span class="fa fa-fw fa-plus"> </span>Nuevo Producto
        </a>
    </li>
    <li>
        <span class="fa fa-fw fa-edit"> </span>Editar Producto
    </li>
</ol>
<form id="loadtrigger" action="../controllers/controller-Product.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $product->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-md-5">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" value="<?php echo $product->title; ?>"/><br/>
            Referencia<br/>
            <input class="form-control"  type="text" name="reference" value="<?php echo $product->reference; ?>"/><br/>
            Precio<br/>
            <input class="form-control money"  type="text" name="price" value="<?php echo number_format($product->price, DECIMAL_LENGTH); ?>"/><br/>
            Activo <input type="checkbox" name="active" value="1" <?php echo $product->active == 1 ? "checked" : ""; ?>/><br/>
            Destacado <input type="checkbox" name="featured" value="1" <?php echo $product->featured == 1 ? "checked" : ""; ?>/><br/><br/>
            Categor&iacute;a<br/>
            <?php
            AdminPanelHTML::renderCategoriesList("ProductCategory", $product->category);
            ?>
            <br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galer&iacute;a: <input type="file" name="gallery[]" multiple="true"/>
            Archivos: <input type="file" name="files[]" multiple="true"/>
        </div>
        <div class="col-md-5 col-sm-7 col-xs-10">
            <a href="<?php echo $image; ?>" class="fancybox"><img class="edit-item-image" src="<?php echo $image; ?>"/></a>
        </div>
    </div>
    <br/>
    Descripci&oacute;n detallada
    <textarea name="content" id="full_content"><?php echo $product->content; ?></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
    <hr/>
    <?php
    AdminPanelHTML::renderAdminItemImageGallery($product);
    AdminPanelHTML::renderAdminItemFileList($product);
    ?>
</form>