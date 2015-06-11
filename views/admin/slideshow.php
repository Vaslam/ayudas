<?php
include_once("../models/class-SlideShow.php");
$slide = new slideShow();
$slides = $slide->find(["orderby"=>"theorder DESC"]);
?>
<form id="deleteform" action="../controllers/controller-SlideShow.php" method="post">  
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    
    <h1 class="page-header">
        Fotos de Slideshow
    </h1>
    <ol class="breadcrumb"> 
        <li>
            <a href="add-slideshow">
                <span class="fa fa-fw fa-plus"> </span>Agregar Nuevo
            </a>
        </li>
        <li>
            <a href="#" class="deleteform" data-deleteform="deleteform">
                <span class="fa fa-fw fa-trash-o"> </span>Eliminar Seleccionados
            </a>
        </li>
    </ol>
    
    <?php
    if(!empty($slides)) {
        ?>
        <table class="table table-bordered table-hover">
            <?php
            foreach($slides as $sl) {
                $picture = $slide->getMainImage((int)$sl["id"]);
                ?>	
                <tr>
                    <td class="hidden-sm hidden-xs" style="width: 128px;">
                        <?php 
                        if(!empty($picture)) {
                            ?>
                            <a class="fancybox" href="<?php echo $picture; ?>">
                                <div class="image admin-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                            </a>
                            <?php
                        } else {
                            $picture = "../img/nopic.png";
                            ?>
                            <div class="image admin-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                            <?php
                        }
                        ?>
                    </td>
                    <td style="text-align: justify;">
                        <p style="margin: 2px;">
                            <a href="edit-slideshow&id=<?php echo $sl["id"]; ?>"><?php echo $sl["title"]; ?></a>
                            <?php
                            if($sl["active"] == 1) {
                                echo "(Activo)";
                            } else {
                                echo "(Inactivo)";
                            }
                            ?>
                        </p>
                    </td>
                    <td style="background: #f2f2f2; width: 100px; text-align: center;">
                         <a class="deletelink" href="../controllers/controller-SlideShow.php?action=delete&id=<?php echo $sl["id"]; ?>&token=<?php echo session_id(); ?>">Eliminar</a>
                         &nbsp;&nbsp;
                         <input type="checkbox" name="todelete[]" value="<?php echo $sl["id"]; ?>"/>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    <?php
    } else {
         AdminPanelHTML::renderUserMessage("No se ha encontrado ning&uacute;n Slide!");
    }
    ?>
</form>
