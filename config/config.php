<?php

//Configuracion del sistema
define("SITE_URL", "http://localhost:3000/Tienda-Carrito");
define("KEY_TOKEN", "Acl.abc-386A*");
define("MONEDA", "$");

//Configuracion de Paypal
define("CLIENT_ID", "AZngSZMPtOpffDb_uChrAU9x269R01s32OYn0vL67Su_4aksQP5dYieg7M0WzsgFHQMSI9ZBm9km14m5");
define("CURRENCY", "USD");

//Datos de un correo electronico
define("MAIL_HOST", "smtp.gmail.com");
define("MAIL_USER", "avilasamu27@gmail.com");
define("MAIL_PASS", "osuh lopg pyij scrq");
define("MAIL_PORT", "465");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>