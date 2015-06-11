<?php
include_once("../models/class-Product.php");
$prod = new Product();

/*
 * Search and pagination logic
 */
$search = !empty($_GET["search"]) ? $_GET["search"] : "";
$cat = !empty($_GET["category"]) ? $_GET["category"] : 0;
?>
<form id="search-product" action="" method="get" style="margin-top: 25px;">
    <div class="row">
        <div class="col-sm-3">
            <input class="form-control" type="text" name="search" placeholder="Buscar" value="<?php echo $search; ?>"/><br/>
        </div>
        <div class="col-sm-3">
            <?php
            AdminPanelHTML::renderCategoriesList("ProductCategory", $cat);
            ?>
        </div>
        <hr class="hidden-lg hidden-md hidden-sm"/>
        <div class="col-sm-3">
            <button class="btn btn-block btn-primary" type="submit">
                <span class="fa fa-fw fa-search"> </span> Buscar
            </button>
        </div>
    </div>
</form>
<?php
$set = isset($_GET["set"]) ? $_GET["set"] : 1;
$limit = 50;
$products = AdminPanelHTML::renderPaginationBar($prod, ["search"=>$search, "cat"=>$cat, "set"=>$set, "limit"=>$limit]);
/*
 * End Pagination and Search Logic
 */
?>
<form id="deleteform" action="../controllers/controller-Product.php" method="post">  
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    
    <h1 class="page-header">
       Productos
    </h1>
    <ol class="breadcrumb"> 
        <li>
            <a href="add-product">
                <span class="fa fa-fw fa-plus"> </span>Agregar Nuevo
            </a>
        </li>
        <li>
            <a href="productcategories">
                <span class="fa fa-fw fa-list-ul"> </span>Categor&iacute;as
            </a>
        </li>
        <li>
            <a href="#" class="deleteform" data-deleteform="deleteform">
                <span class="fa fa-fw fa-trash-o"> </span>Eliminar Seleccionados
            </a>
        </li>
    </ol>
    <?php
    if(!empty($products)) {
        ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr style="text-align: center;">
                    <th style="width: 128px;">

                    </th>
                    <th>
                        Ref
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Precio
                    </th>
                    <th style="max-width: 80px;">

                    </th>
                </tr>
            </thead>
            <?php
            foreach($products as $product) {
                $img = $prod->getMainImage((int)$product["id"], true);
                ?>
                <tr>
                    <td style="width: 128px;">
                        <div class="image admin-list-picture" style="background-image: url('<?php echo $img; ?>');"></div> 
                    </td>
                    <td>
                        <?php echo $product["reference"]; ?>
                    </td>
                    <td>
                        <a href="edit-product?id=<?php echo $product["id"]; ?>">
                            <?php 
                            echo $product["title"]; 
                            if($product["featured"] == "1") {
                                ?>
                                <span class="fa fa-fw fa-star"> </span>
                                <?php
                            }
                            ?>
                        </a>
                        <br/>
                        <b>En:</b> <i><?php echo $product["categoryname"]; ?></i>
                    </td>
                    <td>
                        $<?php echo number_format($product["price"], DECIMAL_LENGTH); ?>
                    </td>
                    <td class="centered">
                        <a href="edit-product?id=<?php echo $product["id"]; ?>" class="btn btn-primary btn-sm"><span class="fa fa-edit fa-fw"></span></a>
                        <a href="../controllers/controller-Product.php?action=delete&id=<?php echo $product["id"]; ?>&token=<?php echo session_id(); ?>" class="btn btn-danger btn-sm deletelink"><span class="fa fa-trash-o fa-fw"></span></a>
                        <input type="checkbox" name="todelete[]" value="<?php echo $product["id"]; ?>"/>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        HTML::renderUserMessage("No se han encontrado productos en el inventario", "info");
    }
    ?>
</form>