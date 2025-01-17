<?php 

include 'config/config.php';
include 'config/database.php';
include 'clases/cliente_funciones.php';
$db = new Database();
$con = $db->conectar();

$errors = [];

if(!empty($_POST)){
    
    $email= trim($_POST['email']);
    
    if(esNulo([$email])){
        $errors[] = "Debe de llenar todos los campos";
    }

    if(!esEmail($email)){
        $errors[] = "La direccion del correo es invalida";
    }

    if(count($errors) == 0){
        if(emailExiste($email, $con)){
            $sql = $con->prepare("SELECT usuarios.id, clientes.nombres FROM usuarios INNER JOIN clientes ON usuarios.id_cliente=clientes.id WHERE clientes.email LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $nombres = $row['nombres'];

            $token = solicitaPassword($user_id, $con);

            if($token !== null){
                require 'clases/mailer.php';
                $mailer = new Mailer();
                $url = SITE_URL . '/reset_password.php?id=' . $user_id .'&token=' . $token;
                $asunto = "Recuperar Password - Tienda-Carrito";
                $cuerpo = "Estimado $nombres: <br> Si has solicitado el cambio de tu contraseña, da click en el siguiente link <a href='$url'>$url</a>.";
                
                
                if($mailer->enviarEmail($email, $asunto, $cuerpo)){
                    echo "<p><b>Correo enviado</b></p>.";
                    echo "<p>Se le ha enviado su correo electrónico a la direccion $email para restablecer la contraseña</p>.";
                    echo "<p>Revise su span</p>";
                    exit;
                } 
            }
        } else {
            $errors[] = "No existe una cuenta asociada a esta dirección de correo";
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
</header>"
<main class="form-login m-auto pt-4">
    <h3>Recuperar contraseña</h3>
    
    <?php mostrarMensajes($errors); ?>
    <form action="recupera.php" method="post" class="row g-3" autocomplete="off">
      <div class="form-floating">
           <input class="form-control" type="email" name="email" id="email" placeholder="Correo electrónico" required>
           <label for="correo electrónico">Correo electronico</label>
      </div>
      
      <div class="d-grid gap-3 col-12">
           <button type="submit" class="btn btn-primary">Continuar</button>
      </div>

      <div class="col-12">
            ¿No tienes cuenta? <a href="registro.php">Registrate aqui</a>
      </div>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>