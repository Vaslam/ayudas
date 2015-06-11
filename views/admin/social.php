<?php
$jsonFile = file_get_contents(BASE_PATH."/admin/socialnetworkconfig.json");
$networks = json_decode($jsonFile, true);
?>
<h1 class="page-header">URL Redes Sociales</h1>
<form id="networksform" method="post" action="../controllers/controller-SocialNetwork.php">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        Facebook:<br/>
        <input type="text" class="form-control"  name="facebook" value="<?php echo $networks["facebook"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/Facebook.png"/><br/><br/>
        Twitter:<br/>
        <input type="text" class="form-control"  name="twitter" value="<?php echo $networks["twitter"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/Twitter.png"/><br/><br/>
        Youtube:<br/>
        <input type="text" class="form-control"  name="youtube" value="<?php echo $networks["youtube"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/Youtube.png"/><br/><br/>
        LinkedIn:<br/>
        <input type="text" class="form-control"  name="linkedin" value="<?php echo $networks["linkedin"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/LinkedIn.png"/><br/><br/>
        Instagram:<br/>
        <input type="text" class="form-control"  name="instagram" value="<?php echo $networks["instagram"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/Instagram.png"/><br/><br/>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        Google +:<br/>
        <input type="text" class="form-control"  name="googleplus" value="<?php echo $networks["googleplus"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/Google.png"/><br/><br/>
        Pinterest:<br/>
        <input type="text" class="form-control"  name="pinterest" value="<?php echo $networks["pinterest"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/Pinterest.png"/><br/><br/>
        Tumblr:<br/>
        <input type="text" class="form-control"  name="tumblr" value="<?php echo $networks["tumblr"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/Tumblr.png"/><br/><br/>
        Flickr:<br/>
        <input type="text" class="form-control"  name="flickr" value="<?php echo $networks["flickr"]; ?>"/>
        <img src="<?php echo SOCIAL_ICONS_SET; ?>/Flickr.png"/><br/><br/>
        <button class="btn btn-primary" type="submit">
            <span class="fa fa-fw fa-save"> </span> Guardar
        </button>
    </div>
</form>