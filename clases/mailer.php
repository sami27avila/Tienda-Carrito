<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer {
    
    function enviarEmail($email, $asunto, $cuerpo){
        
        require_once './config/config.php';
        require './phpmailer/src/PHPMailer.php';
        require './phpmailer/src/SMTP.php';
        require './phpmailer/src/Exception.php';

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

          //Correo emisor y nombre
          $mail->setFrom(MAIL_USER, 'ODDYSEY WEB');
          //Correo receptor y nombre
          $mail->addAddress($email, 'Contacto de usuario');     

          //Contenido
          $mail->isHTML(true);                                  
          $mail->Subject = $asunto;
    
          //Cuerpo del correo
          $mail->Body    = utf8_decode($cuerpo);
          $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

          if($mail->send()){
              return true;
          } else {
              return false;
          }

        } catch (Exception $e) {
           echo "Se ha producido un error al enviar el correo electronico de la compra: {$mail->ErrorInfo}";
           return false;
           //exit;
        }

    }
    
}