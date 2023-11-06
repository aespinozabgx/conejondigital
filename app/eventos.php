<?php
    session_start();

    require 'php/conexion.php';
    require 'php/funciones.php';
	require 'php/lock.php';

    if (isset($_SESSION['email']))
    {
        $idUsuario = $_SESSION['email'];
    } 

    // echo "<pre>";
    // print_r($_SESSION);
    // die;

    //echo $idUsuario;
    $hasAccess = getAccesoVisitante($conn, $idUsuario, 'CN2023');

    // echo "<pre>";    
    // var_dump($hasAccess);
    // die;
    
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
        <!-- <script src="js/qrcode.js"></script> -->
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
                                            <a class="display-4 text-white fw-200 sombra-titulos-vendy text-decoration-none" href="#">
                                                Eventos
                                            </a>
                                        </div>
                                        <div class="page-header-subtitle">
                                            <span class="fw-300 text-white-75  ">
                                                Conoce los próximos eventos oficiales del Conejón
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-auto mt-4">
                                        <form class="" id="formularioFechaFiltrado" action="index.html" method="post">
                                            <div class="input-group input-group-joined border-0">
                                                <span class="input-group-text bg-transparent"><i class="text-white" data-feather="calendar"></i></span>
                                                <div class="form-control align-bottom pt-3 ps-0 fs-3 fw-600 bg-transparent text-white pointer">
                                                    <?php echo date("j M, Y"); ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="container-xl px-4 mt-n15">
                        <div class="row">
                            
                            <div class="col-xl-12 col-md-12 mb-4">
                                <div class="card shadow rounded-3 mb-4 mt-5">
                                    <div class="card-body p-5">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-6 order-md-1 mb-4" id="dos">
                                                        <img class="img-fluid rounded rounded-3" style="min-height:;" src="assets/img/banners/conejo-yv.jpg" alt="Imagen del evento" />
                                                    </div>
                                                    <div class="col-sm-6 mb-3" id="uno">
                                                        <div class="text-primary display-6 mb-3 f-poppins fw-500">Conejón Navideño 2023</div>
                                                        <div class="text-gray-600   mb-1 fs-3"><i class="far fa-calendar-alt me-1"></i> 9 y 10 de Diciembre</div>
                                                        <div class="text-gray-600   mb-5 fs-3">
                                                            <i class="fas fa-map-marker-alt me-1"></i>
                                                            <a class="text-gray-600 small" href="https://maps.app.goo.gl/R5SRP6jJLXRyz5k5A" target="_blank">
                                                                Paseo de La Reforma Nte 742, Tlatelolco, Cuauhtémoc, 06200 Ciudad de México, CDMX
                                                                <i class="ms-1" data-feather="external-link"></i>
                                                            </a>
                                                        </div>
                                                        <a class="btn btn-lg btn-outline-primary border-primary border-3 fw-500 fs-1 w-100 d-md-none mb-2" href="acceso/">
                                                            Mi acceso
                                                            <i class="fas fa-ticket-alt ms-2 fa-flip" style="--fa-animation-duration: 2s;"></i>
                                                        </a>
                                                        <a class="btn btn-lg btn-green border-green border-3 fs-1 w-100 d-md-none mb-2" href="https://maps.app.goo.gl/R5SRP6jJLXRyz5k5A" target="_blank">
                                                            Ubicación
                                                            <i class="fas fa-location-arrow ms-2"></i>
                                                        </a>
                                                        <div class="row">
                                                            <div class="col mb-2 me-1 d-none d-md-block">
                                                                <?php
                                                                    if ($hasAccess !== false)
                                                                    {
                                                                        
                                                                       
                                                                        ?>
                                                                        <a class="btn btn-lg btn-outline-primary border-primary border-3 fw-500 fs-1 w-100 h-100" href="acceso/">
                                                                            Mi acceso
                                                                            <i class="fas fa-ticket-alt ms-2 fa-flip" style="--fa-animation-duration: 2s;"></i>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <form action="procesa.php" method="POST">
                                                                            <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">                                                                        
                                                                            <button type="submit" name="btnRegistroAsistencia" class="btn btn-lg btn-danger border-danger border-3 fw-500 fs-1 w-100 h-100">
                                                                                Obtener acceso
                                                                                <i class="fas fa-ticket-alt ms-2 fa-flip" style="--fa-animation-duration: 2s;"></i>
                                                                            </button>
                                                                        </form>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="col mb-2 d-none d-md-block">
                                                                <a class="btn btn-lg btn-green border-green border-3 fs-1 w-100 h-100" href="https://maps.app.goo.gl/R5SRP6jJLXRyz5k5A" target="_blank">
                                                                    Ubicación
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
                    </div>
                </main> 
                
                <?php
                    if (file_exists('src/footer.php'))
                    {
                        require 'src/footer.php';
                    }
                ?>

            </div>
        </div>

        <?php 
            if (file_exists('src/modals.php'))
            {
                require 'src/modals.php';
            } 
        ?>

        <!-- QR PENDIENTE -->

        <script src="js/funciones.js?id=2828"></script>
        <!-- QR CODE JS -->
        <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> 
        <script src='//cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js'></script>
        <script src="js/qr-script.js?is=28"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>        
        <script src="js/scripts.js"></script> 
          
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
                document.getElementById("qrcode").innerHTML = '';            
                qrcode.clear();

                let qrcode = new QRCode(document.getElementById("qrcode"), 
                {
                    text: contenidoQR,
                    width: 250,
                    height: 250,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });       

                // qrcode.clear(); // clear the code.
                // qrcode.makeCode("http://naver.com"); // make another code.

                // document.querySelector("#qrcode img").id = "qr-image";
                // let qrImage = document.getElementById("qr-image");
                // qrImage.classList.add("img-fluid"); 
 
                // setTimeout(
                //     function ()
                //     {
                //         let dataUrl = document.querySelector('#qrcode').querySelector('img').src;
                //         var tienda = '<?php echo $_SESSION['email']; ?>';
                //         downloadURI(dataUrl, tienda + '.png');
                //     },1000
                // );
                console.log('Creado2');
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
