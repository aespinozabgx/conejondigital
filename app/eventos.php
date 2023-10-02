<?php
    session_start();

    require 'php/conexion.php';
    require 'php/funciones.php';

    if (isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
    else
    {
        $username = $_SESSION['email'];
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
    // $ventas_ganancias = getVentasGananciasTienda($conn, $idTienda, $fechaInicio, $fechaFin);
    // $total_ingresos   = getIngresosTienda($conn, $idTienda, $fechaInicio, $fechaFin);
    // $total_egresos    = getEgresosTienda($conn, $idTienda, $fechaInicio, $fechaFin);


    // Datos para gráfica por mes
    // $ventaGananciaPorMesTienda = getVentaGananciaPorMesTienda($conn, $idTienda);
    // echo "<pre>";
    // print_r($ventaGananciaPorMesTienda);
    // die;

    // $ventasMetodoDePagoTienda = getVentasMetodoDePagoTienda($conn, $idTienda, $fechaInicio, $fechaFin);
    // echo "<pre>";
    // print_r($ventasMetodoDePagoTienda);
    // die;

    // $pedidosAbiertos = obtenerPedidosAbiertos($conn, $idTienda, NULL, NULL);
    // echo "<pre>";
    // print_r($pedidosAbiertos);
    // die;

    // $estatusCaja = isTurnoCajaActivo($conn, $idTienda, $idUsuario);
    // echo "<pre>";
    // var_dump($estatusCaja);
    // die;

    // $hasActivePayment = validarPagoActivo($conn, $idTienda);
    // echo "<pre>";
    // var_dump($hasActivePayment);
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
        <title>Conejón Digital</title> 
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css?id=3328" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/qrcode.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

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
                    <header class="page-header page-header-dark bg-indigo pb-9">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                            
                                        <div>
                                                                                        
                                            <a class="display-6 text-white fw-200 sombra-titulos-vendy text-decoration-none">
                                                <?php
                                                    
                                                ?>
                                                Eventos
                                            </a> 

                                        </div>
                                        <div class="page-header-subtitle">
                                            <div class="">
                                                <span class="fw-300 text-white-75 small">                                                 
                                                    Conoce los próximos eventos oficiales del Conejón                                                 
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
                    <div class="container-xl px-4 mt-n15">
                        
                        <div class="row">
                            <div class="col-xl-12 col-md-12 mb-4">
                                <div class="">
                                <div class="card card-waves shadow rounded-1 mb-4 mt-5">
                            <div class="card-body p-5">
                                <div class="row align-items-center justify-content-between">
                                  <div class="container">
                                    
                                    <div class="row">
                                        <!-- Contenedor 2 para dispositivos móviles (orden primero) -->
                                        <div class="col-sm-4 order-md-2 rounded-2 mb-3" id="dos">
                                            <img class="img-fluid px-xl-4 rounded-2" src="assets/img/banners/conejo-yv.jpg?id=28" />
                                        </div>
                                        
                                        <!-- Contenedor 1 (texto y botones) -->
                                        <div class="col-sm-8 mb-3" id="uno">
                                            <h2 class="text-primary display-6 fw-500">Conejón Navideño 2023</h2>
                                            <p class="text-gray-700">
                                                <!-- Contenido de texto aquí -->
                                                <p class="text-gray-700">
                                          <div class="text-gray-600 small mb-1 fs-3"><i class="far fa-calendar-alt me-1"></i> 9 y 10 de Diciembre</div>
                                          <div class="text-gray-600 small mb-5 fs-3"><i class="fas fa-map-marker-alt me-1"></i>
                                            <a class="text-gray-600 small" href="https://maps.app.goo.gl/R5SRP6jJLXRyz5k5A" target="_blank">
                                                Paseo de La Reforma Nte 742, Tlatelolco, Cuauhtémoc, 06200 Ciudad de México, CDMX
                                                <i class="ms-1" data-feather="external-link"></i>
                                            </a>
                                          </div>
                                        </p>   
                                            </p>

                                            <!-- Botón 1 para dispositivos móviles -->
                                            <a class="btn btn-primary p-3 mb-1 w-100 d-md-none" data-bs-toggle="modal" data-bs-target="#modalCredencialEvento" onclick="makeCodeUrlPago('<?php echo $_SESSION['email']; ?>');">
                                                Mi acceso
                                                <i class="fas fa-ticket-alt ms-2"></i>
                                            </a>

                                            <!-- Botón 1 para dispositivos medianos y grandes -->
                                            <a class="btn btn-primary p-3 mb-1 me-1 d-none d-md-inline" data-bs-toggle="modal" data-bs-target="#modalCredencialEvento" onclick="makeCodeUrlPago('<?php echo $_SESSION['email']; ?>');">
                                                Mi acceso
                                                <i class="fas fa-ticket-alt ms-2"></i>
                                            </a>

                                            <!-- Botón 2 para dispositivos móviles -->
                                            <a class="btn btn-green p-3 mb-1 w-100 d-md-none" href="https://maps.app.goo.gl/R5SRP6jJLXRyz5k5A" target="_blank">
                                                ¿Cómo llegar?
                                                <i class="fas fa-location-arrow ms-2"></i>
                                            </a>

                                            <!-- Botón 2 para dispositivos medianos y grandes -->
                                            <a class="btn btn-green p-3 mb-1 d-none d-md-inline" href="https://maps.app.goo.gl/R5SRP6jJLXRyz5k5A" target="_blank">
                                                ¿Cómo llegar?
                                                <i class="fas fa-location-arrow ms-2"></i>
                                            </a>
                                            
                                        </div>
                                    </div>

                                </div>


                                 
                                </div>
                            </div>
                        </div>                 
                                </div>
                            </div>
                        </div> 

                                          

                    </div>

                </main>

                <script src="js/funciones.js?id=2828"></script>
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
         
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>        
        <script src="js/scripts.js"></script> 
        <script type="text/javascript">

            // Obtener los datos de ventas y ganancias desde PHP
            <?php
                // Ganancias y ventas
                $meses = array(1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic");
                
            ?> 

        </script>  
        <script type="text/javascript">            

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
                // Limpia el contenido del contenedor (elimina cualquier código QR anterior)
                let qrcodeContainer = document.getElementById("qrcode").innerHTML = '';            
                
                let qrcode = new QRCode(document.getElementById("qrcode"), 
                {
                    text: contenidoQR,
                    width: 250,
                    height: 250,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });        

                document.querySelector("#qrcode img").id = "qr-image";
                let qrImage = document.getElementById("qr-image");
                qrImage.classList.add("img-fluid"); 
 
                // setTimeout(
                //     function ()
                //     {
                //         let dataUrl = document.querySelector('#qrcode').querySelector('img').src;
                //         var tienda = '<?php echo $_SESSION['email']; ?>';
                //         downloadURI(dataUrl, tienda + '.png');
                //     },1000
                // );
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
