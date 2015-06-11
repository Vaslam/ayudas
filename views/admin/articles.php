<?php
include_once("../models/class-Article.php");
$article = new Article();
?>
<form id="deleteform" action="../controllers/controller-Article.php" method="post">
    <input type="hidden" name="action" value="deletegroup"/>
    <input type="hidden" name="token" value="<?php echo session_id(); ?>"/>
    <h1 class="page-header">
        Noticias / Actualidad
    </h1>
    <ol class="breadcrumb"> 
        <li>
            <a href="add-article">
                <span class="fa fa-fw fa-plus"> </span>Agregar Nueva Noticia
            </a>
        </li>
        <li>
            <a href="#" class="deleteform" data-deleteform="deleteform">
                <span class="fa fa-fw fa-trash-o"> </span>Eliminar Seleccionadas
            </a>
        </li>
    </ol>
    
    <?php
    $params["set"] = (!empty($_GET["set"])) ? $_GET["set"] : 1;
    $params["limit"] = 20;
    $articles = AdminPanelHTML::renderPaginationBar($article, $params);
    if(!empty($articles)) {
        ?>
        <table class="table table-bordered table-hover">
            <?php
            foreach($articles as $art) {
                $picture = $article->getMainImage((int)$art["id"], true);
                ?>	
                <tr>
                    <td class="hidden-sm hidden-xs" style="width: 128px;">
                        <?php 
                        if(!empty($picture)) {
                            ?>
                            <a href="edit-article&id=<?php echo $art["id"]; ?>">
                                <div class="image admin-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                            </a>
                            <?php
                        } else {
                            $picture = IMAGES_URL."/nopic.png";
                            ?>
                            <div class="image admin-list-picture" style="background-image: url('<?php echo $picture; ?>')"></div>
                            <?php
                        }
                        ?>
                    </td>
                    <td style="text-align: justify;">
                        <h4 style="margin: 2px;">
                            <a href="edit-article&id=<?php echo $art["id"]; ?>"><?php echo $art["title"]; ?></a>
                        </h4>
                        <h5><b>Creada</b> <?php echo Utils::removeAccents($art["datemodified"]); ?></h5>
                        <p>
                            <?php echo substr(strip_tags($art["content"]), 0, 200); ?> ... <a href="edit-article&id=<?php echo $art["id"]; ?>">Editar</a>
                        </p>
                    </td>
                    <td style="background: #eaeaea; width: 100px; text-align: center;">
                         <a class="deletelink" href="../controllers/controller-Article.php?action=delete&id=<?php echo $art["id"]; ?>&token=<?php echo session_id(); ?>">Eliminar</a>
                         &nbsp;&nbsp;
                         <input type="checkbox" name="todelete[]" value="<?php echo $art["id"]; ?>"/>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    <?php
    } else {
        AdminPanelHTML::renderUserMessage("No se ha encontrado ninguna Noticia");
    }
?>
</form>