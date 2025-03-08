<?php 

include 'config/config.php';
include 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1 ");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


//session_destroy();

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
      <div class="product-order">
          <strong class="text-order">6 Productos encontrados</strong>
          Ordernar por: <select name="" id="">
              <option value="">Precio más altos</option>
              <option value="">Precio más bajos</option>
              <option value="">Nombre A-Z</option>
              <option value="">Nombre Z-A</option>
          </select>
      </div>
      </div>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
         <?php foreach($resultado as $row) { ?>
         <div class="col">
              <div class="card shadow-sm">
                 <?php
                 
                 $id = $row['id'];
                 $imagen = "images/productos/$id/principal.jpg";

                 if(!file_exists($imagen)){
                    $imagen = "images/no-photo.jpg";
                 }
                 ?>
                 <img src="<?php echo $imagen; ?>" alt="Imagen de producto" width="350px" height="240px">
                 <div class="card-body">
                     <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                     <p class="card-text">$ <?php echo number_format($row['precio'], 2, '.', ','); ?></p>
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="btn-group">
                              <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha384', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>  
                          </div>
                          <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha384', $row['id'], KEY_TOKEN); ?>')">Agregar</button>
                     </div>                       
                 </div>
             </div>
         </div>
         <?php } ?>
      </div>
  </div>       
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    function addProducto(id, token){
        let url = 'clases/carrito.php'
        let formData = new FormData()
        formData.append('id', id)
        formData.append('token', token)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
        .then(data =>{
            if(data.ok){
                let elemento = document.getElementById("num_cart")
                elemento.innerHTML = data.numero
            }
        })
    }
</script>
</body>
</html>