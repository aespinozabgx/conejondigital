<?php

    session_start();

    require 'php/conexion_db.php'; //configuración conexión db
    require 'php/funciones.php'; //configuración conexión db

    if (isset($_SESSION['email']) && !empty(($_SESSION['email'])))
    {
        $emailUsuario = $_SESSION['email'];        
    }
    else
    {
        exit(header('Location: salir.php'));
    }

    if (isset($_SESSION['managedStore']))
    {
        $managedStore = $_SESSION['managedStore'];
    }

    if (isset($_GET['id']))
    {
        $idPedido = $_GET['id'];
    }

    $datosPedido         = getDatosPedidoCliente($conn, $idPedido, $emailUsuario);
    $mediosContacto      = getMediosContactoVendedor($conn, $datosPedido['idTienda']);
    $metodosDePagoTienda = getMetodosDePagoTienda($conn, $datosPedido['idTienda']);
    $hasActivePayment    = validarPagoActivo($conn,  $datosPedido['idTienda']);

    // echo "<pre>";
    // print_r($datosPedido);
    // die;
?>
<!DOCTYPE html>
<html lang="es">
    <head>

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>Detalle Compra</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=28" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />

        <script src="js/funciones.js?id=33"></script>
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Gallery -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.4/css/lightgallery.css'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.4/css/lg-zoom.css'>
        <link rel="stylesheet" href="css/gallery-styles.css?id=28">
        <!-- Gallery -->

        <style type="text/css">
            /* Alinea los íconos horizontalmente */
            .social-icons a 
            {
                display: inline-block;
                margin-right: 15px; /* Espacio entre los íconos */
            }         

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
              if (file_exists('src/sidenav.php'))
              {
                include 'src/sidenav.php';
              }
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-indigo bg-gradient pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-2">
                                        
                                        <a href="mis-compras.php" class="btn btn-blue border-white border-1 text-white shadow-sm rounded-pill fs-6 fw-400 mb-2" name="button">
                                            <i class="far fa-arrow-alt-circle-left me-2"></i>
                                            Volver a pedidos
                                        </a>

                                        <h1 class="page-header-title">                                            
                                            <img src="assets/img/caja.png" class="me-2" style="width: 88px;" alt="">                              
                                            Pedido 
                                            <span class="fw-300 small ms-2">#<?php echo $idPedido; ?></span>
                                        </h1>                                        

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
                        <div class="row gx-4">

                            <div class="col-lg-8">
                                <div class="card mb-4 card-waves">
                                    <div class="card-header"><i class="fas fa-stream me-1"></i> Timeline</div>
                                    <div class="card-body">
                                        <!-- TIMELINE INICIO -->
                                        <div class="timeline timeline-xs">

                                            <div class="timeline-item">
                                                <div class="timeline-item-marker">
                                                    <!-- <div class="timeline-item-marker-text"></div> -->
                                                    <div class="timeline-item-marker-indicator bg-success"></div>
                                                </div>
                                                <div class="timeline-item-content">
                                                
                                                    <p class="fw-600 fs-5 text-blue" href="#!"><i class="feather-lg me-1" data-feather="package"></i> Pedido recibido</p>
                                                    <div class="ps-2 ps-lg-4 pe-2 pe-lg-4">
                                                        
                                                        <p class="mb-2">
                                                            Lo <b>compraste</b> el <i class="fas fa-calendar-day ms-1 me-1 text-muted"></i>  <span><?php echo date("d/M/Y", strtotime($datosPedido['fechaPedido'])) . " a las " . date("H:i", strtotime($datosPedido['fechaPedido'])); ?> hrs.</span>
                                                        </p>

                                                        <div class="col-lg-8 col-12 mb-0">
                                                            <div class="card card-waves text-dark card-collapsable shadow-sm">
                                                                <a class="card-header bg-blue text-white text-decoration-none" data-bs-toggle="collapse" href="#collapseDatosCliente" role="button" aria-expanded="false" aria-controls="collapseDatosCliente">
                                                                    Datos del Vendedor
                                                                    <div class="card-collapsable-arrow">
                                                                        <i class="fas fa-chevron-down"></i>
                                                                    </div>
                                                                </a>
                                                                <div class="collapse show" id="collapseDatosCliente">
                                                                    <div class="card-body bg-white pt-4 p-2 rounded-2 shadow-sm">
                                                                        <?php
                                                                        if ($mediosContacto !== false) 
                                                                        {
                                                                            ?>
                                                                            <div class="mb-3 text-center">
                                                                                <a href="../perfil.php?tienda=<?php echo $datosPedido['idTienda']; ?>" class="btn btn-white border-3 border-yellow text-yellow rounded-pill fs-6 fw-50" target="_blank">
                                                                                    <i class="fa-solid fa-store me-2"></i>@<?php echo ucwords(strtolower($datosPedido['idTienda'])); ?>
                                                                                    <span class="small fw-700"></span>
                                                                                </a>
                                                                            </div>
                                                                            <div class="text-center fs-6">Contacto:</div>
                                                                            <?php

                                                                            if ($mediosContacto) {
                                                                                echo '<div class="p-2 text-center social-icons">'; // Contenedor para los íconos

                                                                                foreach ($mediosContacto as $medio) {
                                                                                    switch ($medio['alias']) {
                                                                                        case 'TELEFONO':
                                                                                            echo '<a class="text-dark fs-1" target="_blank" href="tel:' . $medio['data'] . '"><i class="fas fa-phone"></i></a>';
                                                                                            break;
                                                                                        case 'EMAIL':
                                                                                            echo '<a class="text-dark fs-1" target="_blank" href="mailto:' . $medio['data'] . '"><i class="far fa-envelope"></i></a>';
                                                                                            break;
                                                                                        case 'FACEBOOK':
                                                                                            echo '<a class="text-dark fs-1" target="_blank" href="' . $medio['data'] . '"><i class="fab fa-facebook"></i></a>';
                                                                                            break;
                                                                                        case 'INSTAGRAM':
                                                                                            echo '<a class="text-dark fs-1" target="_blank" href="' . $medio['data'] . '"><i class="fab fa-instagram"></i></a>';
                                                                                            break;
                                                                                        case 'WHATSAPP':
                                                                                            echo '<a class="text-dark fs-1" target="_blank" href="https://wa.me/' . $medio['data'] . '"><i class="fab fa-whatsapp"></i></a>';
                                                                                            break;
                                                                                        case 'YOUTUBE':
                                                                                            echo '<a class="text-dark fs-1" target="_blank" href="' . $medio['data'] . '"><i class="fab fa-youtube"></i></a>';
                                                                                            break;
                                                                                    }
                                                                                }

                                                                                echo '</div>'; // Cierre del contenedor de íconos
                                                                            } else {
                                                                                echo 'No se encontraron medios de contacto.';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
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
                                                    
                                                    <p class="fw-600 fs-5 text-blue" href="#!"><i class="feather-lg me-1" data-feather="credit-card"></i> Pago</p>
                                                    <div class="ps-2 ps-lg-4 pe-2 pe-lg-4"> 
                                                        <?php
                                                        if (isset($datosPedido['metodoPagoDesc']))
                                                        {
                                                        ?>
                                                        <div class="mb-3 fw-600 text-dark h6">
                                                            Método Seleccionado: <span class="text-gray-600"><?php echo $datosPedido['metodoPagoDesc'] . "<br>"; ?></span>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>

                                                        <?php

                                                            if (!isset($datosPedido['fechaPago']))
                                                            {
                                                                ?>                                                                
                                                                <div class="btn bg-ama rounded-pill fw-300 fs-6 text-dark">
                                                                    <i class="fas fa-exclamation-triangle me-2"></i> Pago en espera
                                                                </div>                                                             
                                                                <hr class="col-lg-8 mx-5 text-gray-400">
                                                                
                                                                <div class="mb-3">
                                                                    <div class="">
                                                                        Método seleccionado:
                                                                        <span class="fs-6 fw-600 text-blue">
                                                                            <?php 
                                                                                echo $datosPedido['idMetodoDePago'];
                                                                            ?>      
                                                                        </span>                                                                
                                                                    </div>
                                                                    
                                                                    <div class="fs-5 fw-500 f-poppins mb-3 text-danger">
                                                                        Por pagar: 
                                                                        <span class="fw-600 f-righteous">$ <?php echo number_format($datosPedido['total'], 2); ?></span> 
                                                                        <span class="" style="font-size: 0.5em;">MXN</span>
                                                                        <button class="ms-2 btn btn-outline-danger p-3 fw-300 rounded-pill fa-beat" data-bs-toggle="modal" data-bs-target="#modalDatosPago" style="--fa-beat-scale: 1.1;">
                                                                            <i class="fas fa-wallet me-2"></i> Pagar ahora
                                                                        </button>
                                                                    </div>                                                                    
                                                                </div>
                                                                <?php
                                                            }


                                                            if (!isset($datosPedido['fechaPago']))
                                                            {
                                                                if (!isset($datosPedido['comprobantePago']) && empty($datosPedido['comprobantePago']))
                                                                {
                                                                    ?>
                                                                    <!-- <button type="button" class="btn rounded-3 mb-2" data-bs-toggle="modal" data-bs-target="#modalConfirmarPagoCliente">                                                                        
                                                                        <i class="fas fa-cloud-upload-alt me-2"></i>
                                                                        Confirmar pago
                                                                    </button> -->
                                                                    <?php
                                                                }
                                                            }
                                                            else
                                                            {
                                                                ?>                                                                
                                                                <div class="btn rounded-pill bg-green text-white rounded-2 fw-300 mb-3 fs-6">
                                                                    <i class="far fa-check-circle me-2"></i>
                                                                    Pagado 
                                                                </div>    
                                                                <div class="mb-3">Confirmado el <?php echo date("d/M/Y", strtotime($datosPedido['fechaPago'])); ?></div>                                                            
                                                                <?php
                                                            }

                                                            // var_dump($datosPedido['comprobantePago']);
                                                            // echo "<br><hr><br>";

                                                            if (!empty($datosPedido['comprobantePago']) && !is_null($datosPedido['comprobantePago']))
                                                            {
                                                                ?>
                                                                <div class="gallery-container d-flex text-decoration-none" id="gallery-container">
                                                                    <a
                                                                      data-lg-size="1400-1400" style="cursor: pointer;"
                                                                      class="gallery-item text-decoration-none text-blue fw-300"
                                                                      data-src="verifica/usr_docs/<?php echo $datosPedido['idTienda']; ?>/pedidos/<?php echo $datosPedido['idPedido']; ?>/<?php echo $datosPedido['comprobantePago']; ?>"
                                                                      data-sub-html="<h4>Comprobante de pago</h4>">
                                                                          <i class="fas fa-receipt me-2"></i> Ver Comprobante
                                                                    </a>
                                                                </div>
                                                                <?php
                                                            }
                                                            elseif(1 == 3)
                                                            {
                                                                ?>
                                                                <button type="button" class="btn btn-primary mb-2 rounded-3" name="button" data-bs-toggle="modal" data-bs-target="#modalDatosPago">                                                                    
                                                                    <i class="fas fa-wallet me-2"></i>
                                                                    Formas de pago
                                                                </button>
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
                                                    <p class="fw-600 fs-5 text-blue" href="#!"><i class="feather-lg me-1" data-feather="truck"></i> Envío</p>
                                                    <div class="ps-2 ps-lg-4 pe-2 pe-lg-4">
                                                        Elegiste:
                                                        <?php
                                                            if ($datosPedido['idTipoEnvio'] == "DOM") 
                                                            {
                                                                ?>
                                                                <div class="mb-3 fw-600 text-blue fs-6"> <i class="fas fa-truck me-2"></i> Envío a domicilio</div>
                                                                <?php
                                                            }
                                                            elseif($datosPedido['idTipoEnvio'] == "PIK")
                                                            {
                                                                ?>
                                                                <div class="mb-3 fw-600 text-blue fs-6"> <i class="fas fa-store me-2"></i> Recolectar en sucursal</div>
                                                                <?php
                                                            }
                                                          // echo "fechaEnvio: " . $fechaEnvio      = $datosPedido['fechaEnvio'];
                                                          // echo "<br>";
                                                          // echo "fechaPago: " . $fechaPago       = $datosPedido['fechaPago'];
                                                          // echo "<br>";
                                                          // echo "idEstatusPedido: " . $idEstatusPedido = $datosPedido['idEstatusPedido'];
                                                          //
                                                          // echo "<br><br>";

                                                          if (!isset($datosPedido['fechaEnvio']) && !isset($datosPedido['fechaPago']) && ($datosPedido['idEstatusPedido'] == "EP-2" || $datosPedido['idEstatusPedido'] == "EP-4"))
                                                          {
                                                            ?> 
                                                                <span class="badge bg-danger text-white small">
                                                                    Pendiente validación de pago
                                                                </span> 
                                                            <?php
                                                          }
                                                          elseif (isset($datosPedido['fechaEnvio']))
                                                          {
                                                            ?> 
                                                                
                                                                <div>
                                                                    <?php
                                                                        if ($datosPedido['idTipoEnvio'] == "DOM") 
                                                                        {
                                                                            ?>
                                                                            <div class="mb-3 btn rounded-pill bg-success text-white fs-6">
                                                                                <i class="far fa-check-circle me-2"></i> Enviado
                                                                            </div>
                                                                            <div class="fw-300">
                                                                                Tu pedido se envió el
                                                                                <span class="fw-500"><?php echo date("d/M/Y", strtotime($datosPedido['fechaEnvio'])) . ""; ?></span>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        elseif($datosPedido['idTipoEnvio'] == "PIK")
                                                                        {
                                                                            ?>
                                                                            <div class="mb-3 btn rounded-pill bg-success text-white fs-6 rounded-2 fw-300">
                                                                                <i class="far fa-check-circle me-2"></i> Listo para recolección
                                                                            </div>
                                                                            
                                                                            <div class="mb-3 fw-300">
                                                                                <b>¡Ya puedes pasar!</b> Tu pedido ya está disponible y puedes recogerlo en la sucursal seleccionada.
                                                                            </div>                                                                            
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                    
                                                                </div> 
                                                            <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                            
                                                                <div class="btn btn-danger-soft rounded-pill fw-300 rounded-2">
                                                                    Pendiente de envío
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

                                                    <p class="fw-600 fs-5 text-blue" href="#!"><i class="feather-lg me-1" data-feather="check-circle"></i> Entrega</p>
                                                    <div class="ps-2 ps-lg-4 pe-2 pe-lg-4">

                                                        <?php

                                                          if ($datosPedido['idEstatusPedido']=="EP-4" && isset($datosPedido['fechaEnvio']) && isset($datosPedido['fechaCierrePedido']))
                                                          {
                                                            ?>
                                                            
                                                                <div class="btn bg-success text-white fs-6 rounded-pill mb-3">
                                                                    <i class="far fa-check-circle me-1"></i>
                                                                    Entregado
                                                                </div>
                                                                <div class="fw-300">
                                                                    Pedido cerrado el <span class="fw-500"><?php echo date("d/M/Y · H:i", strtotime($datosPedido['fechaCierrePedido'])) . " hrs."; ?></span>
                                                                </div>
                                                            
                                                            <?php
                                                          }
                                                          elseif ($datosPedido['idEstatusPedido']=="EP-3" && isset($datosPedido['fechaEnvio']) && !isset($datosPedido['fechaCierrePedido']))
                                                          {
                                                              ?> 
                                                                  <div class="bg-yellow btn rounded-pill fw-300 fs-6 text-white">
                                                                      En tránsito
                                                                  </div> 
                                                              <?php
                                                          }
                                                          elseif (($datosPedido['idEstatusPedido']=="EP-2" || $datosPedido['idEstatusPedido']=="EP-1") && !isset($datosPedido['fechaEnvio']) && !isset($datosPedido['fechaCierrePedido']))
                                                          {
                                                            ?>
                                                            <div class="btn btn-danger-soft rounded-pill fw-300 rounded-2">
                                                                    Pendiente de envío
                                                                </div>
                                                            <?php
                                                          }

                                                        ?>
                                                    </div>

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
                                                //echo "<br><br>Direccion Pedido Detalle: <br><br>";
                                                // echo "<pre>";
                                                // print_r($datosPedido); 
                                                //   echo "<pre>";
                                                //   print_r($direccionPedido);
                                                //   die;
                                                // var_dump($direccionPedido);
                                              if ($datosPedido['idTipoPedido'] != "PDV")
                                              {

                                                    if (!isset($datosPedido['idDireccionEnvio']) || empty($datosPedido['idDireccionEnvio']))
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
                                                            else
                                                            {
                                                                echo "<span class='fw-700 text-gray-600'>";
                                                                echo (isset($datosPedido['idDireccionEnvio']) ? $datosPedido['idDireccionEnvio'] : "");
                                                                echo "</span>";
                                                            }
                                                        echo "</p>";
                                                    }

                                              }
                                              else
                                              {
                                                  echo "Este pedido no requiere envío.";
                                              }
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

                                                $detallesProducto = getProductosComprados($conn, $idPedido, $datosPedido['idTienda']);

                                                // echo "<pre>";
                                                // var_dump($detallesProducto);
                                                // die;

                                                if ($detallesProducto !== false)
                                                {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless mb-0">
                                                            <thead class="border-bottom">
                                                                <tr class="small text-uppercase text-muted">
                                                                    <th scope="col">Producto</th>
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

                            
                                <div class="card card-waves card-header-actionss mb-4">
                                    <div class="card-header">
                                    <i class="fas fa-dollar-sign me-1"></i> Total
                                        <!-- <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="After submitting, your post will be published once it is approved by a moderator."></i> -->
                                    </div>
                                    <div class="card-body">

                                        <div class="totales p-1 me-2 text-end">

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
                                                    <!-- ERROR -->
                                                    $ <?php echo number_format($datosPedido['precioEnvio'], 2); ?>
                                                </div>

                                                <div class="w-100"></div>

                                                <div class="col resText text-danger text-start">
                                                    Descuentos:
                                                </div>

                                                <div class="col resText text-danger">
                                                    - $ <?php echo number_format($datosPedido['descuentoTienda'], 2); ?>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col resTextTotal fw-600 text-start">Total:</div>
                                                <div class="col resTextTotal fw-600 text-green">
                                                    $ <?php echo number_format($datosPedido['total'], 2); ?> MXN
                                                </div>
                                            </div>

                                        </div>
                                        <!-- <pre> -->
                                            <?php //print_r($datosPedido); ?>

                                        <!-- <div class="d-grid mb-3"><button class="fw-500 btn btn-primary-soft text-primary">Save as Draft</button></div>
                                        <div class="d-grid"><button class="fw-500 btn btn-primary">Submit for Approval</button></div> -->
                                    </div>
                                </div>


                                    <div class="card bg-primary card-header-actions mb-4">
                                    <?php
                                    $calificacion = hasCalificacionPedido($conn, $datosPedido['idPedido']);
                                    // var_dump($calificacion);
                                    if ($calificacion === false)
                                    {
                                    ?>
                                    <div class="card-header text-white fw-300">
                                        ¡Califica tu compra!
                                        <!-- <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="After submitting, your post will be published once it is approved by a moderator."></i> -->
                                    </div>
                                    <div class="card-body">

                                        <div class="">
                                          <?php
                                          if ($datosPedido['idEstatusPedido']=="EP-4" && isset($datosPedido['fechaEnvio']) && isset($datosPedido['fechaCierrePedido']))
                                          {
                                          ?>
                                              <button type="button" class="btn btn-outline-light w-100 fs-5" name="button" data-bs-toggle="modal" data-bs-target="#modalCalificarPedido">Calificar <i class="fa-solid fa-star text-yellow ms-2"></i></button>
                                          <?php
                                          }
                                          else
                                          {
                                          ?>
                                              <button type="button" class="btn btn-outline-light w-100 fs-5" name="button" data-bs-toggle="modal" data-bs-target="#modalNoCalificarPedido">Calificar <i class="fa-solid fa-star text-yellow ms-2"></i></button>
                                          <?php
                                          }
                                          ?>
                                        </div>

                                    </div>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                    <div class="card-header text-white fw-300">
                                        Compra Calificada
                                        <!-- <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="After submitting, your post will be published once it is approved by a moderator."></i> -->
                                    </div>
                                    <div class="card-body text-white ">
                                      <div class="fs-1 fw-600">
                                          <i class="fas fa-star text-yellow "></i> <?php echo $calificacion['calificacion'] ?>
                                      </div>
                                      "<?php echo $calificacion['comentario'] ?>"
                                    </div>
                                    <?php
                                    }
                                    ?>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <?php
            if (file_exists('src/modals.php')) { include 'src/modals.php'; }
            if (file_exists('src/triggers.php'))
            {
                include 'src/triggers.php';
            }

            if (isset($_GET['modal']))
            {
                $modal = $_GET['modal'];
                switch ($modal)
                {

                    case 'modalCalificarPedido':
                        ?>
                        <script type="text/javascript">
                            var modalCalificarPedido = new bootstrap.Modal(document.getElementById("modalCalificarPedido"), {});
                            document.onreadystatechange = function ()
                            {
                                modalCalificarPedido.show();
                            };
                        </script>
                        <?php
                    break;

                    default:
                      // code...
                    break;
                }
            }
        ?>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>
        <script type="module" src="js/gallery-script.js"></script>
    </body>
</html>
