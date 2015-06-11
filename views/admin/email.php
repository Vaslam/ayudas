<?php
if($_SESSION["admininfo"]["permissionid"] != "admin") {
    AdminPanelHTML::renderMessageCode(MSG_INVALID_PERMISSION);
    return;
}
include_once("../modules/class-Utils.php");
$jsonFile = file_get_contents(BASE_PATH."/admin/emailconfig.json");
$config = json_decode($jsonFile, true);
?>
<h1 class="page-header">Correos Electr&oacute;nicos</h1>
<form method="post" action="../controllers/controller-EmailConfig.php">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="alert alert-info">
            Puede ingresar varios correos electronicos separando cada uno por coma ( , )
        </div>
        Emails de Contacto:<br/>
        <input type="text" class="form-control"  name="contact" value="<?php echo $config["contact"]; ?>"/><br/>
        Emails de Pedidos en Linea:<br/>
        <input type="text" class="form-control"  name="cart" value="<?php echo $config["cart"]; ?>"/><br/>
        <button class="btn btn-primary" type="submit">
            <span class="fa fa-fw fa-save"> </span> Guardar
        </button>
    </div>
</form>