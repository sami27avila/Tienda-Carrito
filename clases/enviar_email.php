<?php
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';


$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP:: DEBUG_OFF;                    
    $mail->isSMTP();                                            
    $mail->Host       = MAIL_HOST;                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = MAIL_USER;                     
    $mail->Password   = MAIL_PASS;                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = MAIL_PORT;        //use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('mercancias@empresasWEB.com', 'TIENDA EW');
    $mail->addAddress('contacto@empresasWEB.com', 'Joe User');     

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Detalles de la compra';
    
    $cuerpo = '<h4>Gracias por su compra</h4>';
    $cuerpo .= '<p>El ID de su compra es<b>'. $id_transacción . '</b></p>';

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();
} catch (Exception $e) {
    echo "Se ha producido un error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
    //exit;
}
