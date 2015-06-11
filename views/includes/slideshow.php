<?php 
include_once("models/class-SlideShow.php");
$obj = new SlideShow();
$slides = $obj->find(["orderby"=>"theorder DESC"]);
if(!empty($slides)) {
    ?>
    <div class="slider-wrapper">
        <div class="camera_wrap camera_white_skin" id="slider">
            <?php
            foreach($slides as $slide) {
                $img = $obj->getMainImage((int)$slide["id"]);
                if($slide["category"] == 1) {
                    ?>
                    <div data-thumb="<?php echo $img; ?>" data-src="<?php echo $img; ?>">
                        <?php
                        if(strip_tags($slide["content"]) != "") {
                        ?>
                            <div class="camera_caption moveFromBottom">
                                 <?php echo $slide["content"]; ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div data-src="<?php echo $img; ?>">
                        <?php
                        echo $slide["content"];
                        ?>
                    </div>
                    <?php
                }
                ?>
                <?php
            }
            ?>
        </div>
    </div>
<?php
} 