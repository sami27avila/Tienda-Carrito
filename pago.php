<?php 

include 'config/config.php';
include 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

print_r($_SESSION);

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1 ");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
         
    }
} else {
    header("Location: index.php");
    exit;
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
<header>
  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-title">
        <strong>Oddisey WEB</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarHeader">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-list">
            <a href="#" class="nav-link active">Catalogo</a>
         </li> 
          <li class="nav-list">
           <a href="#" class="nav-link">Contactos</a>
         </li> 
         </ul>
         <a href="carrito.php" class="btn btn-primary">Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span></a>
      </div>
    </div>
  </div>
</header>
<main id="main-page">
  <div class="container">
        <div class="row">
           <div class="col-6">
              <h4>Detalles de pago</h4>
              <div id="paypal-button-container"></div>
           </div>
           <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                       <thead>
                       <tr>
                          <th>Producto</th>
                          <th>Subtotal</th>
                          <th></th>
                       </tr>
                       </thead>
                       <tbody>
                    <?php if($lista_carrito == null){
                       echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                    
                    }else{
                      $total = 0;
                      foreach($lista_carrito as $producto){
                        $_id = $producto['id'];
                        $nombre = $producto['nombre'];
                        $precio = $producto['precio'];
                        $cantidad = $producto['cantidad'];
                        $descuento = $producto['descuento'];
                        $precio_desc = $precio - (($precio * $descuento) / 100);
                        $subtotal = $cantidad * $precio_desc;
                        $total += $subtotal;
                      
                    ?> 
                        <tr>
                        <td><?php echo $nombre; ?></td>
                        <td>
                          <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2, '.', ','); ?></div>   
                        </td>
                        </tr>
                    <?php } ?>
                        <tr>
                        <td colspan="2">
                          <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                        </td>
                        </tr>
                        </tbody>
                  <?php } ?>
                  </table>
              </div>       
          </div>
      </div>
  </div>   
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>

<script>
      paypal.Buttons({
        style: {
            color:  'blue',
            shape:  'pill',
            label:  'pay',
        },
        
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $total; ?> 
                    }
                }]
            });
            
        },
        
        onApprove: function(data, actions) {
            let URL = 'clases/captura.php'
            actions.order.capture().then(function(detalles){
                console.log(detalles);

                return fetch(url, {
                   method: 'post',
                   headers: {
                       'content-type' : 'application/json'
                   },
                   body: JSON.stringify({
                      detalles: detalles
                   })
                }).then(function(response){
                   window.location.href = "completado.php?key=" +detalles['id'];
                })
            });
        },
        
        onCancel: function(data){
            alert('Su pago ha sido cancelado');
            console.log(data);
        }
       
    }).render('#paypal-button-container');
</script>
</body>
</html>
