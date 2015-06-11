<h1 class="page-header">Ingresar Articulo / Actualidad</h1>
<ol class="breadcrumb">
    <li>
        <a href="articles"><span class="fa fa-fw fa-comment"> </span>Articulos / Actualidad</a>
    </li>
    <li>
        <span class="fa fa-fw fa-plus"> </span>Nuevo
    </li>
</ol>
<form id="loadtrigger" action="<?php echo APP_URL; ?>/controllers/controller-Article.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-sm-5">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" required/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            Archivos: <input name="files[]" type="file" multiple="true" /><br/>   
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