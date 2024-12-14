<?php

define("CLIENT_ID", "AbvfpsZ2jmXJiyDehVwLeUDCD6eoXPrZijm_DBDSL9MwwT1YezDPBtFSD8hd55ms5pigXyWPLrd2jjjZ");
define("CURRENCY", "MXN");
define("KEY_TOKEN", "Acl.abc-386A*");
define("MONEDA", "$");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>