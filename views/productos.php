<?php
include_once(BASE_PATH."/models/class-Product.php");
include_once(BASE_PATH."/models/class-ProductCategory.php");
$pObj = new Product();
$set = !empty($_GET["set"]) ? $_GET["set"] : 1;
$search = !empty($_GET["keyword"]) ? $_GET["keyword"] : "";
/*
 * -- The first parameter of the URL is the Category
 */
$cat = !empty($_URL[0]) ? $_URL[0] : null;
$params = [
    "set"=>$set,
    "limit"=>20,
    "search"=>$search,
    "cat"=>$cat,
    "activeonly"=>true
];
$paginatedResult = HTML::paginateAministrableItemResult($pObj, $params);
$paginationBar = $paginatedResult["HTML"];
$products = $paginatedResult["resultSet"];

$cObj = new ProductCategory();

if(!empty($cat)) {
    $cObj->id = (int)$cat;
    $cObj->getById(true);
    $pageTitle = HTML::getCategoriesPath(new ProductCategory(), $cat);
    $headerCategoryImage = $cObj->getMainImage();
    
    $subcategories = $cObj->find(["cat"=>$cat]);
    if(empty($subcategories)) {
        $subcategories = $cObj->find(["cat"=>$cObj->category]);
    }
} else {
    $pageTitle = "Nuestros Productos";
    $sideCategories = $cObj->find(["cat"=>0]);
}
?>
<div class="products-container">
    <div class="container">
        <h2 class="products-section-title">
            <?php echo $pageTitle; ?>
        </h2>
        <?php
        if(!empty($cObj->content)) {
            ?>
            <div class="row">
                <div class="col-sm-2">
                    <img class="category-description-image" src="<?php echo $headerCategoryImage; ?>"/>
                </div>
                <div class="col-sm-10">
                    <p>
                        <?php echo $cObj->content; ?>
                    </p>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-sm-3">
                <div class="categories-list-menu hidden-xs">
                    <?php
                    if(empty($subcategories)) {
                    ?>
                        <h1>Categor&iacute;as Principales</h1>
                        <?php
                        if(!empty($sideCategories)) {
                            foreach($sideCategories as $cItem) {
                                $cImg = $cObj->getMainImage($cItem["id"], true);
                                if(empty($cImg)) {
                                    $cImg = APP_URL."/img/nopic.png";
                                }
                                ?>
                                <a href="<?php echo APP_URL."/productos/".$cItem["id"]; ?>">
                                    <div class="category-list-item">
                                        <div class="image" style="background-image: url(<?php echo $cImg; ?>);"></div> 
                                        <h4><?php echo $cItem["title"]; ?></h4>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <h1>Otras Categor&iacute;as</h1>
                        <?php
                        foreach($subcategories as $cItem) {
                            $cImg = $cObj->getMainImage($cItem["id"], true);
                            if(empty($cImg)) {
                                $cImg = APP_URL."/img/nopic.png";
                            }
                            ?>
                            <a href="<?php echo APP_URL."/productos/".$cItem["id"]; ?>">
                                <div class="category-list-item">
                                    <div class="image" style="background-image: url(<?php echo $cImg; ?>);"></div> 
                                    <h4><?php echo $cItem["title"]; ?></h4>
                                </div>
                            </a>
                            <?php
                        }
                    }
                    ?> 
                </div>
                <div class="phone-cat-list hidden-sm hidden-md hidden-lg visible-xs">
                    <?php
                    if(empty($subcategories)) {
                    ?>
                        <select class="form-control" onchange="location = this.options[this.selectedIndex].value;">
                            <option value="<?php echo APP_URL."/productos" ?>">Categorias Principales</option>
                            <?php
                            if(!empty($sideCategories)) {
                                foreach($sideCategories as $cItem) {
                                    ?>
                                    <option value="<?php echo APP_URL."/productos/".$cItem["id"]; ?>">
                                        <?php echo $cItem["title"]; ?>
                                    </option>
                                    <?php
                                }
                            ?>
                        </select>
                        <?php
                        }
                    } else {
                        ?>
                        <select class="form-control" onchange="location = this.options[this.selectedIndex].value;">
                            <option value="<?php echo APP_URL."/productos" ?>">Otras Categorias</option>
                            <?php
                            foreach($subcategories as $cItem) {
                                ?>
                                <option value="<?php echo APP_URL."/productos/".$cItem["id"]; ?>">
                                    <?php echo $cItem["title"]; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php
                    }
                    ?> 
                </div>
            </div> 
            <div class="col-sm-9">
                <div class="row">
                    <?php
                    if(!empty($products)) {
                        foreach($products as $prod) {
                            $img = $pObj->getMainImage($prod["id"], true);
                            ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="product">
                                    <a href="<?php echo APP_URL."/producto/".$prod["id"]."/".Utils::getUrlFriendlyString($prod["title"]); ?>">
                                        <div class="image" style="background-image: url(<?php echo $img; ?>)"></div>
                                        <h3><?php echo $prod["title"]; ?></h3>
                                        <p>
                                            <?php 
                                            echo substr(strip_tags($prod["content"]), 0, 120);
                                            ?> ...
                                        </p>
                                    </a>
                                    <p class="price">
                                        $<?php echo number_format($prod["price"], DECIMAL_LENGTH); ?>
                                    </p>
                                    <p class="text-right">
                                        <a class="addtocart" data-id="<?php echo $prod["id"]; ?>">
                                            Agregar al Carrito
                                            <span class="fa fa-2x fa-shopping-cart"> </span>
                                        </a>
                                    </p>

                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        echo $paginationBar;
        ?>
    </div>
</div>