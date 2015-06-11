<?php
include_once(BASE_PATH."/modules/payu/config.php");
$ApiKey = PAYU_API_KEY;
$merchant_id = $_GET["merchantId"];
$referenceCode = $_GET['referenceCode'];
$TX_VALUE = $_GET['TX_VALUE'];
$New_value = number_format($TX_VALUE, 1, '.', '');
$currency = $_GET['currency'];
$transactionState = $_GET['transactionState'];
$firm_string = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
$created_firm = md5($firm_string);
$firm = $_GET['signature'];
$reference_pol = $_GET['reference_pol'];
$cus = $_GET['cus'];
$extra1 = $_GET['description'];
$pseBank = $_GET['pseBank'];
$lapPaymentMethod = $_GET['lapPaymentMethod'];
$transactionId = $_GET['transactionId'];

if ($_GET['polTransactionState'] == 6 && $_GET['polResponseCode'] == 5) {
	$status = "Transacción fallida";
}
else if ($_GET['polTransactionState'] == 6 && $_GET['polResponseCode'] == 4) {
	$status = "Transacción rechazada";
}
else if ($_GET['polTransactionState'] == 12 && $_GET['polResponseCode'] == 9994) {
	$status = "Pendiente, Por favor revisar si el débito fue realizado en el Banco";
}
else if ($_GET['polTransactionState'] == 14 && $_GET['polResponseCode'] == 25) {
	$status = "No se completó la transacción en el banco";
}
else if ($_GET['polTransactionState'] == 4 && $_GET['polResponseCode'] == 1) {
	$status = "Transacción aprobada";
}
else {
	$status = $_GET['message'];
}


if (strtoupper($firm) == strtoupper($created_firm)) {
    ?>
    <div class="container">
        <h1 class="text-center">Res&uacute;men de la Transacci&oacute;n</h1>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <table class="table table-striped table-bordered table-responsive">
                    <tr>
                        <td><b>Estado</b></td>
                        <td><?php echo $status; ?></td>
                    </tr>
                    <tr>
                        <td><b>ID de Transacci&oacute;n</b></td>
                        <td><?php echo $transactionId; ?></td>
                    </tr>
                    <tr>
                        <td><b>Referencia de Venta</b></td>
                        <td><?php echo $reference_pol; ?></td> 
                    </tr>
                    <tr>
                        <td><b>Referencia de Transacci&oacute;n</b></td>
                        <td><?php echo $referenceCode; ?></td>
                    </tr>
                    <?php
                    if($pseBank != null) {
                        ?>
                        <tr>
                            <td><b>cus </b></td>
                            <td><?php echo $cus; ?> </td>
                        </tr>
                        <tr>
                            <td><b>Banco </b></td>
                            <td><?php echo $pseBank; ?> </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td><b>Valor Total</b></td>
                        <td>$<?php echo number_format($TX_VALUE); ?></td>
                    </tr>
                    <tr>
                        <td><b>Moneda</b></td>
                        <td><?php echo $currency; ?></td>
                    </tr>
                    <tr>
                        <td><b>Descripci&oacute;n</b></td>
                        <td><?php echo ($extra1); ?></td>
                    </tr>
                    <tr>
                        <td><b>Entidad</b></td>
                        <td><?php echo ($lapPaymentMethod); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php
}
else {
    ?>
    <div class="container">
        <div class="alert alert-danger text-center">
            <h3>Error al validar la firma de la transacci&oacute;n</h3>
            <p>
                Aunque esto puede ser un simple error en nuestro sistema y la transacci&oacute;n haya sido exitosa,
                comunicate con nosotros lo mas pronto posible para resolver cualquier inconveniente.
            </p>
            <p>
                <strong>Pedimos disculpas por cualquier percanse ocacionado</strong>
            </p>
        </div>
    </div>
    <?php
}
