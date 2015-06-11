<?php
include_once("../models/class-Portfolio.php");
$portObj = new Portfolio();
$portfolios = $portObj->find();
?>
<form action="../controllers/controller-Portfolio.php" method="post">
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <h1 class="page-header">
        Portafolio - Clientes
    </h1>
    <div class="admin-buttons">
        <a href="add-portfolio" class="btn btn-sm btn-primary" role="button">
            Agregar Nuevo
        </a>
        <button class="btn btn-sm btn-warning deleteform" type="submit">
            Eliminar Seleccionados
        </button>
    </div>
    <?php
    if(!empty($portfolios)) {
        ?>
        <table class="table table-bordered table-hover">
            <?php
            foreach($portfolios as $serv) {
                $picture = $portObj->getMainImage((int)$serv["id"]);
                ?>	
                <tr>
                    <td class="hidden-sm hidden-xs" style="width: 128px;">
                        <?php 
                        if(!empty($picture)) {
                            ?>
                            <a href="edit-portfolio&id=<?php echo $serv["id"]; ?>">
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
                        <h4 style="margin: 2px;">
                            <?php
                            if($serv["featured"] == 1) {
                              ?>
                              <img src="../img/star.png"/>
                              <?php  
                            } 
                            ?>
                            <a href="edit-portfolio&id=<?php echo $serv["id"]; ?>"><?php echo $serv["title"]; ?></a>
                        </h4>
                        <p>
                            <?php echo substr(strip_tags($serv["content"]), 0, 200); ?> ... <a href="edit-portfolio&id=<?php echo $serv["id"]; ?>">Editar</a>
                        </p>
                    </td>
                    <td style="background: #eaeaea; width: 100px; text-align: center;">
                         <a class="deletelink" href="../controllers/controller-Portfolio.php?action=delete&id=<?php echo $serv["id"]; ?>">Eliminar</a>
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
        AdminPanelHTML::renderUserMessage("No se ha encontrado ning&uacute;n Cliente - Portafolio");
    }
?>
</form>