<?php
include_once("../models/class-Gallery.php");
$Gallery = new Gallery();
?>
<form id="deleteform" action="../controllers/controller-Gallery.php" method="post">
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <h1 class="page-header">
        Galer&iacute;as Fotogr&aacute;ficas
    </h1>
    <ol class="breadcrumb"> 
        <li>
            <a href="add-gallery">
                <span class="fa fa-fw fa-plus"> </span>Agregar Nueva
            </a>
        </li>
        <li>
            <a href="#" class="deleteform" data-deleteform="deleteform">
                <span class="fa fa-fw fa-trash-o"> </span>Eliminar Seleccionadas
            </a>
        </li>
    </ol>
    
    <?php
    $params["set"] = (!empty($_GET["set"])) ? $_GET["set"] : 1;
    $params["limit"] = 20;
    $Galleries = AdminPanelHTML::renderPaginationBar($Gallery, $params);
    if(!empty($Galleries)) {
        ?>
        <table class="table table-bordered table-hover">
            <?php
            foreach($Galleries as $gal) {
                $picture = $Gallery->getMainImage((int)$gal["id"], true);
                ?>	
                <tr>
                    <td class="hidden-sm hidden-xs" style="width: 128px;">
                        <?php 
                        if(!empty($picture)) {
                            ?>
                            <a href="edit-gallery&id=<?php echo $gal["id"]; ?>">
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
                            <a href="edit-gallery&id=<?php echo $gal["id"]; ?>"><?php echo $gal["title"]; ?></a>
                        </p>
                    </td>
                    <td style="background: #eaeaea; width: 100px; text-align: center;">
                         <a class="deletelink" href="../controllers/controller-Gallery.php?action=delete&id=<?php echo $gal["id"]; ?>&token=<?php echo session_id(); ?>">Eliminar</a>
                         &nbsp;&nbsp;
                         <input type="checkbox" name="todelete[]" value="<?php echo $gal["id"]; ?>"/>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    <?php
    } else {
        AdminPanelHTML::renderUserMessage("No se ha encontrado ninguna Galer&iacute;a");
    }
?>
</form>