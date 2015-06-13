<h1 class="page-header">Agregar Galer&iacute;a</h1>
<ol class="breadcrumb">
    <li>
        <a href="galleries"><span class="fa fa-fw fa-photo"> </span> Galer&iacute;as</a>
    </li>
    <li>
        <span class="fa fa-fw fa-plus"> </span>Nueva
    </li>
</ol>
<form id="loadtrigger" action="<?php echo APP_URL; ?>/controllers/controller-Gallery.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-sm-5">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" required/><br/>
            Orden<br/>
            <input class="form-control number" type="text" name="order" size="32"/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" /> 
        </div>
    </div>
    <br/>
    Descripci&oacute;n<br/>
    <textarea name="content" class="form-control" rows="10"></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
</form>