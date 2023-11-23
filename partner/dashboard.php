<?php
    session_start();

    // Define la constante de ruta base
    // define('BASE_PATH', dirname(__DIR__) . '/app');

    // // Usa la constante para incluir archivos
    // require BASE_PATH . '/php/conexion.php';
    // require BASE_PATH . '/php/funciones.php';


    require '../app/php/conexion.php';
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
        
        if (isset($_SESSION['managedStore']))
        {
            $idTienda = $_SESSION['managedStore'];
        }

        $sql    = "SELECT count(*) AS conteo FROM productos WHERE idTienda = '$idTienda' AND isActive = 1";
        $result = mysqli_query($conn, $sql);
        $row    = mysqli_fetch_assoc($result);
        $totalProductos = $row['conteo'];
        $idUsuario = $_SESSION['email'];
    }

    if (!isset($_SESSION['managedStore'])) 
    {
        exit(header('Location: ../app/index.php?msg=redirectedNotFoundStore'));
    }

    // Obtener la fecha de hoy en español
    setlocale(LC_TIME, 'es_ES.UTF-8');
    setlocale(LC_TIME, "spanish");

    $fechaInicio = date('Y-m-d');
    $fechaFin = date('Y-m-d');

    if (isset($_GET['rangoFecha']))
    {
        // echo "GET";
        $fechas = $_GET['rangoFecha'];
        $fechas_array = explode(";", $fechas);

        // Validate the input dates
        $fechaInicio = date('Y-m-d', strtotime($fechas_array[0]));
        $fechaFin    = date('Y-m-d', strtotime($fechas_array[1]));

        if (!$fechaInicio || !$fechaFin || $fechaInicio > $fechaFin)
        {
            // echo "Default";
            // Fechas inválidas, establecer fechas default
            $fechaInicio = date('Y-m-d');
            $fechaFin = date('Y-m-d');
        }
    }

    // echo "<br><br>Resultado: " . $fechaInicio . ", " . $fechaFin . "<br><br>";
    $ventas_ganancias = getVentasGananciasTienda($conn, $idTienda, $fechaInicio, $fechaFin);
    $total_ingresos   = getIngresosTienda($conn, $idTienda, $fechaInicio, $fechaFin);
    $total_egresos    = getEgresosTienda($conn, $idTienda, $fechaInicio, $fechaFin);

    // Datos para gráfica por mes
    $ventaGananciaPorMesTienda = getVentaGananciaPorMesTienda($conn, $idTienda);
    // echo "<pre>";
    // print_r($ventaGananciaPorMesTienda);
    // die;

    $ventasMetodoDePagoTienda = getVentasMetodoDePagoTienda($conn, $idTienda, $fechaInicio, $fechaFin);
    // echo "<pre>";
    // print_r($ventasMetodoDePagoTienda);
    // die;

    $pedidosAbiertos = obtenerPedidosAbiertos($conn, $idTienda, NULL, NULL);
    // echo "<pre>";
    // print_r($pedidosAbiertos);
    // die;

    $estatusCaja = isTurnoCajaActivo($conn, $idTienda, $idUsuario);
    // echo "<pre>";
    // var_dump($estatusCaja);
    // die;

    $hasActivePayment = validarPagoActivo($conn, $idTienda); 

    // echo "<pre>";
    // var_dump( $idTienda);
    // die; 
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <!-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" /> -->
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=3328" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>        
        <script src="js/qrcode.js"></script>

        <style type="text/css">
            input[type=checkbox]
            {
                -ms-transform: scale(1.3); /* IE */
                -moz-transform: scale(1.3); /* FF */
                -webkit-transform: scale(1.3); /* Safari and Chrome */
                -o-transform: scale(1.3); /* Opera */
                transform: scale(1.3);
                padding: 10px;
            }
            
            /* Estilo para la barra de licencia inactiva */
            .license-bar 
            {
                background-color: #FF0000; /* Color de fondo rojo (puedes cambiarlo) */
                color: #FFFFFF; /* Color del texto blanco (puedes cambiarlo) */
                padding: 10px; /* Espaciado interno para el contenido */
                text-align: center; /* Alineación del texto al centro */
                font-weight: bold; /* Estilo de fuente en negrita */
                width: 100%; /* Ancho al 100% */
            }

            /* Estilo para la barra de navegación */
            .topnav {
                /* Estilos para tu barra de navegación actual */
            }
        
        </style>
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
              if (file_exists('src/sideMenu.php'))
              {
                include 'src/sideMenu.php';
              }
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-indigo pb-9">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                            
                                        <div>

                                            <i data-feather="home" class="feather-xl me-1 mb-2 text-white-50"></i>
                                            <a class="display-6 text-white fw-200 sombra-titulos-vendy text-decoration-none">
                                                <?php echo !empty($_SESSION['nombreTienda']) ? ucwords(strtolower($_SESSION['managedStore'])) : 'Dashboard'; ?>
                                            </a>

                                            <?php
                                            
                                                if (isset($_SESSION['rol']) && $_SESSION['rol'] == "su") 
                                                { 
                                                    $tiendasRegistradas = getTiendasRegistradas($conn);
                                                    
                                                    if ($tiendasRegistradas !== false) 
                                                    {
                                                        ?>
                                                        <form action="../app/procesa.php" method="post" class="mt-3">
                                                            <div class="form-group d-flex align-items-center">
                                                                <label for="tiendaSelect" class="me-2">Tienda: </label>
                                                                <select class="form-select me-1" name="tiendaSelect" id="tiendaSelect" required>
                                                                    <option value="">Seleccionar</option>
                                                                    <?php foreach ($tiendasRegistradas as $tienda) : ?>
                                                                        <option value="<?= htmlspecialchars($tienda['idTienda']) ?>"><?= htmlspecialchars($tienda['nombreTienda']) ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <button class="btn btn-outline-primary border-white border-2 text-white" name="btnSUCambiarTienda" type="submit">Enviar</button>
                                                            </div>
                                                        </form>
                                                        <?php
                                                    }
                                                }
                                                elseif(1==2)
                                                {
                                                    ?>
                                                    <a class="btn rounded-pill btn-outline-white" target="_blank" href="https://conejondigital.com/<?php echo $idTienda; ?>">
                                                        <i data-feather="link-2" class=""></i>
                                                        <span class="d-none d-sm-inline ms-1">conejondigital.com/<?php echo $idTienda; ?></span>
                                                    </a>
                                                    <?php
                                                }
                                            ?>
                                            

                                        </div>
                                        <div class="page-header-subtitle">
                                            <div class="">
                                                <span class="fw-500 text-white-75 small">
                                                    Resumen de tu tienda.
                                                    <?php
                                                    //     setlocale(LC_TIME, "spanish");
                                                    //     setlocale(LC_TIME, 'es_ES.UTF-8');
                                                    //     //echo strftime("%d %bk %Y", strtotime($fechaInicio)) . " <span class='text-white'>al</span> " . strftime("%d/%m/%Y", strtotime($fechaFin));
                                                    //     echo date("j M, Y", strtotime($fechaInicio)) . " al " . date("j M, Y", strtotime($fechaFin));
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-auto mt-4">
                                        <form class="" id="formularioFechaFiltrado" action="index.html" method="post">
                                            <div class="input-group input-group-joined border-0">
                                                <span class="input-group-text bg-transparent"><i class="text-white" data-feather="calendar"></i></span>
                                                <div class="form-control align-bottom pt-3 ps-0 fs-3 fw-600 bg-transparent text-white pointer"><?php echo date("j M, Y"); ?></div>
                                            </div>
                                        </form>
                                    </div>
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

                            <!-- <div class="col-xxl-4 col-xl-6 mb-4">
                                <div class="card card-header-actions h-100">
                                    <div class="card-header">
                                        Recent Activity
                                        <div class="dropdown no-caret">
                                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                                <h6 class="dropdown-header">Filter Activity:</h6>
                                                <a class="dropdown-item" href="#!"><span class="badge bg-green-soft text-green my-1">Commerce</span></a>
                                                <a class="dropdown-item" href="#!"><span class="badge bg-blue-soft text-blue my-1">Reporting</span></a>
                                                <a class="dropdown-item" href="#!"><span class="badge bg-yellow-soft text-yellow my-1">Server</span></a>
                                                <a class="dropdown-item" href="#!"><span class="badge bg-purple-soft text-purple my-1">Users</span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="timeline timeline-xs">

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <div class="timeline-item-marker-text">27 min</div>
                                                    <div class="timeline-item-marker-indicator bg-green"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    New order placed!
                                                    <a class="fw-bold text-dark" href="#!">Order #2912</a>
                                                    has been successfully placed.
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <div class="timeline-item-marker-text">58 min</div>
                                                    <div class="timeline-item-marker-indicator bg-blue"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    Your
                                                    <a class="fw-bold text-dark" href="#!">weekly report</a>
                                                    has been generated and is ready to view.
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <div class="timeline-item-marker-text">2 hrs</div>
                                                    <div class="timeline-item-marker-indicator bg-purple"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    New user
                                                    <a class="fw-bold text-dark" href="#!">Valerie Luna</a>
                                                    has registered
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <div class="timeline-item-marker-text">1 day</div>
                                                    <div class="timeline-item-marker-indicator bg-yellow"></div>
                                                </div>
                                                <div class="timeline-item-content">Server activity monitor alert</div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <div class="timeline-item-marker-text">1 day</div>
                                                    <div class="timeline-item-marker-indicator bg-green"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    New order placed!
                                                    <a class="fw-bold text-dark" href="#!">Order #2911</a>
                                                    has been successfully placed.
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <div class="timeline-item-marker-text">1 day</div>
                                                    <div class="timeline-item-marker-indicator bg-purple"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    Details for
                                                    <a class="fw-bold text-dark" href="#!">Marketing and Planning Meeting</a>
                                                    have been updated.
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <div class="timeline-item-marker-text">2 days</div>
                                                    <div class="timeline-item-marker-indicator bg-green"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    New order placed!
                                                    <a class="fw-bold text-dark" href="#!">Order #2910</a>
                                                    has been successfully placed.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-xxl-4 col-xl-6 mb-4">
                                <div class="card card-header-actions h-100">
                                    <div class="card-header">
                                        Progress Tracker
                                        <div class="dropdown no-caret">
                                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#!">
                                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="list"></i></div>
                                                    Manage Tasks
                                                </a>
                                                <a class="dropdown-item" href="#!">
                                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="plus-circle"></i></div>
                                                    Add New Task
                                                </a>
                                                <a class="dropdown-item" href="#!">
                                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="minus-circle"></i></div>
                                                    Delete Tasks
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="small">
                                            Server Migration
                                            <span class="float-end fw-bold">20%</span>
                                        </h4>
                                        <div class="progress mb-4"><div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div></div>
                                        <h4 class="small">
                                            Sales Tracking
                                            <span class="float-end fw-bold">40%</span>
                                        </h4>
                                        <div class="progress mb-4"><div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div></div>
                                        <h4 class="small">
                                            Customer Database
                                            <span class="float-end fw-bold">60%</span>
                                        </h4>
                                        <div class="progress mb-4"><div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div></div>
                                        <h4 class="small">
                                            Payout Details
                                            <span class="float-end fw-bold">80%</span>
                                        </h4>
                                        <div class="progress mb-4"><div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div></div>
                                        <h4 class="small">
                                            Account Setup
                                            <span class="float-end fw-bold">Complete!</span>
                                        </h4>
                                        <div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>
                                    </div>
                                    <div class="card-footer position-relative">
                                        <div class="d-flex align-items-center justify-content-between small text-body">
                                            <a class="stretched-link text-body" href="#!">Visit Task Center</a>
                                            <i class="fas fa-angle-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        </div>

                        <div class="row">

                            <div class="col-lg-6 col-xl-3 mb-4">

                                <div class="card bg-success text-white h-100 gradient-red ">
                                    <div class="card-body ">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Comparte tu</div>
                                                <div class="fs-2 fw-500">
                                                    Tienda
                                                </div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="share"></i>
                                            <!-- <i class="fas fa-bullhorn"></i> -->
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <!-- <a class="text-white stretched-link" href="#!">Configurar catálogo</a> -->
                                        <div class="input-group ">
                                            <!-- <span class="input-group-text bg-success text-white" id="basic-addon1">
                                                <i class="fas fa-copy"></i>
                                            </span> -->
                                            <?php
                                            if (empty($_SESSION['managedStore']))
                                            {
                                                ?>
                                                <a class="btn btn-outline-white w-100 fs-4" href="setup_tienda.php">
                                                    <i class="fas fa-bullhorn me-2"></i>
                                                    Publicar mi tienda
                                                </a>
                                                <?php
                                            }
                                            else {
                                              ?>
                                              <button class="btn btn-outline-white w-100 fs-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalCompartirTienda">
                                                  Compartir
                                                  <i class="ms-1" data-feather="share-2"></i>
                                              </button>
                                              <?php
                                            }
                                            ?>

                                            <!-- <input type="text" style="cursor: pointer;" onClick="javascript: copiarPortapapeles();" id="myInput" class="form-control form-control-sm bg-success text-white" name="urlPerfil" value="https://mayoristapp.mx/perfil.php?tienda=<?php echo $username; ?>" readonly> -->
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-pattern-pdv text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">                                                
                                                <div class="text-white-75 small">Punto De Venta</div>
                                                <div class="display-6 sombra-titulos-vendy fw-500">PDV</div>
                                            </div>
                                            <!-- <i class="feather-xl text-white-50" data-feather="calendar"></i> -->
                                            <i class="fas fa-cash-register text-white-50 display-6 me-2 mt-2"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        
                                        <?php                                        
                                            //var_dump($hasActivePayment['existePagoActivo']);                                            
                                            if (isset($hasActivePayment) && $hasActivePayment['existePagoActivo'] == true)
                                            {                                                                                                
                                                ?> 
                                                <a class="text-white stretched-link" href="pos.php">
                                                    Ir ahora
                                                </a>
                                                <?php
                                            }
                                            else
                                            {
                                                
                                                ?>                                                
                                                <a style="cursor: pointer;" class="text-white stretched-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">
                                                    Ir ahora
                                                </a> 
                                                <?php
                                            }
                                        ?>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                             

                            <!-- <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-danger text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Datos Pendientes</div>
                                                <div class="display-6 fw-500">1</div>
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

                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-yellow text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Pedidos abiertos</div>
                                                <div class="display-6 fw-500">
                                                    <?php
                                                        echo $pedidosAbiertos['conteo'];
                                                    ?>
                                                </div>
                                            </div>
                                            <i class="fas fa-3x fa-box-open text-white-50"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <?php
                                            if (isset($hasActivePayment['existePagoActivo']) && ($hasActivePayment['existePagoActivo'] == true))
                                            {
                                                ?>
                                                <a class="text-white stretched-link" href="mis-ventas.php">Ver pedidos</a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a style="cursor: pointer;" class="text-white stretched-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">Ver pedidos</a>
                                                <?php
                                            }
                                        ?>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Pedidos del mes</div>
                                                <div class="display-6 fw-500">
                                                    <?php getTotalPedidosMesActual($conn, $idTienda); ?>
                                                </div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="bar-chart-2"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <?php
                                            if (isset($hasActivePayment['existePagoActivo']) && $hasActivePayment['existePagoActivo'] == true)
                                            {
                                                ?>
                                                <a class="text-white stretched-link" href="estadisticas.php">Ver Estadísticas</a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a style="cursor: pointer;" class="text-white stretched-link" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">Ver Estadísticas</a>
                                                <?php
                                            }
                                        ?>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-md-12 mb-4">
                                <div class="card mb-2">
                                    <div class="card-header">Datos del año en curso</div>
                                    <div class="card-body bg-pattern-white-75">
                                        <?php
                                        if (!isset($ventaGananciaPorMesTienda) || empty($ventaGananciaPorMesTienda))
                                        {
                                            ?>
                                            <div class="d-flex text-center">
                                                Datos insuficientes para realizar el cálculo.
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="chart-area">
                                                <canvas id="myBarChart" class="" width="100%" height="30"></canvas>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Example Charts for Dashboard Demo-->
                        <div class="row">
                            <!-- Inicio Caja -->
                            <div class="col-xl-6 mb-4">
                                <div class="card card-header-actions">

                                    <div class="card-header" id="moduloCaja">
                                        <span id="caja" class="fs-2 fw-600 text-blue">
                                            <i class="fas fa-cash-register me-2"></i>Caja
                                        </span>
                                        <!-- <div class="dropdown no-caret">
                                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                                                <a class="dropdown-item" href="#!">Last 12 Months</a>
                                                <a class="dropdown-item" href="#!">Last 30 Days</a>
                                                <a class="dropdown-item" href="#!">Last 7 Days</a>
                                                <a class="dropdown-item" href="#!">This Month</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#!">Custom Range</a>
                                            </div>
                                        </div> -->
                                        <div class="">
                                            <?php

                                            $response = isTurnoCajaActivo($conn, $idTienda, $idUsuario);

                                            if ($response['estatus'])
                                            {
                                                if ($response['response'] == 'turnoActivoUsuarioActual' || $response['response'] == 'turnoActivoNotUsuarioActual')
                                                {
                                                    // El último turno todavía está abierto
                                                    // Mostrar mensaje y fecha de apertura
                                                    // echo "El último turno todavía está abierto desde " . $response['fechaApertura'] . ".";
                                                    ?>
                                                    <a class="btn btn-primary rounded-pill" class="text-decoration-none" href="pos.php">
                                                        <!-- <i class="" data-feather="unlock"></i>  -->
                                                        PDV
                                                        <?php //echo date("d/m/Y H:i", strtotime($response['fechaApertura']));  ?>
                                                    </a>

                                                    <a class="btn btn-outline-danger rounded-pill" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalCierreTurnoCaja">
                                                        <i class="" data-feather="unlock"></i>
                                                        <?php //echo date("d/m/Y H:i", strtotime($response['fechaApertura']));  ?>
                                                    </a>
                                                    <?php
                                                } else
                                                {
                                                    // El último turno está cerrado
                                                    // Mostrar mensaje para abrir uno nuevo
                                                    ?>
                                                    <a class="btn btn-danger rounded-pill btn-sm" href="mis-ventas.php" class="text-decoration-none">
                                                        Abrir turno
                                                    </a>
                                                    <?php
                                                }
                                            } else
                                            {
                                                // No hay entradas en la tabla para esta tienda y usuario
                                                // Mostrar mensaje para abrir un nuevo turno
                                                ?>
                                                <!-- <a class="btn btn-danger rounded-pill btn-sm" href="mis-ventas.php" class="text-decoration-none">
                                                    Abrir turno3
                                                </a> -->
                                                <?php
                                            }


                                            ?>
                                        </div>
                                    </div>
                                    <?php

                                    if ($response['estatus']  == true)
                                    {
                                        $fechaHoraInicioTurno = date("Y-m-d H:i:s", strtotime($response['fechaApertura']));
                                        $fechaActual          = date("Y-m-d H:i:s");
                                        $ventasEfectivoTurno  = consultarPedidosEfectivoTurno($conn, $idTienda, $fechaHoraInicioTurno, $fechaActual);

                                        // echo "3328";
                                        // echo "<pre>";
                                        // var_dump($ventasEfectivoTurno);

                                        $ingresosEgresos      = obtener_ingresos_y_egresos_por_tienda($conn, $idTienda, $fechaHoraInicioTurno, $fechaActual);

                                        ?>
                                        <div class="list-group list-group-flush">

                                            <div class="list-group-item fs-6 fw-400 d-flex align-items-center" href="#!">
                                                <div class="col fw-300 text-gray-600 fs-2" style="width: 50%;">
                                                    <!-- <i class="rounded-pill opacity-0 text-white bg-primary me-2 feather-lg" data-feather="plus"></i> -->
                                                    Apertura de caja
                                                </div>
                                                <div class="col text-end" style="width: 50%;">
                                                    <div class="rounded-pill fs-4 fw-300 text-decoration-none">
                                                        <?php echo "$ " . number_format($response['efectivoInicial'], 2); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="list-group-item fs-6 fw-400 d-flex" href="#!">
                                                <div class="col fw-300 text-gray-600 fs-2" style="width: 50%;">
                                                    <i class="rounded-pill text-dark-75 feather-lg" data-feather="plus"></i>
                                                    Ventas en efectivo
                                                </div>
                                                <div class="col text-end" style="width: 50%;">
                                                    <div class="fs-4 fw-300 text-decoration-none">
                                                        <?php echo "$ " . number_format($ventasEfectivoTurno, 2); ?>
                                                    </div>
                                                </div>
                                            </a>

                                            <a class="list-group-item fs-6 fw-400 d-flex align-items-center" href="#!">
                                                <div class="col fw-300 text-gray-600 fs-2" style="width: 50%;">
                                                    <i class="rounded-pill text-dark-75 feather-lg" data-feather="plus"></i>
                                                    Ingresos en efectivo
                                                </div>
                                                <div class="col text-end" style="width: 50%;">
                                                    <div class="fs-4 fw-300 text-decoration-none">
                                                        <?php echo "$ " . number_format($ingresosEgresos['ingresos'], 2); ?>
                                                        <button class="btn btn-outline-success btn-sm rounded-pill btn-icon border border-2 border-success mb-2 shadow-none ms-1" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistrarIngreso">
                                                            <i class="feather-lg" data-feather="plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </a>

                                            <a class="list-group-item fs-6 fw-400 d-flex align-items-center" href="#!">
                                                <div class="col fw-300 text-gray-600 fs-2" style="width: 50%;">
                                                    <i class="rounded-pill text-dark-75 feather-lg" data-feather="minus"></i>
                                                    Egresos en efectivo
                                                </div>
                                                <div class="col text-end" style="width: 50%;">
                                                    <div class="fs-4 fw-300 text-decoration-none">
                                                        <?php echo "$ " . number_format($ingresosEgresos['egresos'], 2); ?>
                                                        <button class="btn btn-outline-red btn-sm rounded-pill btn-icon border border-2 border-red mb-2 shadow-none ms-1" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistrarEgreso">
                                                            <i class="feather-lg" data-feather="minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                        <div class="card-footer bg-success d-flex fs-4 text-white">
                                            <div class="col fw-600" style="width: 50%;">
                                                Total en caja:
                                            </div>
                                            <div class="col text-end" style="width: 50%; cursor: pointer;">
                                                <div class="fw-300 ms-1 pb-1 fw-600 border-bottom border-2 fs-2">
                                                    $
                                                    <?php
                                                        $aperturaCaja = $response['efectivoInicial'];
                                                        $totalCajaEfectivo = ($ventasEfectivoTurno + $ingresosEgresos['ingresos']) - ($ingresosEgresos['egresos'] - $aperturaCaja);
                                                        echo number_format($totalCajaEfectivo, 2);
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="list-group-item fs-4 fw-300 text-center p-4 bg-pattern-white-75" href="#!">

                                            <div class="text-center mb-2">
                                                Aún no hay movimientos
                                            </div>



                                            <?php
                                                if (isset($hasActivePayment['existePagoActivo']) && $hasActivePayment['existePagoActivo'] == true)
                                                {
                                                    ?>
                                                    <a class="btn btn-danger rounded-pill btn-sm text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalIniciarTurnoCaja">
                                                        Iniciar turno
                                                    </a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <a style="cursor: pointer;" class="btn btn-outline-primary rounded-pill btn-sm text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalSeccionDePago">Iniciar turno</a>
                                                    <?php
                                                }
                                            ?>

                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- Fin Caja -->

                            <!-- Inicio Ventas por metodo de pago -->
                            <div class="col-xl-6 mb-4">
                              <div class="card card-header-actions">

                                  <div class="card-header">
                                      <span class="fs-2 fw-600 text-yellow">
                                          <i class="fas fa-dollar-sign me-1"></i>
                                          Ventas del día
                                          <!-- <span class="small fw-300">Agrupado por método de pago</span> -->
                                      </span>
                                      <div class="dropdown no-caret">
                                          <button class="btn btn-icon shadow-none btn-sm" id="" type="button" onclick="mostrarInfoIngresosDelDia()">
                                              <i class="text-gray-500 feather-lg" data-feather="info"></i>
                                          </button>

                                          <script>
                                          function mostrarInfoIngresosDelDia()
                                          {
                                              swal.fire({
                                                  title: "Ventas del día",
                                                  text: "Se consideran todas las ventas del día de hoy (<?php echo date('d/m/Y'); ?>) de todos los métodos de pago disponibles.",
                                                  icon: "info",
                                              });
                                          }
                                          </script>

                                          <!-- <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="text-gray-500" data-feather="info"></i>
                                          </button> -->
                                          <!-- <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                                              <a class="dropdown-item" href="#!">Last 12 Months</a>
                                              <a class="dropdown-item" href="#!">Last 30 Days</a>
                                              <a class="dropdown-item" href="#!">Last 7 Days</a>
                                              <a class="dropdown-item" href="#!">This Month</a>
                                              <div class="dropdown-divider"></div>
                                              <a class="dropdown-item" href="#!">Custom Range</a>
                                          </div> -->
                                      </div>
                                  </div>
                                  <div class="card-body bg-pattern-white-75">
                                      <?php
                                      // var_dump($ventasMetodoDePagoTienda);
                                      if ($ventasMetodoDePagoTienda !== false)
                                      {
                                          ?>
                                          <div class="table-responsive h-100">
                                              <table id="datatablesSimple" class="table table-bordered table-hover">
                                                  <thead>
                                                      <tr class="text-success">
                                                          <th class="fw-400"># Pedido</th>
                                                          <th class="fw-400">Hora</th>
                                                          <th class="fw-400">Total</th>
                                                          <th class="fw-400">Pago</th>
                                                      </tr>
                                                  </thead>
                                                  <tfoot>
                                                      <tr class="text-success">
                                                          <th class="fw-400"># Pedido</th>
                                                          <th class="fw-400">Hora</th>
                                                          <th class="fw-400">Total</th>
                                                          <th class="fw-400">Pago</th>
                                                      </tr>
                                                  </tfoot>
                                                  <tbody>
                                                      <?php
                                                      foreach ($ventasMetodoDePagoTienda as $ventasMP)
                                                      {
                                                          if (1)
                                                          // if (isset($ventasMP['fechaPago']) && !empty($ventasMP['fechaPago']))  ** ESTA LINEA OCULTA LOS PEDIDOS NO PAGADOS
                                                          {
                                                              $total_pedidosPHP     = $ventasMP['total_pedidos'];
                                                              $subtotal_pedidosPHP  = $ventasMP['subtotal_pedidos'];
                                                              $nombre_metodoPagoPHP = $ventasMP['nombre_metodoPago'];
                                                              $icono                = $ventasMP['icono'];
                                                              $fechaPedido          = date("H:i", strtotime($ventasMP['fechaPedido']));
                                                              $fechaPago            =! empty($ventasMP['fechaPago']) ? '<i class="feather-lg text-success" data-feather="check-circle"></i>' : '<i class="feather-lg text-gray-400" data-feather="minus-circle"></i>';
                                                              ?>
                                                                  <tr style="cursor: pointer;" onclick="window.location='detalleVenta.php?id=<?php echo $ventasMP['idPedido']; ?>';">
                                                                      <td class="fw-300"><?php echo $ventasMP['idPedido']; ?></td>
                                                                      <td><?php echo $fechaPedido; ?> hrs</td>
                                                                      <td class="fw-500 text-dark"> $ <?php echo number_format($total_pedidosPHP, 2); ?></td>
                                                                      <td class="small text-center"><?php echo $fechaPago; ?></td>
                                                                  </tr>
                                                              <?php
                                                          }
                                                      }
                                                      ?>
                                                  </tbody>

                                              </table>
                                          </div>
                                          <?php

                                      }
                                      else
                                      {
                                        ?>
                                            <!-- <div class="fs-4 fw-300 text-center p-4" href="#!">
                                                Aún no hay movimientos
                                            </div> -->
                                            <div class="fs-4 fw-300 text-center p-1" href="#!">

                                                <div class="text-center mb-2">
                                                    Aún no hay movimientos
                                                </div>
                                            </div>
                                        <?php
                                      }
                                      ?>
                                  </div>

                                    <!-- Footer ventas del día -->
                                    <div class="card-footer bg-yellow d-flex fs-4 text-white">
                                        <a class="col fw-600 text-center text-white" style="" href="mis-ventas.php">
                                            Ver listado completo <i class="feather-lg" data-feather="arrow-right"></i>
                                        </a>
                                    </div>
                                    <div id="qrcode" class="d-none"></div>
                              </div>
                          </div>
                            <!-- Fin Ventas por metodo de pago -->
                        </div>
                    </div>

                </main>

                <script src="js/funciones.js?id=2888"></script>
                <?php
                    if (file_exists('src/modals.php'))
                    {
                        require 'src/modals.php';
                    }

                    if (file_exists('src/footer.php'))
                    {
                        require 'src/footer.php';
                    }
                ?>

            </div>
        </div>

        <script src="js/numero-a-letras.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.umd.js" integrity="sha512-vCUbejtS+HcWYtDHRF2T5B0BKwVG/CLeuew5uT2AiX4SJ2Wff52+kfgONvtdATqkqQMC9Ye5K+Td0OTaz+P7cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js" integrity="sha512-v3ygConQmvH0QehvQa6gSvTE2VdBZ6wkLOlmK7Mcy2mZ0ZF9saNbbk19QeaoTHdWIEiTlWmrwAL4hS8ElnGFbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
        <!-- <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script> -->

        <script type="text/javascript">



            // Obtener los datos de ventas y ganancias desde PHP
            <?php
                // Ganancias y ventas
                $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
                foreach ($ventaGananciaPorMesTienda as $ganancia)
                {
                    $gananciasPHP[] = $ganancia['total_Ganancia'];
                    $ventasPHP[]    = $ganancia['total_Venta'];
                    $mesesPHP[]     = $meses[$ganancia['mes']];
                }
            ?>
            //console.log(<?php //echo json_encode($mesesPHP); ?>);

            // Configuración de la gráfica de barras
            var config =
            {
              type: 'bar',
              data: {
                  labels: <?php echo !empty($mesesPHP) ? json_encode($mesesPHP) : json_encode(""); ?>,
                  datasets: [{
                    label: 'Ventas',
                    backgroundColor: 'rgba(255, 0, 0, 0.5)',
                    borderColor: 'rgba(255, 0, 0, 1)',
                    borderWidth: 2,
                    data: <?php echo !empty($ventasPHP) ? json_encode($ventasPHP) : json_encode("0"); ?>
                  },
                  {
                      label: 'Ganancias',
                      backgroundColor: 'rgba(96, 75, 245, 0.7)',
                      borderColor: 'rgba(92, 72, 238, 1)',
                      borderWidth: 2,
                      data: <?php echo !empty($gananciasPHP) ? json_encode($gananciasPHP) : json_encode(""); ?>
                  }]
              },
              options: {
                  maintainAspectRatio: false,
                  responsive: true,
                  title: {
                      display: true,
                      text: 'Ventas y Ganancias del año'
                },
                scales: {
                }
              }
            };

            // Crear la gráfica de barras
            // var ctx = document.getElementById('myBarChart').getContext('2d');
            // var myBarChart = new Chart(ctx, config);


            <?php
                // getVentasMetodoDePagoTienda
            ?>

            // Inicio Gráfica Reelevancia
            // Generar datos aleatorios de productos y ventas
            // var productos = ['Producto 1', 'Producto 2', 'Producto 3', 'Producto 4', 'Producto 5'];
            // var ventas = [];


            // Configuración de la gráfica de doughnut
            // var configProductos =
            // {
            //   type: 'pie',
            //   data: {
            //       labels: <?php //echo json_encode($ventasMetodoDePagoTienda); ?>,
            //       datasets: [{
            //         label: 'Total',
            //         backgroundColor: ['rgba(255, 0, 0, 0.5)', 'rgba(96, 75, 245, 0.7)', 'rgba(0, 128, 0, 0.5)', 'rgba(255, 165, 0, 0.5)', 'rgba(139, 69, 19, 0.7)'],
            //         borderColor: 'rgba(255, 255, 255, 1)',
            //         borderWidth: 2,
            //         data: <?php //echo json_encode($ventasMetodoDePagoTienda); ?>
            //       }]
            //   },
            //   options: {
            //       maintainAspectRatio: false,
            //       responsive: true,
            //       title: {
            //           display: true,
            //           text: 'Productos más vendidos - Total de ventas: '
            //     },
            //     legend: {
            //       display: true,
            //       position: 'bottom'
            //     }
            //   }
            // };

            // Crear la gráfica de doughnut
            // var ctxProductos = document.getElementById('chartProductos').getContext('2d');
            // var chartProductos = new Chart(ctxProductos, configProductos);
            // Fin Gráfica Reelevancia

        </script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js?id=63933339"></script>
        <!-- <script src="js/datatables/datatables-simple-demo.js"></script> -->
        <script type="text/javascript">
            function ofertaTerminaEn()
            {
                const ahora = new Date();
                let diaFinalizacion;
                if (ahora.getDate() <= 15) {
                  diaFinalizacion = new Date(ahora.getFullYear(), ahora.getMonth(), 15, 22, 0, 0);
                } else {
                  const ultimoDiaDelMes = new Date(ahora.getFullYear(), ahora.getMonth() + 1, 0);
                  diaFinalizacion = new Date(ahora.getFullYear(), ahora.getMonth(), ultimoDiaDelMes.getDate(), 22, 0, 0);
                }
                let tiempoRestanteEnMs = diaFinalizacion - ahora;
                let dias = Math.floor(tiempoRestanteEnMs / (1000 * 60 * 60 * 24));
                let horas = Math.floor((tiempoRestanteEnMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutos = Math.floor((tiempoRestanteEnMs % (1000 * 60 * 60)) / (1000 * 60));
                let segundos = Math.floor((tiempoRestanteEnMs % (1000 * 60)) / 1000);

                const intervalId = setInterval(() => {
                  tiempoRestanteEnMs = diaFinalizacion - new Date();
                  dias = Math.floor(tiempoRestanteEnMs / (1000 * 60 * 60 * 24));
                  horas = Math.floor((tiempoRestanteEnMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                  minutos = Math.floor((tiempoRestanteEnMs % (1000 * 60 * 60)) / (1000 * 60));
                  segundos = Math.floor((tiempoRestanteEnMs % (1000 * 60)) / 1000);

                  const salidaContador = document.getElementById("salidaContador");
                  salidaContador.textContent = `La oferta termina en: ${dias} días, ${horas} horas, ${minutos} minutos, ${segundos} segundos.`;

                  if (tiempoRestanteEnMs <= 0) {
                    clearInterval(intervalId);
                    salidaContador.textContent = "¡La oferta ha terminado!";
                  }
                }, 1000);
            }
            ofertaTerminaEn();

            function convertirFecha(cadenaFecha)
            {
                const partes = cadenaFecha.split(" ");
                const dia = parseInt(partes[0], 10);
                const mes = obtenerNumeroMes(partes[1]);
                const anio = parseInt(partes[2], 10);
                return new Date(anio, mes, dia);
            }

            function obtenerNumeroMes(mesAbreviado)
            {
                const meses = ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
                return meses.indexOf(mesAbreviado.toLowerCase());
            }

            function leerFechasFiltrado()
            {
                // Obtener el rango de fechas en formato "01 ene, 2023 - 08 ene, 2023"
                const fechaOriginal = document.getElementById('litepickerRangePlugin').value;
                const fechasSeparadas = fechaOriginal.split(" - ");

                // console.log(fechasSeparadas);

                const fechaInicio = convertirFecha(fechasSeparadas[0]);
                const fechaFin    = convertirFecha(fechasSeparadas[1]);

                const meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

                const fechaInicioFormateada = `${(fechaInicio.getFullYear() +1)}-${("0" + (meses.indexOf(fechasSeparadas[0].substr(3, 3)) + 1)).slice(-2)}-${("0" + fechaInicio.getDate()).slice(-2)}`;
                const fechaFinFormateada = `${(fechaFin.getFullYear() +1)}-${("0" + (meses.indexOf(fechasSeparadas[1].substr(3, 3)) + 1)).slice(-2)}-${("0" + fechaFin.getDate()).slice(-2)}`;
                // console.log('fechaInicio: ' + fechaInicioFormateada);
                // console.log('fechaFin: ' + fechaFinFormateada);
                location.href = 'estadisticas.php?rangoFecha=' + fechaInicioFormateada + ';' + fechaFinFormateada;
            }

            function actualizarLitePicker(fecha)
            {
                //console.log(fecha);
                document.getElementById('litepickerRangePlugin').value = fecha;
            }

            function downloadURI(uri, name)
            {
                var link = document.createElement("a");
                link.download = name;
                link.href = uri;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                delete link;
            }            

            function makeCodeUrlPago(contenidoQR)
            {
                let qrcode = new QRCode(document.getElementById("qrcode"),
                {
                  text: contenidoQR,
                  width: 1080,
                  height: 1080,
                  colorDark : "#000000",
                  colorLight : "#ffffff",
                  correctLevel : QRCode.CorrectLevel.H
                });

                setTimeout(
                    function ()
                    {
                        let dataUrl = document.querySelector('#qrcode').querySelector('img').src;
                        var tienda = '<?php echo $_SESSION['managedStore']; ?>';
                        downloadURI(dataUrl, 'conejonDigital_' + tienda + '.png');
                    },1000
                );
            }

        </script>
        <?php

        if (isset($_GET['rangoFecha']))
        {
            ?>
            <script type="text/javascript">

                <?php
                    setlocale(LC_TIME, "es_ES");
                    $meses = array(
                        "Enero"   => "ene",
                        "Febrero" => "feb",
                        "Marzo"   => "mar",
                        "Abril"   => "abr",
                        "Mayo"    => "may",
                        "Junio"   => "jun",
                        "Julio"   => "jul",
                        "Agosto"  => "ago",
                        "Septiembre" => "sep",
                        "Octubre"    => "oct",
                        "Noviembre"  => "nov",
                        "Diciembre"  => "dic"
                    );
                    // $fechaInicio = date("d", strtotime($fechaInicio)) . " " . $meses[4] . ", " . date("Y", strtotime($fechaInicio));

                    //echo $fechaInicio . $fechaFin;
                    $mesfechaInicio = strftime("%B", strtotime($fechaInicio));
                    $mesfechaFin    = strftime("%B", strtotime($fechaFin));

                    // Construyo fecha con formato para litepicker
                    $fechaLitepicker =
                        strftime("%d", strtotime($fechaInicio))
                        . " "
                        . $meses[ucfirst($mesfechaInicio)]
                        . ", "
                        . strftime("%Y", strtotime($fechaInicio))
                        . " - "
                        . strftime("%d", strtotime($fechaFin))
                        . " "
                        . $meses[ucfirst($mesfechaFin)]
                        . ", "
                        . strftime("%Y", strtotime($fechaFin));

                    $fechaLitepicker = strtolower($fechaLitepicker);
                ?>

                setTimeout(function ()
                {
                    actualizarLitePicker('<?php echo $fechaLitepicker; ?>');
                }, 500);

                
            </script>
            <?php
        }

        if (file_exists('src/triggers.php'))
        {
            require 'src/triggers.php';
        }

        ?>
    </body>
</html>
