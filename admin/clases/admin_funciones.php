<?php 

if(isset($_POST["btnLogin"])){
  
   include 'config/database.php';

   $email = ($_POST['email']);
   $password = ($_POST['password']);

   $sql = $pdo->prepare("SELECT * FROM usuario_admin WHERE email=:email AND password=:password");
   $sql->bindParam("email", $email, PDO::PARAM_STR);
   $sql->bindParam("password", $password, PDO::PARAM_STR);
   $sql->execute();

   $registro=$sql->fetch(PDO::FETCH_ASSOC);
   print_r($registro);
   
   $registros=$sql->rowCount();

   if($registros>=1){
     session_start();
     $_SESSION['usuario']=$registro;
     echo "Bienvenido....";
     header('Location: panel.php');
     exit;
   } else {
     echo "<b>Error:</b>No se encontraron registros";
   }
   echo "<br> Hay que validar el correo electrónico y la contraseña";
}

?>