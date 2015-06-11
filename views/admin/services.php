<h1 class="page-header">
    Servicios
</h1>
<?php
include_once("../models/class-Service.php");
$service = new Service();
$services = $service->find();
?>
<form id="deleteform" action="../controllers/controller-Service.php" method="post">
    
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <ol class="breadcrumb"> 
        <li>
            <a href="add-service">
                <span class="fa fa-fw fa-plus"> </span>Agregar Nuevo Servicio
            </a>
        </li>
        <li>
            <a href="#" class="deleteform" data-deleteform="deleteform">
                <span class="fa fa-fw fa-trash-o"> </span>Eliminar Seleccionados
            </a>
        </li>
    </ol>
    <?php
    if(!empty($services)) {
        ?>
        <table class="table table-bordered table-hover">
            <?php
            foreach($services as $serv) {
                $picture = $service->getMainImage((int)$serv["id"]);
                ?>	
                <tr>
                    <td class="hidden-sm hidden-xs" style="width: 128px;">
                        <?php 
                        if(!empty($picture)) {
                            ?>
                            <a href="edit-service&id=<?php echo $serv["id"]; ?>">
                                <div class="image admin-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                            </a>
                            <?php
                        } else {
                            $picture = IMAGES_URL."/nopic.png";
                            ?>
                            <div class="image admin-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                            <?php
                        }
                        ?>
                    </td>
                    <td style="text-align: justify;">
                        <p>
                            <?php
                            if($serv["featured"] == 1) {
                              ?>
                                <span class="fa fa-fw fa-star"> </span>  
                              <?php  
                            } 
                            ?>
                            <a href="edit-service&id=<?php echo $serv["id"]; ?>"><?php echo $serv["title"]; ?></a>
                            <?php
                            if($serv["active"] == 1) {
                                echo "(Activo)";
                            } else {
                                echo "(Inactivo)";
                            }
                            ?>
                        </p>
                        <p>
                            <?php echo substr(strip_tags($serv["content"]), 0, 200); ?> ... <a href="edit-service&id=<?php echo $serv["id"]; ?>">Editar</a>
                        </p>
                    </td>
                    <td style="background: #eaeaea; width: 100px; text-align: center;">
                         <a class="deletelink" href="../controllers/controller-Service.php?action=delete&id=<?php echo $serv["id"]; ?>&token=<?php echo session_id(); ?>">
                             <span class="fa fa-fw fa-trash-o"> </span> Eliminar
                         </a>
                         &nbsp;&nbsp;
                         <input type="checkbox" name="todelete[]" value="<?php echo $serv["id"]; ?>"/>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    <?php
    } else {
        AdminPanelHTML::renderUserMessage("No se ha encontrado ning&uacute;n servicio");
    }
?>
</form>
