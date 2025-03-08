<?php include 'config/sesiones.php'; ?>
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
                    <h3 class="card-title">Ventas realizadas</h3>
                    <ul class="navbar-nav ms-auto">
                      <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                          <i class="bi bi-search"></i>
                        </a>
                     </li>
                   </ul>
                 </div>
                  <div class="card-body p-0">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nombre del producto</th>
                          <th>Precio</th>
                          <th>Fecha</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="align-middle">
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><span class="badge text-bg-danger"></span></td>
                        </tr>
                        <tr class="align-middle">
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><span class="badge text-bg-warning"></span></td>
                        </tr>
                        <tr class="align-middle">
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><span class="badge text-bg-primary"></span></td>
                        </tr>
                        <tr class="align-middle">
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><span class="badge text-bg-success"></span></td>
                        </tr>
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
</main>

<?php include 'footer.php'; ?>    