<?php
include_once("../models/class-ProductCategory.php");
$category = new ProductCategory();
$cat = !empty($_GET["cat"]) ? $_GET["cat"] : 0;
$search = !empty($_GET["search"]) ? $_GET["search"] : "";
AdminPanelHTML::renderCategoriesPath($category, $cat);
$categories = $category->find(["cat"=>$cat, "search"=>$search]);

if(empty($_GET["cat"])) {
    ?>
    <h1 class="page-header">Todas las categor&iacute;as de Productos</h1>
    <?php
}
?>
<form id="deleteform" action="../controllers/controller-Category.php" method="post">
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <input type="hidden" name="returnpage" value="productcategories"/>
    <input type="hidden" name="class" value="ProductCategory"/>
    <?php
    if(empty($_GET["cat"])) {
    ?>
        <ol class="breadcrumb">
            <li>
                <a href="add-productcategory">
                    <span class="fa fa-fw fa-plus"> </span>Agregar Nueva
                </a>
            </li>
            <li>
                <a href="#" class="deleteform" data-deleteform="deleteform">
                    <span class="fa fa-fw fa-trash-o"> </span>Eliminar Seleccionados
                </a>
            </li>
        </ol>
    <?php
    }
    
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
                        <p>
                            <a href="edit-productcategory&id=<?php echo $cat["id"]; ?>"><?php echo $cat["title"]; ?></a>
                            <?php
                            if($cat["active"] == 1) {
                                echo "(Activo)";
                            } else {
                                echo "(Inactivo)";
                            }
                            ?>
                        </p>
                        <p>
                            <a href="edit-productcategory&id=<?php echo $cat["id"]; ?>">Editar</a> | <a href="productcategories&cat=<?php echo $cat["id"]; ?>">Ver Subcategorias</a>
                        </p>
                    </td>
                    <td style="background: #eaeaea; width: 100px; text-align: center;">
                        <a class="deletelink" href="../controllers/controller-Category.php?&class=ProductCategory&action=delete&id=<?php echo $cat["id"]; ?>&returnpage=productcategories&token=<?php echo session_id(); ?>">Eliminar</a>
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
        $catOrSub = "categor&iacute;a";
        if(!empty($_GET["cat"])) {
            $catOrSub = "subcategor&iacute;a";
        }
        AdminPanelHTML::renderUserMessage("No se ha encontrado ning&uacute;na ".$catOrSub."!");
    }
    ?>
</form>