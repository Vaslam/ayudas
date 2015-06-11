<?php
if(!empty($_GET["p"])) {
    $action = "../controllers/controller-Page.php?action=update&id=".$_GET["p"];
    $page = new Page();
    $pageinfo = $page->getById($_GET["p"]);
} else {
    AdminPanelHTML::renderUserMessage("No se ha encontrado el contenido solicitado", "danger");
    return;
}
?>
<h1 class="page-header">Administrar Contenido</h1>
<form action="<?php echo $action; ?>" method="post">
    <?php
    if(!$page->isDefault($pageinfo["id"])) {
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a class="deletelink" href="../controllers/controller-Page.php?action=delete&id=<?php echo $_GET["p"]; ?>">Eliminar esta p&aacute;gina</a>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-sm-6">
            <b>Titulo:</b><br/>
            <input type="text" name="title" class="form-control" size="64" value="<?php echo $pageinfo["title"]; ?>"/>        
        </div>
    </div>
    <br/>
    <textarea name="content" id="full_content"><?php echo $pageinfo["content"]; ?></textarea>
    <br/>
    <button class="btn btn-primary" type="submit">
        <span class="fa fa-fw fa-save"> </span> Guardar
    </button>
</form>
<?php
