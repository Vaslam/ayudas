<?php
if($_SESSION["admininfo"]["permissionid"] != "admin") {
    AdminPanelHTML::renderMessageCode(MSG_INVALID_PERMISSION);
    return;
}
include_once("../models/class-Admin.php");
$adObj = new Admin();
$admins = $adObj->find();
?>
<h1 class="page-header">
    Administradores
</h1>
<ol class="breadcrumb">
    <li>
       <a href="add-user">
        <span class="fa fa-fw fa-plus"> </span>Agregar Nuevo
    </a> 
    </li>
</ol>
<?php
if(!empty($admins)) {
    ?>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="hidden-xs">
                    Nombre
                </th>
                <th>
                    Usuario
                </th>
                <th>
                    Tipo
                </th>
                <th>

                </th>
            </tr>
        </thead>
        <?php
        foreach($admins as $admin) {
            ?>
            <tr>
                <td class="hidden-xs">
                    <a href="edit-user?id=<?php echo $admin["id"]; ?>"><?php echo $admin["name"]." ".$admin["lastname"]; ?></a>
                </td>
                <td>
                    <a href="edit-user?id=<?php echo $admin["id"]; ?>"><?php echo $admin["username"]; ?></a>
                </td>
                <td>
                    <?php echo $adObj->getPermissionName($admin["permissionid"]); ?>
                </td>
                <td>
                    <?php
                    if($admin["username"] != "admin") {
                        ?>
                        <a class="deletelink" href="../controllers/controller-Admin.php?action=delete&id=<?php echo $admin["id"]; ?>&token=<?php echo session_id(); ?>">Eliminar</a>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
<?php
}
