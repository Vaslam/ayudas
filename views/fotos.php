<?php
include_once(BASE_PATH."/models/class-Gallery.php");
$gObj = new Gallery($_URL[0]);

$gallery = $gObj->getImageGallery();

?>

<div class="container">

    <?php
    if(!empty($gallery)) {
        ?>
        <div class="row">
            <div class="col-sm-3">
                <h3 class="page-header"><?php echo $gObj->title; ?></h3>
                <?php echo $gObj->description; ?>
            </div>
            <div class="col-sm-9">
                <div class="row">

                    <?php 
                    foreach($gallery as $pic) {
                        ?>
                        <a href="<?php echo $pic; ?>" class="fancybox photo-link" rel="group">
                            <div class="col-md-3 col-sm-4">
                                <div class="gallery-photo">
                                    <div class="image" style="background-image: url(<?php echo $pic; ?>)" ></div>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <?php
    }
    ?>
    
</div>
