<?php 

include 'config/sesiones.php';
include 'config/database.php'; 


$sql=$pdo->prepare("SELECT * FROM productos_admin");
$sql->execute();
$productos_admin=$sql->fetchAll(PDO::FETCH_ASSOC);
    
   

?>

<?php include 'header.php'; ?>

<?php include 'sidebar.php'; ?>

      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-md-6">
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Productos disponibles</h3>  
                 </div>
                  <div class="card-body p-0">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th colspan="2">ID</th>
                          <th colspan="2">Nombre del producto</th>
                          <th colspan="2">Descripción</th>
                          <th colspan="2">Precio</th>
                          <th colspan="2">Fecha</th>
                        </tr>
                      </thead><div class="zx"></div>
                      <tbody>
                      <?php if($productos_admin == null){
                      echo '<tr><td class="text-center"><b>No hay productos</b></td></tr>';
                    
                    }else{
                      foreach($productos_admin as $producto){
                        $id = $producto['id'];
                        $nombre = $producto['nombre'];
                        $descripción = $producto['descripción'];
                        $precio = $producto['precio'];
                        $fecha = $producto['fecha'];
                        
                      ?>
                        <tr class="align-middle">
                          <td><?php echo $id; ?></td>
                          <td colspan="3"><?php echo $nombre; ?></td>
                          <td colspan="3"><?php echo $descripción; ?></td>
                          <td colspan="3"><?php echo $precio; ?></td>
                          <td colspan="3"><?php echo $fecha; ?></td>
                        </tr>
                     <?php } ?>
                     <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
    <div class="app-content">
          <div class="container-fluid">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-title">Formulario</div>
                  <form>
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email "aria-describedby="emailHelp" placeholder="Correo Electrónico" required>
                      </div>
                      <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </main>

<?php include 'footer.php'; ?>    