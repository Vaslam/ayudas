<?php
if($_SESSION["admininfo"]["permissionid"] != "admin") {
    AdminPanelHTML::renderMessageCode(MSG_INVALID_PERMISSION);
    return;
}
include_once("../models/class-Admin.php");
$admin = new Admin($_GET["id"]);
$adminDisabled = "";
?>
<h1 class="page-header">
    Editar Usuario
</h1>
<ol class="breadcrumb">
    <li>
       <a href="add-user">
           <span class="fa fa-fw fa-plus"> </span>Agregar Nuevo
       </a> 
    </li>
    <li>
        <span class="fa fa-fw fa-edit"> </span>Editar Usuario
    </li>
</ol>
<form action="../controllers/controller-Admin.php" method="post">
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $admin->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <?php
    if($admin->username === "admin" && $admin->id == 1) {
        $adminDisabled = "disabled";
        ?>
        <input type="hidden" name="isadmin" value="1"/>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5">
            Nombre<br/>
            <input <?php echo $adminDisabled; ?> type="text" class="form-control" name="name" value="<?php echo $admin->name; ?>"/><br/>
            Apellido<br/>
            <input <?php echo $adminDisabled; ?> type="text" class="form-control" name="lastname" value="<?php echo $admin->lastname; ?>"/><br/>
            Usuario*<br/>
            <input  type="text" class="form-control" name="username" value="<?php echo $admin->username; ?>" disabled/><br/>
            Contrase&ntilde;a*<br/>
            <input type="password" class="form-control" name="pass1" placeholder="Dejar vacio si no desea cambiarla"/><br/>
            Confirmar Contrase&ntilde;a*<br/>
            <input type="password" class="form-control" name="pass2" placeholder="Dejar vacio si no desea cambiarla"/><br/>
            Tipo<br/>
            <select <?php echo $adminDisabled; ?> class="form-control" name="permission">
                <option value="admin" <?php echo $admin->permissionid == "admin" ? "selected" : ""; ?>>Administrador</option>
                <option value="manager" <?php echo $admin->permissionid == "manager" ? "selected" : ""; ?>>Gestor de contenidos</option>
            </select>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5">
            Email<br/>
            <input type="text" class="form-control" name="email" value="<?php echo $admin->email; ?>"/><br/>
            Tel&eacute;fono<br/>
            <input type="text" class="form-control" name="phone" value="<?php echo $admin->phonenumber; ?>"/><br/>
            Celular<br/>
            <input type="text" class="form-control" name="cellphone" value="<?php echo $admin->cellphonenumber; ?>"/><br/>
            Info Adicional<br/>
            <textarea <?php echo $adminDisabled; ?> rows="5" class="form-control" name="info"><?php echo $admin->info; ?></textarea><br/>
            <button class="btn btn-primary" type="submit">
                <span class="fa fa-fw fa-save"> </span> Guardar
            </button>
        </div>
    </div>
    
</form>
