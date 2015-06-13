<?php 
include_once("../models/class-Page.php");
$pages = (new Page)->getAll();

?>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Nav</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="home"><?php echo COMPANY_NAME; ?></a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <?php
        if($_SESSION["admininfo"]["permissionid"] === "admin") {
        ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Administrar Usuarios <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="users"><i class="fa fa-fw fa-search"></i> Ver todos</a>
                    </li>
                    <li>
                        <a href="add-user"><i class="fa fa-fw fa-plus"></i> Agregar Usuario</a>
                    </li>
                </ul>
            </li>
        <?php
        }
        ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION["admininfo"]["username"]; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="../controllers/controller-Login.php?action=logout"><i class="fa fa-fw fa-power-off"></i> Cerrar Sesi&oacute;n</a>
                </li>
            </ul>
        </li>
        <!-- /.navbar-top-links -->
    </ul>
    <!-- /.navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="../home" target="_blank"><i class="fa fa-dashboard fa-fw"></i> Ver Sitio</a>
                </li>
                
                <li>
                    <a href="social"><i class="fa fa-facebook-square fa-fw"></i> Redes Sociales</a>
                </li>
                
                <li>
                    <a href="email"><i class="fa fa-envelope-square fa-fw"></i> Configurar Correo</a>
                </li>
                
                <li>
                    <a href="services"><i class="fa fa-briefcase fa-fw"></i> Servicios</a>
                        
                </li>
                
                <li>
                    <a href="galleries"><i class="fa fa-camera fa-fw"></i> Galerías</a>
                        
                </li>
                
                <li>
                    <a href="#"><i class="fa fa-floppy-o fa-fw"></i> Software y Descargas<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="downloadcategories">Categor&iacute;as</a>
                        </li>
                        <li>
                            <a href="downloads">Gestionar Descargas</a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Productos<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="productcategories">Categor&iacute;as</a>
                        </li>
                        <li>
                            <a href="products">Gestionar Productos</a>
                        </li>
                    </ul>
                </li>
                
                <li>
                    <a href="articles"><i class="fa fa-comment fa-fw"></i> Articulos / Actualidad</a>
                </li>
                    
                <li>
                    <a href="repositories"><i class="fa fa-folder-open fa-fw"></i> Repositorios</a>
                </li>
                
                <li>
                    <a href="#"><i class="fa fa-file fa-fw"></i> P&aacute;ginas y Contenidos<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <?php
                        if(!empty($pages)) {
                            foreach($pages as $page) {
                                ?>
                                <li>
                                    <a href="edit-page?p=<?php echo $page["id"]; ?>"><?php echo $page["title"]; ?></a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>