<h1 class="page-header">Ingresar Repositorio</h1>
<form id="loadtrigger" action="../controllers/controller-Repository.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" /><br/>
            Descripci&oacute;n<br/>
            <input class="form-control" type="text" name="description" /><br/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            Archivos: <input name="files[]" type="file" multiple="true" />
            <br/>
            <button class="btn btn-primary" type="submit">
                <span class="fa fa-fw fa-save"> </span> Guardar
            </button>
        </div>
    </div>
</form>