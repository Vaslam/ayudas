<h1 class="page-header">Ingresar Plan</h1>
<ol class="breadcrumb">
    <li>
        <a href="plans"><span class="fa fa-fw fa-tags"> </span>Planes</a>
    </li>
    <li>
        <span class="fa fa-fw fa-plus"> </span>Nuevo
    </li>
</ol>
<form id="loadtrigger" action="<?php echo APP_URL; ?>/controllers/controller-Plan.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-sm-5">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" required/><br/>
            Valor*<br/>
            <input class="form-control money" type="text" name="price" size="32" required/><br/>
            Imagen Principal: <input type="file" name="picture"/><br/>  
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