<div class="container">
    <form method="post" action="<?php echo APP_URL."/controllers/payu-gateway.php" ?>" id="checkout-form">
        <div class="row">
            <div class="col-sm-4">
                <div class="top-50"></div>
                <!--
                <div class="alert alert-info">
                    <p>Acontinuaci&oacute;n facilitanos todos los datos necesarios antes de acceder a la plataforma de pago.</p>
                    <p><b>Datos marcados con un asterisco (*) son obligatorios</b></p>
                </div>
                -->
                <h1>Total a Pagar:</h1>
                <div class="alert alert-success" id="total-label">
                    $<?php echo number_format($_POST["total"]); ?>
                </div>
                <a href="cart"><span class="fa fa-fw fa-shopping-cart"> </span> Volver al Carrito</a>
                <hr/>
                <h1><small>Pago Seguro con</small></h1>
                <img src="<?php echo IMAGES_URL."/payu.png"; ?>" id="payment-logo"/>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="top-50"></div>
                <div class="panel panel-success">
                    <div class="panel-body">
                        *Nombre Completo:
                        <input class="form-control" type="text" name="name" required/>
                        *No. de Documento:
                        <input class="form-control" type="text" name="document" required/>
                        *E-mail:
                        <input class="form-control" type="text" name="email" required/>
                        *Celular:
                        <input class="form-control" type="text" name="cellnumber" required/>
                        Tel&eacute;fono fijo:
                        <input class="form-control" type="text" name="phonenumber" required/>
                        *Direcci&oacute;n:
                        <input class="form-control" type="text" name="address" required/>
                        Nota adicional:
                        <textarea class="form-control" name="note" placeholder="Nota para enviar junto con el pedido"></textarea>
                        <hr/>
                        <div class="checkout-image text-center">
                            <button class="btn btn-success btn-block" type="submit">
                                <span class="fa fa-fw fa-money"> </span> Pagar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>