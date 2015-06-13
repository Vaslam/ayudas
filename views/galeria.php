<?php
include_once(BASE_PATH."/models/class-Gallery.php");

$gObj = new Gallery();
$galleries = $gObj->find();

//var_dump($galleries); //Debug
?>
<div class="container">
    
    <h1 class="page-header text-center big">Galería de Fotos</h1>
    
    <?php
    if(!empty($galleries)) {
        ?>
        <div class="row">
        <?php
            foreach($galleries as $gal) {
                $img = $gObj->getMainImage($gal["id"], true);
                ?>

                <a class="gallery-link" href="fotos/<?php echo $gal["id"]; ?>">
                    <div class="col-md-3 col-sm-4">
                        <div class="gallery-container text-center">
                            <div class="image" style="background-image: url(<?php echo $img; ?>)"></div>
                            <h3><?php echo $gal["title"]; ?></h3>
                        </div>
                    </div>
                </a>
                <?php
            }
        ?>
        </div>
        <?php
    }
    ?>
    
</div>
