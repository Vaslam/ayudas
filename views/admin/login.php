<div class="container">
    <?php
    AdminPanelHTML::renderMessageCodeFromUrl();
    ?>
    <form class="form-signin" role="form" action="../controllers/controller-Login.php?action=login" method="post">
        <div class="panel panel-primary">
            <!--
            <div class="panel-heading">
                <h3 class="panel-title">Ingreso Administrador</h3>
            </div>
            -->
            <div class="panel-body">
                <h1 class="text-center form-signin-heading">Log-In</h1>
                <!--<img src="<?php echo COMPANY_LOGO; ?>"/>-->
                <hr/>
                <input type="text" name="username" class="form-control" placeholder="Usuario" required autofocus>
                <input type="password" name="pass" class="form-control" placeholder="Password" required>
                <button class="btn btn-primary btn-block" type="submit">
                    <span class="fa fa-fw fa-lock"> </span>
                    Ingresar
                </button>
            </div> 
        </div> 
    </form>
</div> 
<div class="login-bg"></div>