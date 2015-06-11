<?php
include_once("../config.php");
include_once("../modules/class-Controller.php");
include_once("../modules/class-Utils.php");
include_once("../modules/phpmailer/PHPMailerAutoload.php");

$mail = new PHPMailer;
$mail->IsHTML(true);
$mail->SetFrom(COMPANY_EMAIL, COMPANY_NAME);
$action = Controller::getAction();

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
switch($action) {

    case "message":
        if(trim($_POST["name"]) == "") {
            $msg = MSG_EMPTY_FIELD;
        } else if(trim($_POST["email"]) == "" 
                || filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) {
            $msg = MSG_INVALID_EMAIL;
        } else if(!isset($_POST["contactmessage"]) || trim($_POST["contactmessage"]) == "") {
            $msg = MSG_EMPTY_FIELD;
        } else {
            $contactInfo = Utils::getContactEmails(true);
            $subject = "Contacto del sitio web ".COMPANY_NAME;
            $mail->Subject = $subject;
            foreach($contactInfo as $address) {
                $mail->AddAddress($address);
            }
            $mail->Body = "
                        <h1>Un visitante del sitio web ha enviado un mensaje</h1>
                        <b>Nombre:</b> ".$_POST["name"]."<br/>
                        <b>Email:</b> ".$_POST["email"]."<br/>
                        <b>Telefono / Celular:</b> ".$_POST["phone"]."<br/>
                        <h2>Mensaje:</h2> ".nl2br($_POST["contactmessage"]);

            if($mail->Send()) {
                $msg = MSG_EMAIL_SENT;
            } else {
                $msg = MSG_EMAIL_FAILED;
            }
        }
        header("Location: ../contacto?msg=".$msg);
        break;

    case "buy":
        include_once("../modules/class-ShoppingCart.php");
        if(trim($_POST["name"]) == "") {
            $msg = MSG_EMPTY_FIELD;
        } else if(trim($_POST["email"]) == "" 
                || filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) {
            $msg = MSG_INVALID_EMAIL;
        } else {
            $contactInfo = Utils::getSalesEmails(true);
            $items = ShoppingCart::getCartItems($_SESSION["cart"]);
            $subject = "Compra del Sitio Web ".COMPANY_NAME;
            $mail->Subject = $subject;
            foreach($contactInfo as $address) {
                $mail->AddAddress($address);
            }
            $mail->Body = "
                        <h1>Un visitante del sitio web ha solicitado productos</h1>
                        <b>Nombre:</b> ".$_POST["name"]."<br/>
                        <b>Email:</b> ".$_POST["email"]."<br/>
                        <b>Telefono:</b> ".$_POST["phone"]."<br/>
                        <b> Celular:</b> ".$_POST["cellphone"]."<br/>
                        <b>Direccion :</b> ".$_POST["address"]."<br/>
                        <h2>Info:</h2> ".nl2br($_POST["info"]);
            $mail->Body .= "<table cellpadding='15' verticalalign='middle' style='font-family: verdana; text-align: center; margin-top: 50px; border: 1px solid #eaeaea; border-collapse: collapse;'>";
            $mail->Body .= "<tr>
                                <td style='border: 1px solid #eaeaea; background: #eaeaea;'>Pic</td>
                                <td style='border: 1px solid #eaeaea; background: #eaeaea;'>Producto</td>
                                <td style='border: 1px solid #eaeaea; background: #eaeaea;'>Precio</td>
                                <td style='border: 1px solid #eaeaea; background: #eaeaea;'>Cant</td>
                                <td style='border: 1px solid #eaeaea; background: #eaeaea;'>Subtotal</td>
                            </tr>";
            $total = 0;
            foreach($items as $item) {
                $mail->Body .= "<tr>";
                $image = str_replace("../", "", $item["image"]);
                $mail->Body .= "<td style='width: 100px; border: 1px solid #eaeaea;'><img style='max-width: 90px; max-height: 90px;' src='".$image."'/></td>";
                $mail->Body .= "<td style='border: 1px solid #eaeaea;'>".$item["title"]."</td>";
                $subtotal = floatval($item["price"]) * (int)$item["qty"];
                $mail->Body .= "<td style='border: 1px solid #eaeaea;'> $".number_format($item["price"], 2)."</td>";
                $mail->Body .= "<td style='border: 1px solid #eaeaea;'>".$item["qty"]."</td>";
                $mail->Body .= "<td style='border: 1px solid #eaeaea;'>$".number_format($subtotal, 2)."</td>";
                $mail->Body .= "</tr>";
                $total += floatval($subtotal);
            }
            $mail->Body .= "</table><br/>";
            $mail->Body .= "<h2>Total: $<small>".number_format($total, 2)." ".CURRENCY."</small></h2>";

            if($mail->Send()) {
                $msg = MSG_EMAIL_SENT;
                ShoppingCart::emptyCart();
				?>
				<div style="text-align: center; padding: 50px;">
					<img src="<?php echo IMAGES_URL; ?>/happy.jpg" style="width: 50%; border: solid 5px #eaeaea;"/>
					<h1 style="color: #ce3f2e; font-family: verdana;">Thank you for your purchase!</h1>
					<h2 style="font-family: verdana; color: #cc872e;">And for supporting our Coffee Growers</h2>
				</div>
				<?php
            } else {
                $msg = MSG_EMAIL_FAILED;
            }
        }
        break;
}
