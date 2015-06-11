<?php
if($_SESSION["admininfo"]["permissionid"] != "admin") {
    AdminPanelHTML::renderMessageCode(MSG_INVALID_PERMISSION);
    return;
}
?>
<h1 class="page-header">
    Nuevo Usuario
</h1>
<form action="../controllers/controller-Admin.php" method="post">
    <input type="hidden" name="action" value="add"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5">
            Nombre<br/>
            <input type="text" class="form-control" name="name"/><br/>
            Apellido<br/>
            <input type="text" class="form-control" name="lastname"/><br/>
            Usuario*<br/>
            <input type="text" class="form-control" name="username"/><br/>
            Contrase&ntilde;a*<br/>
            <input type="text" class="form-control" name="pass1"/><br/>
            Confirmar Contrase&ntilde;a*<br/>
            <input type="text" class="form-control" name="pass2"/><br/>
            Tipo<br/>
            <select class="form-control" name="permission">
                <option value="admin">Administrador</option>
                <option value="manager">Gestor de contenidos</option>
            </select>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5">
            Email<br/>
            <input type="text" class="form-control" name="email"/><br/>
            Tel&eacute;fono<br/>
            <input type="text" class="form-control" name="phone"/><br/>
            Celular<br/>
            <input type="text" class="form-control" name="cellphone"/><br/>
            Info Adicional<br/>
            <textarea rows="5" class="form-control" name="info"></textarea><br/>
            <button class="btn btn-primary" type="submit">
                <span class="fa fa-fw fa-save"> </span> Guardar
            </button>
        </div>
    </div>
    
</form>
