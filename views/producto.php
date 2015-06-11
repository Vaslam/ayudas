<?php
include_once(BASE_PATH."/models/class-Product.php");
$product = new Product($_URL[0]);
$img = $product->getMainImage();
$gallery = $product->getImageGallery();
?>
<div class="container">
    <div class="row">
        <div class="col-sm-7">
            <h1 class="page-header">
                <?php echo $product->title; ?>
                <?php 
                if(!empty($product->reference)) {
                    ?>
                    <br/><small>Referencia: <?php echo $product->reference; ?></small>
                    <?php
                }
                ?>
            </h1>
            <?php
            echo $product->content;
            if(!empty($gallery)) {
                ?>
                <hr/>
                <h1>Im&aacute;genes</h1>
                <?php
                HTML::renderItemImageGallery($product);
            }
            ?>
        </div>
        <div class="col-sm-5 main-picture-section">
            <img src="<?php echo $img; ?>" class="main-picture"/>
            <h1 class="text-center">
                $<?php echo number_format($product->price, DECIMAL_LENGTH); ?><br/>
            </h1>
            <a class="addtocart btn btn-success btn-block" data-id="<?php echo $product->id; ?>">
                Agregar al Carrito
                <span class="fa fa-shopping-cart"> </span>
            </a>
            <hr/>
            <a href="productos" class="button-dark"><span class="fa fa-fw fa-arrow-left"> </span> Volver a productos</a>
        </div>
    </div>
</div>