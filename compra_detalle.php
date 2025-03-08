<?php 

include 'config/config.php';
include 'config/database.php';
include 'clases/cliente_funciones.php';

$token_session = $_SESSION['token'];
$orden = $_GET['orden'] ?? null;
$token = $_GET['token'] ?? null;

if($orden == null || $token == null || $token != $token_session){
    header("Location: compras.php");
    exit;
}

$db = new Database();
$con = $db->conectar();

$sqlCompra = $con->prepare("SELECT id, id_transacción, fecha, total FROM compra WHERE id_transacción = ? LIMIT 1");
$sqlCompra->execute([$orden]);
$rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
$idCompra = $rowCompra['id'];

$fecha = new DateTime($rowCompra['fecha']);
$fecha = $fecha->format('d/m/Y H:i');

$sqlDetalle = $con->prepare("SELECT id, nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
$sqlDetalle->execute([$idCompra]);

$errors = [];

if(!empty($_POST)){
    
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email= trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if(esNulo([$nombres, $apellidos, $email, $telefono, $dni, $usuario, $password, $repassword])){
        $errors[] = "Debe de llenar todos los campos";
    }

    if(!esEmail($email)){
        $errors[] = "La direccion del correo es invalida";
    }

    if(!validaPassword($password, $repassword)){
        $errors[] = "Las contraseñas no coinciden con la informacion";
    }

    if(usuarioExiste($usuario, $con)){
      $errors[] = "El nombre de usuario $usuario ya existe";
    }

    if(emailExiste($email, $con)){
      $errors[] = "El correo electronico $email ya existe";
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>

<?php include 'menu.php'; ?>

<main id="main-page">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Detalle de su compra</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>Fecha: </strong> <?php echo $fecha; ?></p>
                        <p><strong>Orden: </strong> <?php echo $rowCompra['id_transacción']; ?></p>
                        <p><strong>Total: </strong> <?php echo MONEDA . ' ' . number_format($rowCompra['total'], 2, '.', ','); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                           <tr>
                              <th>Producto</th>
                              <th>Precio</th>
                              <th>Cantidad</th>
                              <th>Subtotal</th>
                              <th></th>
                           </tr>   
                        </thead>
                        <tbody>
                           <?php while($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)) { 
                            $precio = $row['precio'];
                            $cantidad = $row['cantidad'];
                            $subtotal = $precio * $cantidad;
                            ?>
                           <tr>
                               <td><?php echo $row['nombre']; ?></td>
                               <td><?php echo MONEDA . ' ' . number_format($precio, 2, '.', ','); ?></td>
                               <td><?php echo $cantidad; ?></td>
                               <td><?php echo MONEDA . ' ' . number_format($subtotal, 2, '.', ','); ?></td>
                           </tr>
                           <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>     
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>