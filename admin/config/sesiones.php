<?php 
session_start();
if(!isset($_SESSION['usuario'])){
    echo "Por favor redirigirse al login...no hay usuario";
    header('Location: index.php');
    exit;
}{
    print_r($_SESSION['usuario']);
}

?>