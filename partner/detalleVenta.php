<?php

    session_start();

    require '../app/php/conexion.php';
    require 'php/funciones.php';

    if (isset($_SESSION['email']))
    {
        $emailUsuario = $_SESSION['email'];
    }

    if (isset($_SESSION['managedStore']))
    {
        $managedStore = $_SESSION['managedStore'];
        $managedStore = getDatosTienda($conn, $managedStore); // $managedStore recibe el idOwner y username(managedStore)
        if ($managedStore === false)
        {
            die("Redirecciona, usuario no encontrado");
        }
        $idTienda = $managedStore['idTienda'];
        $idOwner  = $managedStore['administradoPor'];
    }

    $hasActivePayment  = validarPagoActivo($conn, $idTienda);

    if (isset($_GET['id']))
    {
        $idPedido = $_GET['id'];
    }

    $datosPedido = getDatosPedido($conn, $idPedido, $idTienda);      
    $detallesProducto = getProductosComprados($conn, $datosPedido['idPedido'], $datosPedido['idTienda']);

    // echo "<pre>";
    // print_r($detallesProducto);
    // die;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detalle Venta</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=15" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script src="js/funciones.js?id=33"></script>
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

        <!-- Gallery -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.4/css/lightgallery.css'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.4/css/lg-zoom.css'>
        <link rel="stylesheet" href="css/gallery-styles.css?id=28">
        <!-- Gallery -->

        <style type="text/css">

          .imagenProducto
          {
              height: 128px;
          }

          .flotante
          {
              position:fixed;
              bottom:15px;
              right:15px;
              margin:0;
              padding:10px;
          }

          .circle
          {
              transition: 0.5s;
          }

          .circle:hover
          {
              transition: 0.5s;
              transform: scale(1.3);
          }

          /**Desktop Query*/
          @media only screen and (min-width: 768px)
          {
            .resText
            {
              font-size: 13px;
            }
            .resTextTotal
            {
              font-size: 15px;
            }
          }

          /*Tablet Query*/
          @media only screen and (min-width: 481px) and (max-width:768px)
          {
            .resText
            {
              font-size: 13px;
            }
            .resTextTotal
            {
              font-size: 15px;
            }
          }

          /*Mobile Query*/
          @media only screen and (max-width:480px)
          {
            .resText
            {
              font-size: 16px;
            }
            .resTextTotal
            {
              font-size: 18px;
            }
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
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-8">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-3">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto">
                                        
                                        <div class="page-header-subtitle mb-4">

                                            
                                            <a href="mis-ventas.php" class="btn btn-outline-white shadow-sm rounded-pill text-decoration-none fw-500 mb-1" name="button">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                 Mis Ventas
                                            </a>
                                            
                                        </div>
                                        
                                        <div class="row">

                                            <div class="col">
                                                <div class="page-header-title mb-3">
                                                                                                
                                                    <!-- <i class="feather-xl me-2 text-white-50" data-feather="package"></i> -->
                                                    <img src="assets/img/caja.png" class="me-2" style="height: 66px;" alt="">
                                                    Venta
                                                    <span class="fw-300 small ms-2 text-nowrap">#<?php echo $idPedido ; ?></span>

                                                </div>
                                            </div>
        
                                            <div class="col mt-3 p-0">
                                                <button class="btn btn-sm btn-outline-white btn-icon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-lg"></i>
                                                </button>
                                                
                                                
                                                
                                                <div class="dropdown-menu dropdown-menu-start animated--fade-in-up shadow" aria-labelledby="dropdownMenuButton">
                                                    
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalDevoluciones" style="cursor: pointer;">
                                                        <div class="dropdown-item-icon">
                                                            <i class="text-gray-500" data-feather="minus-circle"></i>
                                                        </div>
                                                        Devolución
                                                    </a>

                                                    
                                                    <!-- <a class="dropdown-item" href="#!">
                                                        <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="plus-circle"></i></div>
                                                        Add New Task
                                                    </a>
                                                    <a class="dropdown-item" href="#!">
                                                        <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="minus-circle"></i></div>
                                                        Delete Tasks
                                                    </a> -->

                                                </div>

                                            </div>
                                        
                                    </div>
                                    
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb px-2 py-1 rounded rounded-2 bg-transparent small">
                                            <li class="breadcrumb-item"><a href="dashboard.php"><?php echo "@".$_SESSION['managedStore']; ?></a></li>
                                            <li class="breadcrumb-item"><a href="mis-ventas.php">Ventas</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Detalle de venta</li>
                                        </ol>
                                    </nav>

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
                        <div class="row gx-4">

                            <div class="col-lg-8">
                                <div class="card mb-4 card-waves">
                                    <div class="card-header">Historial del pedido</div>
                                    <div class="card-body">
                                        <!-- TIMELINE INICIO -->
                                        <div class="timeline timeline-xs">

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <!-- <div class="timeline-item-marker-text"></div> -->
                                                    <div class="timeline-item-marker-indicator bg-success"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    <p class="fw-bold text-dark" href="#!">Pedido Recibido</p>
                                                    <?php
                                                      if ($datosPedido['idTipoPedido'] == "PDV")
                                                      {
                                                          $tipoPedido = '<i class="fas fa-cash-register fa-sm me-1 text-muted"></i>' . $datosPedido['idTipoPedido'];
                                                      }
                                                      else
                                                      {
                                                          $tipoPedido = '<i class="fas fa-store fa-sm me-1 text-muted"></i>' . $datosPedido['idTipoPedido'];
                                                      }
                                                    ?>
                                                    <p>
                                                        <i class="fas fa-calendar-day me-1 text-muted"></i> Lo <b>vendiste</b> el <span><?php echo date("d/m/Y · H:i", strtotime($datosPedido['fechaPedido'])); ?> hrs.</span>
                                                        <span class="rounded-pill border p-2 fw-600 border-1 small border-primary"><?php echo $tipoPedido; ?></span>
                                                    </p>
                                                    <div class="col-lg-8 col-12 mb-2">
                                                        <div class="card bg-blue text-white card-collapsable">

                                                            <a class="card-header text-decoration-none text-white collapsed" href="#collapseDatosCliente" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseDatosCliente">
                                                                Datos del cliente
                                                                <div class="card-collapsable-arrow">
                                                                    <i class="fas fa-chevron-down"></i>
                                                                </div>
                                                            </a>
                                                            <div class="card-footer collapse" id="collapseDatosCliente">
                                                                <?php

                                                                    //$mediosContacto = getMediosContactoVendedor($conn, $datosPedido['idTienda']);
                                                                    $datosCliente = getDatosCliente($conn, $datosPedido['idCliente']);

                                                                    if ($datosCliente == false)
                                                                    {
                                                                        echo "No se registró un cliente.";
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "<span class='mb-2'>Nombre: " . ucwords(strtolower($datosCliente['nombre'])) . " " . ucwords(strtolower($datosCliente['paterno'])) . " " . ucwords(strtolower($datosCliente['materno'])) . "</span>";
                                                                        echo "<br>";
                                                                        echo "<span class='mb-2'><i class='fas fa-phone me-2'></i> <a class='text-decoration-none text-white text-underlined' href='tel: ". $datosCliente['telefono'] ."'><u>". $datosCliente['telefono'] ."</u></a></span>";
                                                                        echo "<br>";
                                                                        echo "<span class='mb-2'><i class='far fa-envelope me-2'></i> " . $datosPedido['idCliente']  . "</span>";
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <!-- <div class="timeline-item-marker-text"></div> -->
                                                    <div class="timeline-item-marker-indicator bg-success"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    <p class="fw-bold text-dark" href="#!">Pago</p>
                                                    <div class="">
                                                        <!-- <div class="mb-3 fw-600 text-blue h6">
                                                            Método Seleccionado:

                                                        </div> -->

                                                        <?php
                                                          if (empty($datosPedido['fechaPago']))
                                                          {
                                                              ?>
                                                              <p class="mb-1">
                                                                  <span class="badge bg-warning text-white">
                                                                      <i class="fas fa-exclamation-triangle me-1"></i> Pago en espera
                                                                  </span>
                                                              </p>
                                                              <hr class="mx-5 text-gray-400">
                                                              <?php
                                                          }

                                                          if (empty($datosPedido['fechaPago']))
                                                          {
                                                              ?>
                                                              <div class=" " role="group" aria-label="Basic example">
                                                                  <!-- <button class="btn btn-outline-primary" type="button" name="button" data-bs-toggle="modal" data-bs-target="#modalMostrarMetodoDePago">
                                                                      <i class="me-2" data-feather="dollar-sign"></i>
                                                                      Pagar
                                                                  </button> -->
                                                                  <input type="hidden" name="idCliente" value="<?php echo $datosPedido['idCliente']; ?>">
                                                                  <button class="btn btn-primary rounded-3" type="button" name="button" data-bs-toggle="modal" data-bs-target="#modalConfirmarPago">
                                                                      Confirmar pago
                                                                      <i class="ms-2" data-feather="check-circle"></i>
                                                                  </button>
                                                              </div>
                                                              <?php
                                                          }
                                                          else
                                                          {
                                                              ?>
                                                              <!-- <div class="mb-2">Método de pago: <span class="border-2 border-bottom border-primary"><?php echo $datosPedido['nombreMetodoPago']; ?></span></div> -->

                                                              <span class="badge bg-green-soft text-dark">
                                                                  <i class="far fa-check-circle"></i>
                                                                  Confirmado el <?php echo date("d/m/Y · h:i", strtotime($datosPedido['fechaPago'])) . " hrs."; ?>
                                                              </span>
                                                              <?php
                                                          }

                                                          if (!empty($datosPedido['comprobantePago']))
                                                          {
                                                              ?>
                                                              <div class="gallery-container d-flex " id="gallery-container">
                                                                  <a
                                                                    data-lg-size="1400-1400" style="cursor: pointer;"
                                                                    class="gallery-item text-decoration-none"
                                                                    data-src="verifica/usr_docs/<?php echo $datosPedido['idTienda']; ?>/pedidos/<?php echo $datosPedido['idPedido']; ?>/<?php echo $datosPedido['comprobantePago']; ?>"
                                                                    data-sub-html="<h4>Comprobante de pago</h4>">
                                                                        <i class="fas fa-receipt me-1"></i> Ver Comprobante
                                                                  </a>
                                                              </div>
                                                              <?php
                                                          }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <!-- <div class="timeline-item-marker-text"></div> -->
                                                    <div class="timeline-item-marker-indicator bg-success"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    <p class="fw-bold text-dark" href="#!">Envío/Recolección</p>
                                                    <div class="p-0 col-lg-8 col-12">
                                                        <?php
                                                            if ($datosPedido['idTipoPedido'] == "PDV")
                                                            {
                                                                ?>
                                                                <span class="badge bg-success-soft text-dark">
                                                                    <i class="far fa-check-circle me-1"></i>
                                                                    No requiere envío
                                                                </span>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                if (!isset($datosPedido['fechaEnvio']) && $datosPedido['idEstatusPedido'] == "EP-1" && !isset($datosPedido['fechaPago']))
                                                                {
                                                                  ?>
                                                                  <div class="btn btn-outline-danger btn-sm">
                                                                      Pendiente de pago
                                                                  </div>
                                                                  <?php
                                                                }
                                                                elseif (!isset($datosPedido['fechaEnvio']) && isset($datosPedido['fechaPago']) && $datosPedido['idEstatusPedido'] == "EP-2")
                                                                {
                                                                  ?>

                                                                  Avísale al cliente cuando el pedido esté listo para su recolección en la sucursal indicada o que ya has enviado el paquete.

                                                                  <br>
                                                                  <button class="btn btn-success mb-2 mt-3 rounded-pill" type="button" name="button" data-bs-toggle="modal" data-bs-target="#modalConfirmaEnvio">
                                                                      <i class="far fa-paper-plane me-1"></i> Notificar al cliente
                                                                  </button>
                                                                  <?php
                                                                }
                                                                elseif (isset($datosPedido['fechaEnvio']) && isset($datosPedido['fechaPago']) && ($datosPedido['idEstatusPedido'] == "EP-3" || $datosPedido['idEstatusPedido'] == "EP-4"))
                                                                {
                                                                    ?>
                                                                    <span class="badge bg-danger-soft text-dark">
                                                                      <i class="far fa-check-circle me-1"></i>
                                                                      Enviado/Recolección: <?php echo date("d/m/Y ·", strtotime($datosPedido['fechaEnvio'])) . ""; ?>
                                                                    </span>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                  ?>

                                                                  <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <!-- <div class="timeline-item-marker-text"></div> -->
                                                    <div class="timeline-item-marker-indicator bg-success"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                    <p class="fw-bold text-dark" href="#!">Entrega</p>
                                                    <p>
                                                    <?php
                                                        if ($datosPedido['idTipoPedido'] != "PDV")
                                                        {
                                                            if ($datosPedido['idEstatusPedido']=="EP-4" && isset($datosPedido['fechaEnvio']) && isset($datosPedido['fechaCierrePedido']))
                                                            {
                                                                ?>
                                                                <span class="badge bg-success-soft text-dark">
                                                                    <i class="far fa-check-circle me-1"></i>
                                                                    Pedido Cerrado <?php echo date("d/m/Y · h:i", strtotime($datosPedido['fechaCierrePedido'])) . " hrs."; ?>
                                                                </span>
                                                                <?php
                                                            }
                                                            elseif ($datosPedido['idEstatusPedido']=="EP-3" && isset($datosPedido['fechaEnvio']) && !isset($datosPedido['fechaCierrePedido']))
                                                            {
                                                                ?>
                                                                <button class="btn btn-pink btn-sm mb-2" type="button" name="button" data-bs-toggle="modal" data-bs-target="#modalCerrarPedido">
                                                                    Cerrar pedido
                                                                </button>
                                                                <?php
                                                            }
                                                            elseif (($datosPedido['idEstatusPedido']=="EP-2" || $datosPedido['idEstatusPedido']=="EP-1") && !isset($datosPedido['fechaEnvio']) && !isset($datosPedido['fechaCierrePedido']))
                                                            {
                                                                ?>
                                                                <div class="btn btn-outline-danger btn-sm">
                                                                    Pendiente de envío
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if ($datosPedido['idEstatusPedido']=="EP-4")
                                                            {
                                                              ?>
                                                              <span class="badge bg-success-soft text-dark">
                                                                  <i class="far fa-check-circle me-1"></i>
                                                                  Pedido entregado en PDV
                                                              </span>
                                                              <?php
                                                            }
                                                        }
                                                    ?>
                                                    </p>

                                                </div>
                                            </div>

                                        </div>
                                        <!-- TIMELINE FIN -->
                                    </div>
                                </div>
                                <div class="card card-waves card-collapsable mb-4">
                                    <a class="card-header" href="#detalleEnvio" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="detalleEnvio">
                                        Detalles de envío
                                        <div class="card-collapsable-arrow">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </a>
                                    <div class="collapse" id="detalleEnvio">
                                        <div class="card-body">
                                            <?php

                                              // echo "<pre>";
                                              // print_r($datosPedido);

                                              //echo "<br><br>Direccion Pedido Detalle: <br><br>";
                                              $direccionPedido = false;
                                              if ($datosPedido['idTipoPedido'] != "PDV")
                                              {
                                                  $direccionPedido = getDireccionPedidoDetalle($conn, $datosPedido['idTipoEnvio'], $datosPedido['idDireccionEnvio'], $datosPedido['idCliente'], $datosPedido['idTienda']);
                                                  // echo "<pre>";
                                                  // var_dump($direccionPedido);
                                                  // die;
                                                  if ($direccionPedido == false)
                                                  {
                                                      echo "Ocurrió un error, intenta acutalizar la página.";
                                                  }
                                                  else
                                                  {
                                                      // echo $direccionPedido['msg'];

                                                      echo "<p class='m-2'>";
                                                          echo (isset($direccionPedido['msg']) ? $direccionPedido['msg'] : "");
                                                          echo "<br>";
                                                          if (isset($direccionPedido['alias'], $direccionPedido['direccion']))
                                                          {
                                                              echo "<span class='fw-700 text-green'>";
                                                              echo (isset($direccionPedido['alias']) ? $direccionPedido['alias'].": " : "");
                                                              echo "</span>";

                                                              echo "<span class='fw-700 text-gray-600'>";
                                                              echo (isset($direccionPedido['direccion']) ? $direccionPedido['direccion'] : "");
                                                              echo "</span>";
                                                          }
                                                      echo "</p>";
                                                  }
                                              }
                                              else
                                              {
                                                  echo "Este pedido no requiere envío, si necesitas ayuda contacta al vendedor.";
                                              }

                                              //var_dump($direccionPedido);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-waves card-collapsable mb-4">
                                    <a class="card-header" href="#listadoProductos" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="listadoProductos">
                                        Productos Comprados
                                        <div class="card-collapsable-arrow">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </a>
                                    <div class="collapse" id="listadoProductos">
                                        <div class="card-body">
                                            <?php
                                                // echo "<pre>";
                                                // var_dump($detallesProducto);
                                                //die;

                                                if ($detallesProducto !== false)
                                                {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless mb-0">
                                                            <thead class="border-bottom">
                                                                <tr class="small text-uppercase text-muted">
                                                                    <th scope="col">Nombre</th>
                                                                    <th class="text-end" scope="col">Cantidad</th>
                                                                    <th class="text-end" scope="col">Precio Unitario</th>
                                                                    <th class="text-end" scope="col">Precio Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <?php
                                                                foreach ($detallesProducto as $key => $val)
                                                                {
                                                                    ?>
                                                                    <tr class="border-bottom small">
                                                                        <td>
                                                                            <div class="fw-bold">
                                                                                <!-- <a href="../detalleProducto.php?idProducto=<?php echo $val['idProducto']; ?>&idVendedor=<?php //echo $val['idVendedor']; ?>" target="_blank"><?php //echo $val['nombre']; ?></a> -->
                                                                                <?php echo $val['nombre']; ?>
                                                                            </div>
                                                                            <div class="small text-muted d-none d-md-block">
                                                                                <?php
                                                                                    echo mb_strimwidth($val['descripcion'], 0, 100, "...");
                                                                                ?>
                                                                            </div>
                                                                        </td>

                                                                        <?php $unidadVenta= $val['unidadVenta'] === 'Kilogramos' ? 'Kgs.' : 'Pzs.'; ?>
                                                                        <td class="text-end fw-bold text-end">
                                                                            <?php echo $val['cantidad'] . " " . $unidadVenta; ?>
                                                                        </td>

                                                                        <td class="text-end fw-bold">
                                                                            <?php echo "$ " . number_format($val['precioUnitario'], 2); ?>
                                                                        </td>

                                                                        <td class="text-end fw-700">
                                                                            <?php echo "$ " . number_format($val['cantidad'] * $val['precioUnitario'], 2); ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>

                                                                <!-- <tr>
                                                                    <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Subtotal:</div></td>
                                                                    <td class="text-end pb-0"><div class="h5 mb-0 fw-700">$,1925.00</div></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Tax (7%):</div></td>
                                                                    <td class="text-end pb-0"><div class="h5 mb-0 fw-700">$134.75</div></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="text-end pb-0" colspan="3"><div class="text-uppercase small fw-700 text-muted">Total Amount Due:</div></td>
                                                                    <td class="text-end pb-0"><div class="h5 mb-0 fw-700 text-green">$2059.75</div></td>
                                                                </tr> -->

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">

                                <div class="card card-waves card-header-actions mb-3">
                                    <div class="card-header">
                                        Total de la venta
                                        <!-- <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="After submitting, your post will be published once it is approved by a moderator."></i> -->
                                    </div>
                                    <div class="card-body">

                                        <div class="totales p-1 me-2 text-end">
                                            <div class="container">
                                                <div class="row">

                                                    <div class="col resText text-gray-700 text-start">
                                                        Subtotal:
                                                    </div>

                                                    <div class="col resText text-end">
                                                        $ <?php echo number_format($datosPedido['subtotal'], 2); ?>
                                                    </div>

                                                    <div class="w-100"></div>

                                                    <div class="col resText text-gray-700 text-start">
                                                        Envío:
                                                    </div>

                                                    <div class="col resText">
                                                        <?php

                                                            if ($datosPedido['precioEnvio'] == 0)
                                                            {
                                                                ?>
                                                                <span class="fw-600">GRATIS</span>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                echo "$ " .number_format($datosPedido['precioEnvio'], 2);
                                                            }
                                                        ?>
                                                    </div>

                                                    <div class="w-100"></div>

                                                    <div class="col resText text-danger text-start">
                                                        Descuentos:
                                                    </div>

                                                    <div class="col resText text-danger">
                                                        - $ <?php echo number_format($datosPedido['descuentoTienda'], 2); ?>
                                                    </div>

                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col resTextTotal fw-600 text-start">Total Pagado:</div>
                                                <div class="col resTextTotal fw-600 text-green">$ <?php echo number_format($datosPedido['total'], 2); ?></div>
                                            </div>

                                        </div>
                                        <!-- <pre>
                                            <?php //detalle($datosPedido); ?>
                                        </pre> -->
                                        <!-- <div class="d-grid mb-3"><button class="fw-500 btn btn-primary-soft text-primary">Save as Draft</button></div>
                                        <div class="d-grid"><button class="fw-500 btn btn-primary">Submit for Approval</button></div> -->
                                    </div>
                                </div>


                                <div class="card bg-indigo text-white mb-3">
                                    <div class="card-header fw-300">
                                        <i class="fas fa-star text-yellow"></i> Calificación
                                        <!-- <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="After submitting, your post will be published once it is approved by a moderator."></i> -->
                                    </div>
                                    <div class="card-body">
                                        <div class="display-4">
                                            <?php 

                                                $comentario = hasCalificacionPedido($conn, $idPedido);
                                                
                                                //var_dump($comentario);

                                                if ($comentario)                                                
                                                {
                                                    echo $comentario['calificacion'] . '/5';
                                                }
                                                else
                                                {
                                                    echo "Pendiente";
                                                }                                                
                                            ?>                                            
                                        </div>

                                        <?php
                                        if (isset($comentario['comentario'])) 
                                        {
                                        ?>                                                                                
                                        <div class="mb-2 p-2">
                                            <?php
                                                echo '"' . $comentario['comentario'] . '"';
                                            ?>
                                        </div>
                                        <?php 
                                        }

                                        if (isset($comentario['fechaCalificacion'])) 
                                        {
                                        ?>
                                        <div class="small text-yellow text-end">
                                            <?php
                                                echo date("d/M/Y H:i:s", strtotime($comentario['fechaCalificacion']));
                                            ?>
                                        </div>                                        
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                      if (file_exists('src/footer.php')) { include 'src/footer.php'; }
                    ?>
                </main>
            </div>
        </div>

        <?php
            if (file_exists('src/modals.php')) 
            {
                include 'src/modals.php'; 
            }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>
        <script type="module" src="js/gallery-script.js"></script>
    </body>
</html>
<?php
  if (file_exists('src/triggers.php'))
  {
    include 'src/triggers.php';
  }
?>
