<h1 class="page-header">Ingresar Cliente - Portafolio</h1>
<form id="loadtrigger" action="../controllers/controller-Portfolio.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" /><br/>
            Orden<br/>
            <input class="number form-control" type="text" name="theorder" size="11" /><br/>
            Destacado <input type="checkbox" name="featured" value="1"/><br/><br/>
            Imagen Principal: <input type="file" name="picture"/>
            Galeria: <input name="gallery[]" type="file" multiple="true" />
            Archivos: <input name="files[]" type="file" multiple="true" />
            <br/>
            <button class="btn btn-sm btn-primary" type="submit">
                Insertar
            </button>
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"></textarea>
</form>