<?php
include_once("../models/class-Repository.php");
$repObj = new Repository();
$reps = $repObj->find();
?>
<h1 class="page-header">
    Repositorios de archivos
</h1>
<form id="deleteform" action="../controllers/controller-Repository.php" method="post">
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <ol class="breadcrumb">
        <li>
            <a href="add-repository"><span class="fa fa-fw fa-plus"> </span>Nuevo Repositorio</a>
        </li>
        <li>
            <a href="#" class="deleteform" data-deleteform="deleteform">
                <span class="fa fa-fw fa-trash-o"> </span>Eliminar Seleccionadas
            </a>
        </li>
    </ol>
    <?php
    if(!empty($reps)) {
        ?>
        <table class="table table-bordered table-hover">
            <?php
            foreach($reps as $rep) {
                ?>	
                <tr>
                    <td style="text-align: justify;">
                        <span class="fa fa-fw fa-folder-open"> </span>
                        <a data-toggle="tooltip" data-placement="top" title="<?php echo $rep["content"]; ?>" href="edit-repository&id=<?php echo $rep["id"]; ?>"><?php echo $rep["title"]; ?></a>
                    </td>
                    <td style="background: #eaeaea; width: 100px; text-align: center;">
                         <a class="deletelink" href="../controllers/controller-Repository.php?action=delete&id=<?php echo $rep["id"]; ?>&token=<?php echo session_id(); ?>">Eliminar</a>
                         &nbsp;&nbsp;
                         <input type="checkbox" name="todelete[]" value="<?php echo $rep["id"]; ?>"/>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    <?php
    } else {
        AdminPanelHTML::renderUserMessage("No se ha encontrado ning&uacute;n Repositorio");
    }
?>
</form>