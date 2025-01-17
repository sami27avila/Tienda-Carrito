<?php 

include 'config/config.php';
include 'config/database.php';
include 'clases/cliente_funciones.php';
$db = new Database();
$con = $db->conectar();

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

    if(count($errors) == 0){

    $id = registraCliente([$nombres, $apellidos, $email, $telefono, $dni], $con);

    if($id > 0){
        require 'clases/mailer.php';
        $mailer = new Mailer();
        $token = generarToken();
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);

        $idUsuario = registraUsuario([$usuario, $pass_hash, $token, $id], $con);
        if($idUsuario > 0){

          $url = SITE_URL . '/activa_cliente.php?id=' . $idUsuario .'&token=' . $token;
          //http://localhost:3000/Tienda-Carrito/activa_cliente.php?id=12&token=09d6951d1a28a7b45b8ef3feacf2cbc0
          $asunto = "Active su cuenta - Tienda-Carrito";
          $cuerpo = "Estimado $nombres: <br> Para continuar con el proceso de registro es indispensable de click en el siguiente link <a href='$url'>Active cuenta</a>";

          if($mailer->enviarEmail($email, $asunto, $cuerpo)){
              echo "Para finalizar el proceso de registro, por favor siga los pasos que le hemos enviado a la direccion de correo electronico $email";
              exit;
          } 
        } else {
           $errors[] = "Se ha producido un error al registrar los usuarios"; 
        }   
    } else {
        $errors[] = "Se ha producido un error al registrar los clientes";
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
<main id="main-page">
    <div class="container">
       <h2>Datos del cliente</h2>

       <?php mostrarMensajes($errors); ?>
       
       <form action="registro.php" method="post" class="row g-3" autocomplete="off">
           <div class="col-md-6">
              <label for="nombres"><span class="text-danger">*</span>Nombres</label>
              <input type="text" name="nombres" id="nombres" class="form-control" required>
           </div>
           <div class="col-md-6">
              <label for="apellidos"><span class="text-danger">*</span>Apellidos</label>
              <input type="text" name="apellidos" id="apellidos" class="form-control" required>
           </div>
           <div class="col-md-6">
              <label for="email"><span class="text-danger">*</span>Correo Electronico</label>
              <input type="email" name="email" id="email" class="form-control" required>
              <span id="validaEmail" class="text-danger"></span>
           </div>
           <div class="col-md-6">
              <label for="telefono"><span class="text-danger">*</span>Telefono</label>
              <input type="tel" name="telefono" id="telefono" class="form-control" required>
           </div>
           <div class="col-md-6">
              <label for="dni"><span class="text-danger">*</span>DNI</label>
              <input type="text" name="dni" id="dni" class="form-control" required>
           </div>
           <div class="col-md-6">
              <label for="usuario"><span class="text-danger">*</span>Usuario</label>
              <input type="text" name="usuario" id="usuario" class="form-control" required>
              <span id="validaUsuario" class="text-danger"></span>
           </div>
           <div class="col-md-6">
              <label for="password"><span class="text-danger">*</span>Contraseña</label>
              <input type="password" name="password" id="password" class="form-control" required>
           </div>
           <div class="col-md-6">
              <label for="repassword"><span class="text-danger">*</span>Repetir contraseña</label>
              <input type="password" name="repassword" id="repassword" class="form-control" required>
           </div>

           <i><b>Nota:</b> Son obligatorios los campos de asteriscos en cada uno de los datos</i>

           <div class="col-12">
              <button type="submit" class="btn btn-primary">Registrar</button>
           </div>

       </form>
    </div>       
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
  let txtUsuario = document.getElementById('usuario')
  txtUsuario.addEventListener('blur', function(){
      existeUsuario(txtUsuario.value)
  }, false)

  let txtEmail = document.getElementById('email')
  txtEmail.addEventListener('blur', function(){
      existeEmail(txtEmail.value)
  }, false)

  function existeEmail(email){
     let url = "clases/cliente_ajax.php";
     let formData = new FormData()
     formData.append("action", "existeEmail")
     formData.append("email", email)

     fetch(url, {
         method: 'POST',
         body: formData
     }).then(response => response.json())
     .then(data => {
        
        if(data.ok){
            document.getElementById('email').value = ''
            document.getElementById('validaEmail').innerHTML = 'El email no esta disponible'
        } else {
            document.getElementById('validaEmail').innerHTML = ''
        }
     })
  }
  
  function existeUsuario(usuario){
     let url = "clases/cliente_ajax.php";
     let formData = new FormData()
     formData.append("action", "existeUsuario")
     formData.append("usuario", usuario)

     fetch(url, {
         method: 'POST',
         body: formData
     }).then(response => response.json())
     .then(data => {
        
        if(data.ok){
            document.getElementById('usuario').value = ''
            document.getElementById('validaUsuario').innerHTML = 'El usuario no esta disponible'
        } else {
            document.getElementById('validaUsuario').innerHTML = ''
        }
     })
  }


</script>

</body>
</html>