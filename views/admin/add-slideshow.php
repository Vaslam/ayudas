<h1 class="page-header">Insertar Slide</h1>
<form id="loadtrigger" action="../controllers/controller-SlideShow.php" method="post" enctype="multipart/form-data">         
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-sm-4">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" />
            Orden<br/>
            <input class="form-control number"  type="text" name="theorder" size="11" /><br/>
            Activo <input type="checkbox" name="active" value="1"/><br/><br/>
            Tipo<br/>
            <select class="form-control" name="category">
                <option value="1">Foto Principal</option>
                <option value="2">HTML</option>
            </select><br/>
            Imagen Principal: <input type="file" name="picture"/><br/>
        </div>
    </div>
    <br/>
    Contenido del Caption
    <textarea name="content" id="simple_content"></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
</form>