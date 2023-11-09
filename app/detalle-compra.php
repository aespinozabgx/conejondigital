<?php
    
    session_start();
    require 'php/conexion.php';
    require 'php/funciones.php';
    
    $idCliente   = $_SESSION['email'];
    $idPedido = $_GET['id'];

    //$arrayMascotas = buscarMascotasPorIdOwner($conn, $idOwner);
    //$generalesMascota = getGeneralesMascota($conn, $idOwner, $idMascota);
    //$templates = getTemplates($conn);

    $datosPedido = getDatosPedido($conn, $idPedido, $idCliente);
    $urlPaypal = 'https://www.paypal.com/paypalme/ipnexcel/' . $datosPedido['total'] . '?country.x=MX&locale.x=es_XC/';
    $detallesProducto = getProductosComprados($conn, $idPedido, $datosPedido['idCliente']);
    // echo "<pre>";
    // print_r($datosPedido);
    // die;
    
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detalle</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=28" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

        <!-- Gallery -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.4/css/lightgallery.css'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/lightgallery@2.0.0-beta.4/css/lg-zoom.css'>
        <link rel="stylesheet" href="css/gallery-styles.css?id=28">
        <!-- Gallery -->

        <style>
            
            @font-face 
            {
                font-family: 'bangers';
                src: url('fonts/bangers.ttf') format('truetype');
            }

            @font-face 
            {
                font-family: 'bebas';
                src: url('fonts/bebas.ttf') format('truetype');
            }

            @font-face 
            {
                font-family: 'belanosina';
                src: url('fonts/belanosina.ttf') format('truetype');
            }

            @font-face 
            {
                font-family: 'permanentmarker';
                src: url('fonts/permanentmarker.ttf') format('truetype');
            }

            @font-face 
            {
                font-family: 'poppins';
                src: url('fonts/poppins.ttf') format('truetype');
            }

            .design-option 
            {
                display: inline-block;
                margin-right: 10px;
            }

            .design-option img 
            {
                width: 70px;
                height: 70px;
                border: 2px solid #ccc;
                cursor: pointer;
                border-radius: 50px;
            }

            .selected-image 
            {
                width: 100%;
                height: 200px;
                border: 2px solid #ccc;
                margin-top: 10px;
                background-repeat: no-repeat;
                background-size: cover;
                background-color: white;                
            }

            input[type="radio"] 
            {
                display:none;
            }

            .centered-text
            {
                
                -webkit-text-stroke: 1px white;
                color: #fff;
                text-shadow: -2px 2px 1px rgba(106,31,78,0.54);
            }

            .center 
            { 
                height: 200px;
                position: relative;
                border: 3px solid green; 
            }

            .center span 
            {
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
                font-family: 'poppins';
            }

        </style>
        
    </head>
    <body class="nav-fixed">
        <?php
            include 'src/header.php';
        ?>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php
                    include 'src/sidenav.php';
                ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-left ">

                                    <div class="mb-4">
                                        <a href="mis-pedidos.php" class="btn btn-outline-white rounded-pill fw-500 fs-4" name="button">
                                            <i class="far fa-arrow-alt-circle-left me-2"></i>
                                            Mis Pedidos
                                        </a>
                                    </div>

                                    <div class="col-auto mt-4">                                       
                                        <div class="d-flex justify-content-center">
                                            <img src="assets/img/caja.png" class="img-fluid" style="height: 100px;" alt="">
                                        </div>
                                    </div>
                                    
                                    <div class="col-auto mt-4">
                                        
                                    
                                        <h1 class="page-header-title">                                            
                                            Pedido <?php echo $idPedido . $datosPedido['id']; ?>
                                        </h1>
                                        
                                        <div class="page-header-subtitle mb-2">
                                            Comprado el <?php echo date("j/M/Y H:i", strtotime($datosPedido['fechaPedido'])); ?> hrs.
                                        </div>
                                        
                                        <?php
                                        
                                        if ($datosPedido['idEstatusPedido'] == "EP-1")
                                        {
                                            ?>
                                            <a class="btn btn-dark rounded-pill shadow-sm mb-2" href="#pagoEnEspera">
                                                <i class="fas fa-beat fa-circle me-2 text-yellow" style="--fa-animation-duration: 2s; --fa-beat-scale: 1.2;"></i> Pendiente de pago
                                            </a>
                                            <?php
                                            
                                        }

                                        ?>
                                        <!-- <div>
                                            <button class="btn btn-dark shadow-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalMascotaPerdida">
                                                <i class="fas fa-qrcode me-2"></i> Registrar plaquita
                                            </button>

                                            <button type="button" class="btn btn-success shadow-sm mb-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalDisenadorPlaquita">
                                                <i class="fas fa-paw me-2"></i>
                                                Diseñar plaquita 
                                            </button>
                                        </div> -->
                                        

                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                    <div class="row">
                            
                            <?php 
                            ?>
                            <!-- <div class="col-lg-6 col-xl-6 mb-4">
                                <div class="card bg-primary text-white h-100 lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Recompensa:</div>
                                                <div class="text-lg fw-bold"><?php //echo "s"; ?></div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer justify-content-between text-center small">
                                        <a class="text-white stretched-link" href="#!">Editar monto</a>                                        
                                    </div>
                                </div>
                            </div> -->
                            <?php 
                            ?>

                            
                            <!-- <div class="col-lg-6 col-xl-6 mb-4">
                                <div class="card bg-danger text-white h-100 lift">                                                                            
                                    <div class="text-center display-6 fw-bold mt-5 mb-5">
                                        Perdí a mi mascota 🚨
                                    </div>                                   
                                </div>
                            </div> -->

                        </div> 

                                        
                        <div class="row">
                            <div class="col-xxl-8 col-lg-8">
                                 

                                <!-- Illustration dashboard card example-->
                                <div class="card mb-4">
                                    
                                    <div class="card-header text-primary fw-600 fs-4"><i class="fas fa-stream me-2"></i> Timeline</div>
                                    <div class="card-body py-5">
                                        <div class="d-flex flex-column justify-content-center rounded-2 p-3">
                                            
                                            <!-- TIMELINE INICIO -->
                                            <div class="timeline timeline-xs ">

                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <!-- <div class="timeline-item-marker-text"></div> -->
                                                        <div class="timeline-item-marker-indicator bg-success"></div>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        <p class="fw-bold text-dark" href="#!">Pedido Recibido</p>
                                                        <p class="px-4 mb-2 fs-6">
                                                            <i class="fas fa-calendar-day me-1 text-muted"></i> Lo <b>compraste</b> el <span><?php echo date("d/m/Y · H:i", strtotime($datosPedido['fechaPedido'])); ?> hrs.</span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="timeline-item">
                                                    <div class="timeline-item-marker">
                                                        <!-- <div class="timeline-item-marker-text"></div> -->
                                                        <div class="timeline-item-marker-indicator bg-success"></div>
                                                    </div>
                                                    <div class="timeline-item-content">
                                                        <p class="fw-bold text-dark" href="#!">Pago</p>
                                                        <div class="p-0">
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
                                                                        
                                                                        <div class="display-6 mb-2 text-danger fw-500 rounded-2" style="font-family: poppins;"; id="pagoEnEspera">
                                                                            Tu pago está en espera
                                                                        </div>
                                                                        
                                                                        <div class="small text-gray-500 fw-300">
                                                                            No te preocupes, las ofertas y precios establecidos serán respetados según las bases de la promoción.
                                                                        </div>
                                                                        
                                                                        <div class="d-flex flex-column flex-md-row p-1">
                                                                            
                                                                            <div class="col-md order-md-1">
                                                                                <!-- Columna izquierda -->
                                                                                <img class="img-fluid mb-4" src="assets/img/pay.jpg" alt="" style="min-width: 8.25rem" />
                                                                            </div>
                                                                            
                                                                            <div class="col-md mt-5 order-md-2 align-self-center">                                                                                
                                                                                <!-- Column 2 content -->
                                                                                <?php 
                                                                                    //$datosPedido['idMetodoDePago'] = "spinOxxo";
                                                                                    switch ($datosPedido['idMetodoDePago']) 
                                                                                    {
                                                                                        case 'paypal':
                                                                                            
                                                                                            ?>
                                                                                                                                                                                        
                                                                                            <a class="btn btn-primary btn-lg" href="<?php echo $urlPaypal;  ?>" class="" target="_blank">
                                                                                                <i class="fab fa-paypal me-2 fa-xl"></i> 
                                                                                                Pagar 
                                                                                                $<?php echo number_format($datosPedido['total'], 2); ?>  
                                                                                                con Paypal
                                                                                            </a>                                                                                                                                                                                    

                                                                                            <?php
                                                                                            break;

                                                                                            
                                                                                        case 'transferenciaBancaria':                                                                                        
                                                                                            $urlPaypal = 'https://www.paypal.com/paypalme/ipnexcel/' . $datosPedido['total'] . '?country.x=MX&locale.x=es_XC/';

                                                                                            ?>
                                                                                                                                                                                        
                                                                                            <div class="text-primary fw-500 fs-3 mb-3">
                                                                                                <i class="fas fa-wallet me-2"></i>
                                                                                                Transferencia Bancaria
                                                                                            </div>
                                                                                            <div class="fs-5">
                                                                                                <div>Banco: <b>BBVA</b></div>
                                                                                                <div>Clabe: 0121 8001 5611 5556 69</div>
                                                                                                <div>Tarjeta: 4152 3137 5235 2307</div>
                                                                                                <div>Concepto: Nombre completo</div>
                                                                                            </div>                                                                                                                                                                   

                                                                                            <?php
                                                                                            break;
                                                                                        
                                                                                        case 'spinOxxo':                                                                                            
                                                                                            ?>                                                                                                                                                                                        
                                                                                                
                                                                                            <img src="oxxo.png" class="mb-3" style="height: 100px;" alt="">
                                                                                            
                                                                                            <div class="">
                                                                                                <div class="mb-2 fs-4">Cuenta <b class="text-primary fs-3">Spin By Oxxo</b></div>
                                                                                                
                                                                                                <div class="border border-2 p-2 border-orange rounded-3 fs-4">
                                                                                                    <div class="text-center mb-1">Código: </div>
                                                                                                    <div class="fs-1 text-center fw-600">
                                                                                                        2242 1725 5612 9165
                                                                                                    </div>
                                                                                                </div>

                                                                                            </div>
                                                                                            <?php
                                                                                            break;
                                                                                        

                                                                                        default:
                                                                                            # code...
                                                                                            break;
                                                                                    }
                                                                                
                                                                                ?>
                                                                            </div>
                                                                        </div>                                                                        
 
                                                                        <hr class="col-lg-8 mx-5 text-gray-400">
                                                                        
                                                                    <?php
                                                                }

                                                                ?>
                                                                <div class="container">
                                                                    <div class="row">
                                                                        
                                                                        <div class="col mb-2 w-100">
                                                                            <?php
                                                                            if (!isset($datosPedido['fechaPago']))
                                                                            {
                                                                                if (!isset($datosPedido['comprobantePago']) && empty($datosPedido['comprobantePago']))
                                                                                {
                                                                                    ?>
                                                                                    <button type="button" class="btn btn-outline-primary border-blue border-2 f-poppins btn-lg rounded-3 fs-3 fw-500 w-100 h-100" data-bs-toggle="modal" data-bs-target="#modalConfirmarPagoCliente">
                                                                                        <!-- <i class="fa-solid fa-thumbs-up me-1"></i> -->
                                                                                        <i class="fas fa-cloud-upload-alt me-2"></i>
                                                                                        Cargar comprobante
                                                                                    </button>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <div class="mb-2 text-green rounded-2 fs-5 fw-300">
                                                                                    <i class="far fa-check-circle me-1"></i>
                                                                                    Pago confirmado <?php echo date("d/m/Y H:i", strtotime($datosPedido['fechaPago'])) . " hrs."; ?>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div> 

                                                                        <div class="col mb-2 w-100">
                                                                            <?php
                                                                            if (!empty($datosPedido['comprobantePago']) && !is_null($datosPedido['comprobantePago']))
                                                                            {
                                                                                ?>
                                                                                <div class="gallery-container d-flex text-decoration-none" id="gallery-container">
                                                                                    <a
                                                                                    data-lg-size="1400-1400" style="cursor: pointer;"
                                                                                    class="text-decoration-none text-blue fw-500 fs-4"
                                                                                    data-src="users/<?php echo $_SESSION['email']; ?>/pedidos/<?php echo $datosPedido['idPedido']; ?>/<?php echo $datosPedido['comprobantePago']; ?>"
                                                                                    data-sub-html="<h4>Comprobante de pago</h4>">
                                                                                        <i class="fas fa-receipt me-1"></i> 
                                                                                        Ver comprobante
                                                                                        <div class="mb-3 text-center mt-2">
                                                                                            <img style="height: 88px;" class="rounded-3" src="users/<?php echo $_SESSION['email']; ?>/pedidos/<?php echo $datosPedido['idPedido']; ?>/<?php echo $datosPedido['comprobantePago']; ?>" alt="">
                                                                                        </div>
                                                                                    </a>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <button type="button" class="btn btn-success f-poppins btn-lg rounded-3 fs-3 fw-500 w-100 h-100" name="button" data-bs-toggle="modal" data-bs-target="#modalDatosPago">
                                                                                    <i class="far fa-credit-card me-2"></i>
                                                                                    Más formas de pago
                                                                                </button>
                                                                                <?php
                                                                            }                                                                        
                                                                            ?>
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
                                                        <p class="fw-bold text-dark" href="#!">Envío/Recolección</p>
                                                        <div class="p-2">
                                                            <?php

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
                                                                <h6>
                                                                    <span class="badge bg-danger text-white small">
                                                                        Pendiente validación de pago
                                                                    </span>
                                                                </h6>
                                                                <?php
                                                            }
                                                            elseif (isset($datosPedido['fechaEnvio']) && ($datosPedido['idEstatusPedido'] == "EP-3" || $datosPedido['idEstatusPedido'] == "EP-4"))
                                                            {
                                                                ?>
                                                                <h6>
                                                                    <div class="my-2 text-green rounded-2 fs-5 fw-300">
                                                                        <i class="far fa-check-circle me-1"></i>
                                                                        Enviado/Listo para recolección: <?php echo date("d/m/Y H:i", strtotime($datosPedido['fechaEnvio'])) . ""; ?>                                                                        
                                                                    </div>
                                                                </h6>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <h6>
                                                                    <div class="btn btn-danger-soft fw-300 rounded-pill">
                                                                        Pendiente de envío
                                                                    </div>
                                                                </h6>
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

                                                        <p class="fw-bold text-dark" href="#!">Entrega</p>
                                                        <div class="p-2">

                                                            <?php

                                                            if ($datosPedido['idEstatusPedido']=="EP-4" && isset($datosPedido['fechaEnvio']) && isset($datosPedido['fechaCierrePedido']))
                                                            {
                                                                ?>
                                                                <h6>
                                                                    <div class="text-green fs-5 fw-300 rounded-2">
                                                                        <i class="far fa-check-circle me-1"></i>
                                                                        Pedido Completado: <?php echo date("d/m/Y · H:i", strtotime($datosPedido['fechaCierrePedido'])) . " hrs."; ?>
                                                                    </div>
                                                                </h6>
                                                                <?php
                                                            }
                                                            elseif ($datosPedido['idEstatusPedido']=="EP-3" && isset($datosPedido['fechaEnvio']) && !isset($datosPedido['fechaCierrePedido']))
                                                            {
                                                                ?>
                                                                <h6>
                                                                    <div class="text-success fw-400 fs-5 small p-2 rounded-2">
                                                                        <i class="fas fa-truck me-2"></i>
                                                                        En tránsito
                                                                    </div>
                                                                </h6>
                                                                <?php
                                                            }
                                                            elseif (($datosPedido['idEstatusPedido']=="EP-2" || $datosPedido['idEstatusPedido']=="EP-1") && !isset($datosPedido['fechaEnvio']) && !isset($datosPedido['fechaCierrePedido']))
                                                            {
                                                                ?>
                                                                <h6>
                                                                    <div class="btn btn-danger-soft fw-300 rounded-pill">
                                                                        Pendiente de envío
                                                                    </div>
                                                                </h6>
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
                                </div>
 

                            </div>
                            <div class="col-xxl-4 col-lg-4">
                                <div class="row">

                                    <div class="col-xl-12 col-xxl-12">
                                        <!-- Team members / people dashboard card example-->
                                        <div class="card mb-4">

                                            <div class="card-header text-primary fw-600 fs-4">
                                                Totales
                                            </div>

                                            <div class="card-body">                                                
                                                <!--  -->
                                                <div class="totales p-1 text-end">

                                                    <div class="row">

                                                        <div class="col fs-4 text-gray-700 text-start">
                                                            Subtotal:
                                                        </div>

                                                        <div class="col fs-4 text-end">
                                                            $ <?php echo number_format($datosPedido['subtotal'], 2); ?>
                                                        </div>

                                                        <div class="w-100"></div>

                                                        <div class="col fs-4 text-gray-700 text-start">
                                                            Envío:
                                                        </div>

                                                        <div class="col fs-4">
                                                            <!-- ERROR -->
                                                            GRATIS
                                                        </div>

                                                        <div class="w-100"></div>

                                                        <!-- <div class="col fs-4 text-danger fw-500 text-start">
                                                            Descuentos:
                                                        </div>

                                                        <div class="col fs-4 text-danger fw-500">
                                                            - $ <?php echo number_format($datosPedido['descuentos'], 2); ?>
                                                        </div> -->

                                                    </div>

                                                    <div class="row mt-3">
                                                        <hr>
                                                    </div>

                                                    <div class="row">
                                                        
                                                        <div class="col fs-2 fw-500 text-green text-start">Total:</div>
                                                        <div class="col fs-2 fw-500 text-green">
                                                            $ <?php echo number_format($datosPedido['total'], 2); ?>
                                                        </div>
                                                    </div> 

                                                </div>
                                                <!--  --> 
                                            </div>
                                    
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-xxl-12">
                                        <!-- Project tracker card example-->
                                        <div class="card bg-primary card-collapsable mb-4">
                                            <a class="card-header text-white" href="#collapseCardExample" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                                <i class="fas fa-shopping-basket me-2"></i>
                                                    <?php
                                                        if (isset($detallesProducto) && is_array($detallesProducto)) 
                                                        {
                                                            echo sizeof($detallesProducto);
                                                        }
                                                    ?> 
                                                    Productos Comprados
                                                <div class="card-collapsable-arrow">
                                                    <i class="fas fa-chevron-right"></i>
                                                </div>
                                            </a>
                                            <div class="collapse" id="collapseCardExample">                                                
                                            
                                            <?php

                                               

                                                // echo "<pre>";
                                                // print_r($detallesProducto);
                                                // die;

                                                if ($detallesProducto !== false)
                                                {
                                                    ?>
                                                    <div class="table-responsive p-2 my-3 mx-3 border border-3 border-white rounded-2 bg-light" style="--bs-border-opacity: .5;">
                                                        <table class="table table-borderless table-hover text-white mb-0"> 
                                                            <tbody>

                                                                <?php
                                                                $co = 1;
                                                                foreach ($detallesProducto as $key => $val)
                                                                {
                                                                    
                                                                    ?>
                                                                    <tr class="border-bottom" style="cursor: pointer;">
                                                                        <td>
                                                                            <div class="fw-400 text-dark">
                                                                                Producto <?php echo $co++; ?>                                                                                
                                                                            </div>
                                                                            <div class="p-0">
                                                                                <div class="small text-dark">Lanyard personalizado</div>
                                                                                <img src="assets/img/gafete/disenos/<?php echo($val['diseno']); ?>" class="rounded-img" alt="">
                                                                                <img src="gafetes/users/<?php echo $_SESSION['email']; ?>/<?php echo $val['nombre_archivo']; ?>" class="rounded-img" alt="">
                                                                            </div> 
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
                                                else
                                                {
                                                    ?>
                                                    <div class="text-white p-3 text-center">No hay productos</div>
                                                    <?php
                                                }
                                                ?>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Illustration dashboard card example-->
                                <div class="card">
                                    <div class="card-body text-center p-3">
                                        <img class="img-fluid mb-4" src="assets/img/support.png" alt="" style="min-width: 8.25rem" />
                                        <h5>Soporte Vendy</h5>
                                        <p class="mb-4 small">Te ayudaremos a resolver cualquier situación.</p>
                                        <a class="btn btn-light border-2 p-3 rounded-3 w-100 fs-4" href="https://wa.me/+5215610346590?text=Hola, requiero ayuda con mi pedido *<?php echo $idPedido; ?>*  _[Cuenta: <?php echo $idCliente; ?>]_" target="_blank"><i class="fas fa-headset me-2"></i> Contactar a soporte</a>
                                    </div>
                                </div>
                            </div>
                        </div>
 
                        
                    </div>
                </main>
                
                <?php
                include 'src/footer.php';
                ?>

            </div>
        </div>


<!-- Modal datos de pago -->
<div class="modal fade" id="modalDatosPago" tabindex="-1" aria-labelledby="modalDatosPagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="modalDatosPagoLabel"> Datos de pago </h5>
                <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <div class="modal-body">                

                <div class="col-12 mb-4 mt-2">
                    <div class="card text-white h-100" style="background-color: #22c94f;">
                        <div class="card-header text-white">
                            Transferencia Bancaria
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center text-white">
                                <div class="me-3">
                                    <div>Banco: BBVA</div>
                                    <div>Clabe: 0121 8001 5611 5556 69</div>
                                    <div>Tarjeta: 4152 3137 5235 2307</div>
                                </div>
                                <div class="display-6 text-white-50">
                                    <img class="rounded-2 shadow" src="assets/img/logo-bbva.png" style="height: 88px;" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-white" style="cursor:pointer;">
                             
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4 mt-2">
                    <div class="card bg-pink h-100">
                        <div class="card-header text-white">
                            Depósito Efectivo OXXO
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3 text-white fs-5">
                                    <div>Spin By Oxxo</div>
                                    <div>Código: <span class="fs-3 fw-600">2242 1725 5612 9165</span> </div>
                                </div>
                                <div class="display-6 dark">
                                    <img class="" src="assets/img/oxxo.png" style="height: 88px;" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer dark" style="cursor:pointer;">
                             
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4 mt-2">
                    <a href="<?php echo $urlPaypal; ?>" target="_blank" class="">
                    <div class="card bg-blue h-100">
                        <div class="card-header text-white">
                            Pago con Paypal o Tarjeta de crédito/débito
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                
                                <div class="display-6 dark">
                                    <img class="" src="assets/img/paypal.png" style="height: 88px;" alt="">
                                </div>
                                <div class="ms-3 text-white fs-5">
                                    <div class="btn btn-white">
                                        Pagar ahora <i class="fas fa-external-link-alt ms-2"></i>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer dark" style="cursor:pointer;">
                             
                        </div>
                    </div>
                    </a>                    
                </div>
                  
            </div>

        </div>
    </div>
</div>
<!-- Modal datos de pago Fin -->


<div class="modal fade" id="modalConfirmarPagoCliente" tabindex="-1" aria-labelledby="modalConfirmarPagoClienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="modalConfirmarPagoClienteLabel"> Confirma el pago </h5>
        <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark fa-xl"></i>
        </button>
      </div>

      <form class="" action="../app/procesa.php" method="post" enctype="multipart/form-data">
          <div class="modal-body">
                <div class="text-center">
                    <img src="assets/img/upload.jpg" class="img-fluid" style="height: 300px;" alt="">
                </div>
                <p class="text-dark text-center fw-300">Sube tu comprobante para que la tienda procese tu pedido lo antes posible.</p>
                <?php
                if (!isset($datosPedido['comprobantePago']))
                {
                    ?>
                        <p class="fw-200 small">Sólo archivos jpg, png, jpeg o pdf.</p>
                        <input type="file" class="form-control" name="fileToUpload" required>
                        <br>
                    <?php
                }

                if (isset($datosPedido))
                {
                    ?>
                    <input type="hidden" name="idCliente" value="<?php echo $datosPedido['idCliente']; ?>">
                    <input type="hidden" name="idPedido"   value="<?php echo $idPedido; ?>">
                    <?php
                }
                ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" name="btnCargaComprobante">Cargar ahora</button>
          </div>
      </form>

    </div>
  </div>
</div> 



        <?php 
            require 'src/modals.php';
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/litepicker.js"></script>    
        <script type="module" src="js/gallery-script.js"></script>

        <script>
            var designOptions = document.querySelectorAll('.design-option');
            var selectedImageContainer = document.querySelector('.selected-image');

            designOptions.forEach(function (option) {
                option.addEventListener('click', function () {
                    var selectedImage = this.querySelector('input').value;
                    selectedImageContainer.style.backgroundImage = 'url(templates/' + selectedImage + ')';
                });
            });

            function changeFont() 
            {
                var select = document.getElementById("fontSelect");
                var fontName = select.options[select.selectedIndex].value;
                var centeredTextElements = document.querySelectorAll(".centered-text");

                centeredTextElements.forEach(function(element) {
                element.style.fontFamily = fontName;
                });
            }

            function changeFontColor() 
            {
                var select = document.getElementById("colorSelect");
                var fontColor = select.options[select.selectedIndex].value;

                var centeredTextElements = document.querySelectorAll(".centered-text");

                centeredTextElements.forEach(function(element) {
                    element.style.color = fontColor;
                });
            }
            
            const inputNombreMascota = document.getElementById('inputNombreMascota');
            const inputNumeroMascota = document.getElementById('inputNumeroMascota');
            const txtNombreMascota = document.getElementById('txtNombreMascota');
            const txtNumeroMascota = document.getElementById('txtNumeroMascota');

            inputNombreMascota.addEventListener('input', function() {
                txtNombreMascota.textContent = inputNombreMascota.value;
            });

            inputNumeroMascota.addEventListener('input', function() {
                txtNumeroMascota.textContent = inputNumeroMascota.value;
            });
         
            const selectMascota = document.getElementById('selectMascota'); 

            selectMascota.addEventListener('change', function() {
                const selectedMascota = this.value;
                console.log(selectedMascota);
                 
                
            });

        </script>

    </body>
</html>
