<?php

    session_start();

    require 'php/conexion_db.php';
    require 'php/funciones.php';

    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        $username = $_SESSION['email'];
    }

    if (isset($_SESSION['email']))
    {
        $managedStore = $_SESSION['managedStore'];
        $tienda = $managedStore;
        $idTienda = $managedStore;
        $sql    = "SELECT count(*) AS conteo FROM productos WHERE idTienda = '$idTienda' AND isActive = 1";
        $result = mysqli_query($conn, $sql);
        $row    = mysqli_fetch_assoc($result);
        $totalProductos = $row['conteo'];
    }

    $idTienda = $_SESSION['managedStore'];
    // getTotalVendidoMesActual($conn, $idTienda);
    // die;
    $hasActivePayment = validarPagoActivo($conn, $idTienda);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Estadísticas - mayoristapp.mx</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=22" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script src="js/funciones.js?id=11"></script>
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <header class="page-header page-header-dark bg-indigo pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon">
                                              <i data-feather="bar-chart-2"></i>
                                              <!-- <i data-feather="pie-chart"></i> -->
                                            </div>
                                            Reportes
                                        </h1>
                                        <div class="page-header-subtitle text-white">Obten reportes de venta de tu tienda <b class="fs-3 fw-700">vendy</b> </div>
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
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">

                        <div class="row">
                            <!-- <div class="col-xxl-4 col-xl-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body h-100 p-5">
                                        <div class="row align-items-center">
                                            <div class="col-xl-8 col-xxl-12">
                                                <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                                    <h1 class="text-primary">Welcome to SB Admin Pro!</h1>
                                                    <p class="text-gray-700 mb-0">Browse our fully designed UI toolkit! Browse our prebuilt app pages, components, and utilites, and be sure to look at our full documentation!</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="assets/img/illustrations/at-work.svg" style="max-width: 26rem" /></div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                        <!-- Example Colored Cards for Dashboard Demo-->
                        <div class="row">

                            <div class="col-lg-6 col-xl-3 mb-4">
                                <form action="procesa.php" method="post">
                                    <div class="card bg-success text-white h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="me-3">
                                                    <div class="text-white-75 small"></div>
                                                    <div class="text-lg fw-bold"> Ventas </div>
                                                </div>
                                                <i class="feather-xl text-white-50" data-feather="pie-chart"></i>
                                                <!-- <i class="fas fa-bullhorn"></i> -->
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between small">
                                            <!-- <a class="text-white stretched-link" href="#!">Configurar catálogo</a> -->
                                            <div class="input-group">
                                                <button type="button" name="button" class="btn btn-success border border-2 border-white rounded-3 btn-sm w-100 fs-6 fw-500 shadow-none" data-bs-toggle="modal" data-bs-target="#modalFiltrarReporteVentas">
                                                    <i class="me-2 feather-lg" data-feather="download-cloud"></i> Descargar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Tienda</div>
                                                <div class="text-lg fw-bold"> <?php //echo $totalProductos; ?> artículos</div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="calendar"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="mis-articulos.php">Administrar artículos</a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-danger text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Datos Pendientes</div>
                                                <div class="text-lg fw-bold">1</div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="message-circle"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="#!">Configurar datos</a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-warning text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Vendido este mes</div>
                                                <div class="text-lg fw-bold">
                                                    <?php
                                                        //getTotalVendidoMesActual($conn, $idTienda);
                                                    ?>
                                                    MXN
                                                </div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="#!"></a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Pedidos este mes</div>
                                                <div class="text-lg fw-bold">
                                                    <?php //getTotalPedidosMesActual($conn, $idTienda); ?>
                                                </div>
                                            </div>
                                            <i class="fas fa-2x fa-box-open text-white-50"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="#!"></a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div> -->

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
        <?php
            if (file_exists('src/modals.php'))
            {
              include 'src/modals.php';
            }
        ?>
        <script type="text/javascript">

            function validarFechas()
            {
                var fechaInicio = document.getElementById('fechaInicio').value;
                var fechaFin = document.getElementById('fechaFin').value;

                if (fechaInicio > fechaFin)
                {
                    Swal.fire({
                      icon: 'warning',
                      title: 'Error',
                      text: 'La fecha de fin debe ser igual o posterior a la fecha de inicio',
                      confirmButtonText: 'Entendido'
                    });
                    return false;
                }
                return true;
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>
        <?php
            if (file_exists('src/triggers.php'))
            {
              include 'src/triggers.php';
            }
        ?>
    </body>
</html>
