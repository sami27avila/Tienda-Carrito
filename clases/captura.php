<?php 

include 'config/config.php';
include 'config/database.php';
$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

/*echo '<pre>';
print_r($datos);
echo '</pre>;'*/

if(is_array($datos)){
    
    $idCliente = $_SESSION['user_cliente'];
    $sql = $con->prepare("SELECT email FROM clientes WHERE id=? AND estatus=1");
    $sql->execute([$idCliente]);
    $row_cliente = $sql->fetch(PDO::FETCH_ASSOC);

    $id_transacción = $datos['detalles']['id'];
    $monto = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    //$email = $datos['detalles']['payer']['email_address'];
    $email = $row_cliente['email'];
    //$id_cliente = $datos['detalles']['payer']['payer_id'];
    

    $sql = $con->prepare("INSERT INTO compra (id_transacción, fecha, status, email, id_cliente, total) VALUES(?,?,?,?,?,?)");
    $sql->execute([$id_transacción, $fecha_nueva, $status, $email, $idCliente, $total]);
    $id = $con->lastInsertId();

    if($id > 0){
        
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if($productos != null){
            foreach($productos as $clave => $cantidad){
                
                $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo=1 ");
                $sql->execute([$clave]);
                $row_prod[] = $sql->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);

                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES(?,?,?,?,?)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_desc, $cantidad]);
                 
            }
            include 'mailer.php';

            $asunto = "Detalles de la compra";
            $cuerpo = '<h4>Gracias por su compra</h4>';
            $cuerpo .= '<p>El ID de su compra es<b>'. $id_transacción . '</b></p>';

            $mailer = new Mailer();
            $mailer->enviarEmail($email, $asunto, $cuerpo);
        }
        unset($_SESSION['carrito']);
    }
}
?>