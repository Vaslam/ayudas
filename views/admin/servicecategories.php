<?php
include_once("../models/class-Category.php");
$category = new Category(null, "servicecategories", ITEM_TYPE_SERVICE_CATEGORY);
$category->category = !empty($_GET["cat"]) ? $_GET["cat"] : 0;
//AdminViewRender::renderCategoriesPathForAdmin($category, $searchcat);
$categories = $category->find(["search"=>$category->category, "searchByCat"=>true]);

?>
<form action="../controllers/controller-Category.php" method="post">
    <h1 class="page-header">
        Todas las Categor&iacute;as de Servicios
    </h1>
    <div class="admin-buttons">
        <a href="add-servicecategory" class="btn btn-sm btn-primary" role="button">
            Agregar Nueva
        </a>
        <button class="btn btn-sm btn-warning deleteform" type="submit">
            Eliminar Seleccionadas
        </button>
    </div>
    <?php
    AdminPanelHTML::renderCategoriesPath($category, $category->category);
    if(!empty($categories)) {
        ?>
        <table class="table table-bordered table-hover">
        <?php
            foreach($categories as $cat) {
                $picture = $category->getMainImage((int)$cat["id"]);
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
                            $picture = IMAGES_URL."/nopic.png";
                            ?>
                            <div class="image admin-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                            <?php
                        }
                        ?>
                    </td>
                    <td style="text-align: justify;">
                        <h4 style="margin: 2px;">
                            <a href="edit-servicecategory&id=<?php echo $cat["id"]; ?>"><?php echo $cat["title"]; ?></a>
                            
                            <?php
                            if($cat["active"] == 1) {
                                echo "(Activo)";
                            } else {
                                echo "(Inactivo)";
                            }
                            ?>
                        </h4>
                        <p>
                            <?php echo substr(strip_tags($cat["content"]), 0, 200); ?> ... <a href="servicecategories&cat=<?php echo $cat["id"]; ?>">Ver Subcategorias</a>
                        </p>
                    </td>
                    <td style="background: #eaeaea; width: 100px; text-align: center;">
                         <a class="deletelink" href="../controllers/controller-Category.php?returnpage=servicecategories&itemtype=<?php echo ITEM_TYPE_SERVICE_CATEGORY; ?>&action=delete&id=<?php echo $cat["id"]; ?>&table=servicecategories">Eliminar</a>
                         &nbsp;&nbsp;
                         <input type="checkbox" name="todelete[]" value="<?php echo $cat["id"]; ?>"/>
                    </td>
                </tr>
                <?php
            }
        ?>
        </table>
    <?php
    } else {
        AdminPanelHTML::renderUserMessage("No se ha encontrado ning&uacute;na categor&iacute;a!");
    }
    ?>
</form>