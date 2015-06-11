<h1 class="page-header">Nuevo Producto</h1>
<ol class="breadcrumb">
    <li>
        <a href="products"><span class="fa fa-fw fa-shopping-cart"> </span>Productos</a>
    </li>
    <li>
        <span class="fa fa-fw fa-plus"> </span>Nuevo Producto
    </li>
</ol>
<form id="loadtrigger" action="../controllers/controller-Product.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" /><br/>
            Referencia<br/>
            <input class="form-control"  type="text" name="reference" size="12" /><br/>
            Precio<br/>
            <input class="form-control money"  type="text" name="price" size="12" /><br/>
            Activo <input type="checkbox" name="active" value="1"/><br/>
            Destacado <input type="checkbox" name="featured" value="1"/><br/><br/>
            Categor&iacute;a<br/>
            <?php
            AdminPanelHTML::renderCategoriesList("ProductCategory");
            ?>
            <br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galer&iacute;a: <input type="file" name="gallery[]" multiple="true"/>
            Archivos: <input type="file" name="files[]" multiple="true"/>
            
        </div>
    </div>
    <br/>
    Descripci&oacute;n detallada
    <textarea name="content" id="full_content"></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
</form>