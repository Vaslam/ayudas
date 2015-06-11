<h1 class="page-header">Ingresar Categor&iacute;a de Producto</h1>
<ol class="breadcrumb">
    <li>
        <a href="productcategories">
            <span class="fa fa-fw fa-list-ul"> </span>Categor&iacute;as
        </a>
    </li>
    <li>
        <span class="fa fa-fw fa-plus"> </span>Nueva Categor&iacute;a
    </li>
</ol>
<form id="loadtrigger" action="../controllers/controller-Category.php" method="post" enctype="multipart/form-data"> 
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="class" value="ProductCategory"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <input type="hidden" name="returnpage" value="productcategories"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" />
            Orden<br/>
            <input class="number form-control" type="text" name="order" size="11" /><br/>
            Activo <input type="checkbox" name="active" value="1"/><br/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            <br/>
        </div>
        <div class="col-lg-offset-1 col-lg-5 col-md-offset-1 col-md-5 col-sm-12 col-xs-12">
            Categoria<br/>
            <?php 
            AdminPanelHTML::renderCategoriesList("productcategories", ITEM_TYPE_PRODUCT_CATEGORY);
            ?>
            <br/>
            <button class="btn btn-primary" type="submit">
                <span class="fa fa-fw fa-save"> </span> Guardar
            </button>
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"></textarea>
</form>