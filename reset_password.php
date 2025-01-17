<?php 

include 'config/config.php';
include 'config/database.php';
include 'clases/cliente_funciones.php';

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if($user_id == '' || $token == ''){
  header("Location: index.php");
  exit;
}

$db = new Database();
$con = $db->conectar();

$errors = [];

if(!verificaTokenRequest($user_id, $token, $con)){
  echo "No se puede verificar la informacion correctamente";
  exit;
}

if(!empty($_POST)){
    
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if(esNulo([$user_id, $token, $password, $repassword])){
      $errors[] = "Debe de llenar todos los campos";
    }

    if(!validaPassword($password, $repassword)){
      $errors[] = "Las contraseñas no coinciden con la informacion";
    }

    if(count($errors) == 0){
      $pass_hash = password_hash($password, PASSWORD_DEFAULT);
      if(actualizaPassword($user_id, $pass_hash, $con)){
        echo "Contraseña modificada.<br><a href='login.php'>Iniciar sesión</a>";
        exit;
      } else {
        $errors[] = "Error al modificar la contraseña. Por favor, intentelo de nuevo";
      }
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
         <a href="mostrar.php" class="btn btn-primary">Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span></a>
      </div>
    </div>
  </div>
</header>
<main class="form-login m-auto pt-4">
    <h3>Cambiar contraseña</h3>
    
    <?php mostrarMensajes($errors); ?>
    <form action="reset_password.php" method="post" class="row g-3" autocomplete="off">

    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
    <input type="hidden" name="token" id="token" value="<?= $token; ?>">

    <div class="form-floating">
      <input class="form-control" type="password" name="password" id="password" placeholder="Nueva contraseña" required>
      <label for="password">Nueva contraseña</label>
    </div>

    <div class="form-floating">
      <input class="form-control" type="password" name="repassword" id="repassword" placeholder="Confirmar contraseña" required>
      <label for="password">Confirmar contraseña</label>
    </div>
      
    <div class="d-grid gap-3 col-12">
      <button type="submit" class="btn btn-primary">Continuar</button>
    </div>

    <div class="col-12">
      <a href="login.php">Iniciar sesión</a>
    </div>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>