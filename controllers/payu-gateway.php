<?php
include_once("../config.php");
include_once(BASE_PATH."/modules/class-ShoppingCart.php");
include_once(BASE_PATH."/modules/payu/config.php");
include_once(BASE_PATH."/models/class-Page.php");
include_once(BASE_PATH."/modules/phpmailer/PHPMailerAutoload.php");

/*
 * -- This file will do all the job again for security reasons.
 *    Retrieve Shopping Cart Session information and recalculate totals.
 * 
 *    Will also generate an email to send to the user notifing he has started
 *    a payment process. This email contains all the details from the products
 *    the user is purchasing, then, load a note (editable on the admin panel) that
 *    will be at the bottom of the email.
 */
if(!empty($_POST)) {
    $items = ShoppingCart::getCartItems();
    
    if(empty($items)) {
        echo "<h1>Error Critico</h1>";
        echo "<hp>
                Parece que ha habido un <b>error</b> al recopilar la informaci&oacute;n del carrito de compras.
                <br/>
                Por su seguridad, no se realizar&aacute; ninguna transacci&oacute;n.
                <br/><br/>
                Para regresar al sitio web haga <a href='".APP_URL."'>CLICK AQUI</a>
              </p>";
        exit;
    }
    
    //var_dump($_POST); //Debug
    //var_dump($items); //Debug
    
    /*
     * -- Initializes PHPMailer
     */
    $mail = new PHPMailer();
    $mail->isHTML(true);
    $mail->setFrom(COMPANY_EMAIL, COMPANY_NAME);
    
    /*
     * -- Recalculates totals and draws a table with the details of the purchase
     */
    $total = 0;
    $emailString = "";
    $emailBottom = (new Page)->getContent(PAGE_PURCHASE_BOTTOM);
    $productsTableString = "<table style='width: 100%; border-collapse: collapse;'>";
    foreach($items as $i) {
        $subTotal = (int)$i["price"] * (int)$i["qty"];
        $total += $subTotal;
        $productsTableString .= "<tr>";
            $productsTableString .= "<td style='padding: 8px; border: 1px solid #878787;'><a href='".APP_URL."/producto/".$i["id"]."'>".$i["title"]."</a></td>";
            $productsTableString .= "<td style='padding: 8px; border: 1px solid #878787;'>$".number_format($i["price"], DECIMAL_LENGTH)."</td>";
            $productsTableString .= "<td style='padding: 8px; border: 1px solid #878787;'>x ".$i["qty"]."</td>";
            $productsTableString .= "<td style='padding: 8px; border: 1px solid #878787;'><b>$".number_format($subTotal, DECIMAL_LENGTH)."</b></td>";
        $productsTableString .= "</tr>"; 
    }
    $productsTableString .= "</table>";
    
    $document = filter_var($_POST["document"], FILTER_SANITIZE_STRING);
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $cell = filter_var($_POST["cellnumber"], FILTER_SANITIZE_STRING);
    $phonenumber = filter_var($_POST["phonenumber"], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
    $note = str_replace("\r\n", "<br>", filter_var($_POST["note"], FILTER_SANITIZE_STRING));
    
    $emailString .= "<div style='background-color: #526a91; padding-top: 25px; padding-bottom: 25px;'>";
        $emailString .= "<center>";
            $emailString .= " <div style='text-align: left; font-family: verdana; background: #fff; border-radius: 8px; width: 90%; margin: 0 auto; padding: 25px;'>";
                $emailString .= "<h1 style='font-weight: 300; color: #59a1e5;'>Pedido en L&iacute;nea</h1>";
                $emailString .= "<img src='".COMPANY_LOGO."' style='max-width: 300px; max-height: 200px;'/>";
                //$emailString .= "<h3 style='font-weight: 300;'>".COMPANY_NAME."</h3>";
                $emailString .= "<p>";
                    $emailString .= "Este e-mail es una notificaci&oacute;n que se esta haciendo una transacci&oacute;n desde el sitio web de <b>".COMPANY_NAME."</b> y que el proceso de pago se har&aacute; con los siguientes par&aacute;metros.";
                $emailString .= "</p>";
                $emailString .= "<p>";
                    $emailString .= "<h3 style='color: #59a1e5;'>Detalles del Usuario</h3>";
                    $emailString .= "<b>Nombre Completo:</b> ".$name."<br/>";
                    $emailString .= "<b>Documento:</b> ".$document."<br/>";
                    $emailString .= "<b>E-mail:</b> ".$email."<br/>";
                    $emailString .= "<b>Celular:</b> ".$cell."<br/>";
                    $emailString .= "<b>Tel&eacute;fono:</b> ".$phonenumber."<br/>";
                    $emailString .= "<b>Direcci&oacute;n:</b> ".$address."<br/>";
                    $emailString .= "<b>Nota Adicional:</b><br/> ".$note;
                $emailString .= "</p>";
                $emailString .= "<hr/>";
                $emailString .= "<b>Detalles del Pedido:</b><br/>";
                $emailString .= $productsTableString;
                $emailString .= "<h1 style='font-weight: 300;'><span style='color: #59a1e5;'>Total:</span> $".number_format($total, DECIMAL_LENGTH)."</h1>";
                $emailString .= $emailBottom;
            $emailString .= "</div>";
        $emailString .= "</center>";
    $emailString .= "</div>";
    
    //echo $emailString; //Debug
    
    /*
    * Uncomment this only if you are using an outgoing SMTP mail server
    */
    /*
    $mail->IsSMTP();               
    $mail->SMTPDebug = 0;	
    $mail->Host = "";  				
    $mail->SMTPAuth = true;                               
    $mail->Username = "";    
    $mail->Password = "";                           
    $mail->SMTPSecure = "ssl";                            
    $mail->Port = "";
     */
    
    $mail->Subject = "Compra online ".COMPANY_NAME;
    $contactInfo = Utils::getSalesEmails(true);
    $purchaseNotificationSent = true;
    foreach($contactInfo as $address) {
        $mail->addAddress($address);
    }
    $mail->addAddress($email);
    $mail->Body = $emailString;
    
    
    if($mail->Send()) {
        $purchaseNotificationSent = true;
    }
    
    
    
    if($purchaseNotificationSent) {
        $refCode = md5($email.$name.$total.microtime());
        //ApiKey~merchantId~referenceCode~amount~currency 
        $signature = md5(PAYU_API_KEY."~".PAYU_MERCHANT_ID."~".$refCode."~".$total."~".CURRENCY);
        ?>
        <form id="payment-info" method="post" action="https://stg.gateway.payulatam.com/ppp-web-gateway/">
            <input name="merchantId"        type="hidden"  value="<?php echo PAYU_MERCHANT_ID; ?>">
            <input name="accountId"         type="hidden"  value="<?php echo PAYU_ACCOUNT_ID; ?>">
            <input name="description"       type="hidden"  value="Compra Sitio Web <?php echo COMPANY_NAME; ?>">
            <input name="referenceCode"     type="hidden"  value="<?php echo $refCode ?>">
            <input name="amount"            type="hidden"  value="<?php echo $total; ?>">
            <input name="tax"               type="hidden"  value="0" >
            <input name="taxReturnBase"     type="hidden"  value="0">
            <input name="currency"          type="hidden"  value="<?php echo CURRENCY; ?>">
            <input name="signature"         type="hidden"  value="<?php echo $signature; ?>">
            <input name="test"              type="hidden"  value="1">
            <input name="buyerEmail"        type="hidden"  value="<?php echo $email; ?>">
            <input name="responseUrl"       type="hidden"  value="<?php echo PAYU_RESPONSE_PAGE; ?>">
            <input name="confirmationUrl"   type="hidden"  value="<?php echo PAYU_CONFIRMATION_PAGE; ?>">
        </form>
        <script> 
            document.getElementById("payment-info").submit();
        </script>
        <?php
    }
    
} else {
    header("Location: index.php");
}
