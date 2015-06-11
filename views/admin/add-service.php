<h1 class="page-header">Ingresar Servicio</h1>
<ol class="breadcrumb"> 
    <li>
        <a href="services" class="confirm-leave">
            <span class="fa fa-fw fa-briefcase"> </span>Servicios
        </a>
    </li>
    <li>
        <span class="fa fa-fw fa-plus"> </span>Nuevo Servicio
    </li>
</ol>
<form id="loadtrigger" action="../controllers/controller-Service.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" /><br/>
            <!--Categoria<br/>-->
            <?php 
            //AdminPanelHTML::renderCategoriesList("servicecategories", ITEM_TYPE_SERVICE_CATEGORY);
            ?>
            <!--<br/>-->
            Orden<br/>
            <input class="number form-control" type="text" name="theorder" placeholder="Mayor n&uacute;mero, mayor prioridad"/><br/>
            Destacado <input type="checkbox" name="featured" value="1"/><br/>
            Activo <input type="checkbox" name="active" value="1"/><br/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            Archivos: <input name="files[]" type="file" multiple="true" />
        </div>
    </div>
    <br/>
    Contenido<br/>
    <textarea name="content" id="full_content"></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
</form>