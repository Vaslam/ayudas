<?php
include_once("../models/class-Plan.php");
$plan = new Plan((int)$_GET["id"]);
$pic = $plan->getMainImage();
?>
<h1 class="page-header">Editar Plan</h1>
<ol class="breadcrumb">
    <li>
        <a href="plans" class="confirm-leave"><span class="fa fa-fw fa-comment"> </span>Planes</a>
    </li>
    <li>
        <a href="add-plan"><span class="fa fa-fw fa-plus"> </span>Nuevo</a>
    </li>
    <li>
        <span class="fa fa-fw fa-pencil"> </span>Editar
    </li>
</ol>
<form id="loadtrigger" action="<?php echo APP_URL; ?>/controllers/controller-Plan.php" method="post" enctype="multipart/form-data">       
    <input type="hidden" name="action" value="update"/>
    <input type="hidden" name="id" value="<?php echo $plan->id; ?>"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <div class="row">
        <div class="col-sm-5">
            Titulo*<br/>
            <input class="form-control" type="text" name="title" size="32" value="<?php echo $plan->title; ?>" required/><br/>
            Valor*<br/>
            <input class="form-control money" type="text" name="price" size="32" value="<?php echo number_format($plan->price, DECIMAL_LENGTH); ?>" required/><br/>
            Imagen Principal: <input type="file" name="picture"/><br/>
        </div>
        <div class="col-md-offset-1 col-sm-5">
            Im&aacute;gen Principal<br/>
            <a class="fancybox" href="<?php echo $pic; ?>"><img class="edit-item-image" src="<?php echo $pic; ?>"/></a>
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"><?php echo $plan->content; ?></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
</form>