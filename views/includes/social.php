<?php
$jsonFile = file_get_contents(BASE_PATH."/admin/socialnetworkconfig.json");
$networks = json_decode($jsonFile, true);
?>
<span class="social" id="social-buttons">
    <?php
    if($networks["facebook"]) { ?><a href="<?php echo $networks["facebook"]; ?>" target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/Facebook.png"/></a><?php }
    if($networks["twitter"]) { ?><a href="<?php echo $networks["twitter"]; ?>" target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/Twitter.png"/></a><?php }
    if($networks["linkedin"]) { ?><a href="<?php echo $networks["linkedin"]; ?>"target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/LinkedIn.png"/></a><?php }
    if($networks["instagram"]) { ?><a href="<?php echo $networks["instagram"]; ?>"target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/Instagram.png"/></a><?php }
    if($networks["youtube"]) { ?><a href="<?php echo $networks["youtube"]; ?>"target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/Youtube.png"/></a><?php }
    if($networks["googleplus"]) { ?><a href="<?php echo $networks["googleplus"]; ?>"target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/Google.png"/></a><?php }
    if($networks["pinterest"]) { ?><a href="<?php echo $networks["pinterest"]; ?>"target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/Pinterest.png"/></a><?php }
    if($networks["tumblr"]) { ?><a href="<?php echo $networks["tumblr"]; ?>"target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/Tumblr.png"/></a><?php }
    if($networks["flickr"]) { ?><a href="<?php echo $networks["flickr"]; ?>"target="_blank"><img src="<?php echo SOCIAL_ICONS_SET; ?>/Flickr.png"/></a><?php }
    ?>
</span>