<?php

include 'config/config.php';
include 'config/database.php';
include 'clases/cliente_funciones.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    header("Location: index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();

echo validaToken($id, $token, $con);

?>