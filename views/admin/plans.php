<?php
include_once("../models/class-Plan.php");
$plan = new Plan();
?>
<form id="deleteform" action="../controllers/controller-Plan.php" method="post">
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <h1 class="page-header">
        Planes
    </h1>
    <ol class="breadcrumb"> 
        <li>
            <a href="add-plan">
                <span class="fa fa-fw fa-plus"> </span>Agregar Nuevo Plan
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
    $params["orderby"] = "price ASC";
    $plans = AdminPanelHTML::renderPaginationBar($plan, $params);
    if(!empty($plans)) {
        ?>
        <table class="table table-bordered table-hover">
            <?php
            foreach($plans as $pl) {
                $picture = $plan->getMainImage((int)$pl["id"], true);
                ?>	
                <tr>
                    <td class="hidden-sm hidden-xs" style="width: 64px;">
                        <?php 
                        if(!empty($picture)) {
                            ?>
                            <a href="edit-plan&id=<?php echo $pl["id"]; ?>">
                                <div class="image admin-list-picture-sm" style="background-image: url('<?php echo $picture; ?>')"></div>
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
                        <p style="margin: 2px;">
                            <a href="edit-plan&id=<?php echo $pl["id"]; ?>"><?php echo $pl["title"]; ?></a>
                        </p>
                        <p>
                            <b>$<?php echo number_format($pl["price"]); ?></b>
                        </p>
                    </td>
                    <td style="background: #eaeaea; width: 100px; text-align: center;">
                         <a class="deletelink" href="../controllers/controller-Plan.php?action=delete&id=<?php echo $pl["id"]; ?>&token=<?php echo session_id(); ?>">Eliminar</a>
                         &nbsp;&nbsp;
                         <input type="checkbox" name="todelete[]" value="<?php echo $pl["id"]; ?>"/>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    <?php
    } else {
        AdminPanelHTML::renderUserMessage("No se ha encontrado ningun Plan");
    }
?>
</form>