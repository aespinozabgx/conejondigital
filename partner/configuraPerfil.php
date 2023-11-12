<?php

  session_start();

  if (isset($_SESSION['email']))
  {
      $email = $_SESSION['email'];
  }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Perfil :: Mayoristapp</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="nav-fixed">

        <?php
        // Header
          if (file_exists('src/header.php'))
          {
            include 'src/header.php';
          }
        ?>

        <div id="layoutSidenav">
            <?php
              // Menú (sidenav)
              if (file_exists('src/sidenav.php'))
              {
                include 'src/sidenav.php';
              }
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-success pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            Perfil
                                        </h1>
                                        <div class="page-header-subtitle">Actualiza tus datos, direcciones y más, que tus clientes sepan de ti.</div>
                                    </div>
                                    <!-- <div class="col-12 col-xl-auto mt-4">
                                        <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                            <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                            <input class="form-control ps-0 pointer" id="litepickerRangePlugin" placeholder="Select date range..." />
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                        <div id="datosBancarios"></div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                        <div class="row">

                            <!-- Datos Bancarios Inicio   -->

                            <div id="redesSociales"></div>
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-wallet text-secondary"></i> Datos Bancarios</div>
                                    <div class="card-body">
                                        <form>
                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (first name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="">Clabe:</label>
                                                    <input class="form-control" id="" type="text" placeholder="Clabe bancaria" value="0123456789123456789" disabled />
                                                </div>
                                                <!-- Form Group (last name)-->
                                                <!-- <div class="col-md-6">
                                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                                    <input class="form-control" id="" type="text" placeholder="Númeor de tarjeta" value="4152313465659833" disabled />
                                                </div> -->
                                            </div>

                                            <!-- Submit button-->
                                            <!-- <button class="btn btn-primary" type="button">Save changes</button> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Datos Bancarios Fin -->


                            <!-- Redes Sociales Inicio -->

                            <div id="contacto"></div>
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white b-0"><i class="far fa-thumbs-up text-white-50"></i> Redes Sociales</div>
                                    <div class="card-body px-0">

                                        <!-- Payment method 1-->
                                        <form class="" action="" method="post">
                                              <div class="d-flex align-items-center justify-content-between px-4">
                                                <div class="d-flex col-md-6 align-items-center">
                                                    <i class="fab fa-facebook fa-2x text-primary"></i>
                                                      <div class="col-md-12 ms-4">
                                                        <input class="form-control" id="" type="text" placeholder="facebook.com/tupagina" value="" required />
                                                    </div>
                                                </div>
                                                <div class="ms-4 small">
                                                    <div class="badge text-dark ms-">
                                                        <button class="btn btn-outline-primary" type="submit"><i class="far fa-save me-2"></i> Guardar </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <hr />

                                        <!-- Payment method 1-->
                                        <form class="" action="" method="post">
                                            <div class="d-flex align-items-center justify-content-between px-4">
                                                <div class="d-flex col-md-6 align-items-center">
                                                    <i class="fab fa-instagram fa-2x text-danger"></i>
                                                    <div class="col-md-12 ms-4">
                                                        <input class="form-control" id="" type="text" placeholder="facebook.com/tupagina" value="" required />
                                                    </div>
                                                </div>
                                                <div class="ms-4 small">
                                                    <div class="badge text-dark ms-">
                                                        <button class="btn btn-outline-primary" type="submit"><i class="far fa-save me-2"></i> Guardar </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- Redes Sociales Fin -->


                            <!-- Otros medios de contacto Inicio   -->

                            <div id="sucursales"></div>
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header bg-green text-white b-0"><i class="far fa-comments text-white-50"></i> Medios de contacto</div>
                                    <div class="card-body">
                                        <form action="" method="post">

                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (first name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="">
                                                      Teléfono:
                                                    </label>
                                                    <input class="form-control" id="" type="text" placeholder="Teléfono 10 dígitos" value="" required />
                                                </div>

                                                <!-- Form Group (last name)-->
                                                <div class="col-md-6 mb-3">
                                                  <label class="small">Correo electrónico</label>
                                                  <input type="text" class="form-control" id="validationServer05" placeholder="" value="<?php echo $_SESSION['email']; ?>" disabled>
                                                </div>
                                            </div>

                                            <!-- Submit button-->
                                            <div class="text-end">
                                              <button class="btn btn-outline-success" type="submit"><i class="far fa-save me-2"></i> Guardar </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Otros medios de contacto Fin -->


                            <!-- Sucursales Inicio   -->
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header bg-yellow text-white b-0"><i class="fas fa-store text-white-50"></i> Sucursales</div>
                                    <div class="card-body">
                                        <form action="" method="post">

                                            <!-- Form Row-->
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (first name)-->
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="">
                                                      Calle:
                                                    </label>
                                                    <input class="form-control" id="" type="text" placeholder="Calle" value="" required />
                                                </div>

                                                <!-- Form Group (last name)-->
                                                <div class="col-md-4 mb-3">
                                                  <label class="small">Número</label>
                                                  <input type="text" class="form-control" id="validationServer05" placeholder="Número" required>
                                                </div>
                                            </div>
                                            <div class="row gx-3 mb-3">

                                                <!-- Form Group (last name)-->
                                                <div class="col-md-6 mb-3">
                                                  <label class="small">Colonia</label>
                                                  <input type="text" class="form-control" id="validationServer05" placeholder="Colonia" required>
                                                </div>
                                                <!-- Form Group (first name)-->
                                                <div class="col-md-4">
                                                    <label class="small mb-1" for="">
                                                      Código Postal:
                                                    </label>
                                                    <input class="form-control" id="" type="text" placeholder="Código Postal" value="" required />
                                                </div>

                                            </div>
                                            <div class="row gx-3 mb-3">
                                                <!-- Form Group (first name)-->
                                                <div class="col-md-4">
                                                    <label class="small mb-1" for="">
                                                      Estado:
                                                    </label>
                                                    <select class="form-control" name="" required>
                                                      <option value="">Seleccionar</option>
                                                      <option value="Aguascalientes">Aguascalientes</option>
                                                      <option value="Baja California">Baja California</option>
                                                      <option value="Baja California Sur">Baja California Sur</option>
                                                      <option value="Campeche">Campeche</option>
                                                      <option value="Chiapas">Chiapas</option>
                                                      <option value="Chihuahua">Chihuahua</option>
                                                      <option value="Coahuila">Coahuila</option>
                                                      <option value="Colima">Colima</option>
                                                      <option value="CDMX">CDMX</option>
                                                      <option value="Durango">Durango</option>
                                                      <option value="Estado de México">Estado de México</option>
                                                      <option value="Guanajuato">Guanajuato</option>
                                                      <option value="Guerrero">Guerrero</option>
                                                      <option value="Hidalgo">Hidalgo</option>
                                                      <option value="Jalisco">Jalisco</option>
                                                      <option value="Michoacán">Michoacán</option>
                                                      <option value="Morelos">Morelos</option>
                                                      <option value="Nayarit">Nayarit</option>
                                                      <option value="Nuevo León">Nuevo León</option>
                                                      <option value="Oaxaca">Oaxaca</option>
                                                      <option value="Puebla">Puebla</option>
                                                      <option value="Querétaro">Querétaro</option>
                                                      <option value="Quintana Roo">Quintana Roo</option>
                                                      <option value="San Luis Potosí">San Luis Potosí</option>
                                                      <option value="Sinaloa">Sinaloa</option>
                                                      <option value="Sonora">Sonora</option>
                                                      <option value="Tabasco">Tabasco</option>
                                                      <option value="Tamaulipas">Tamaulipas</option>
                                                      <option value="Tlaxcala">Tlaxcala</option>
                                                      <option value="Veracruz">Veracruz</option>
                                                      <option value="Yucatán">Yucatán</option>
                                                      <option value="Zacatecas">Zacatecas</option>
                                                    </select>

                                                </div>

                                                <!-- Form Group (last name)-->
                                                <div class="col-md-6 mb-3">
                                                  <label class="small">Municipio</label>
                                                  <input type="text" class="form-control" id="validationServer05" placeholder="Municipio" required>
                                                </div>
                                            </div>

                                            <!-- Submit button-->
                                            <div class="text-end">
                                              <button class="btn btn-outline-warning" type="submit"><i class="far fa-save me-2"></i> Guardar </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Sucursales Fin -->

                            <a href="#datosBancarios">DATOS B</a>
                        </div>

                    </div>
                </main>
                <?php
                  if (file_exists('src/footer.php'))
                  {
                    include 'src/footer.php';
                  }
                ?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>
    </body>
</html>
