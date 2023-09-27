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

    // if (isset($_SESSION['email']))
    // {
        
    //     if (isset($_SESSION['managedStore']))
    //     {
    //         $idTienda = $_SESSION['managedStore'];
    //     }

    //     $sql    = "SELECT count(*) AS conteo FROM productos WHERE idTienda = '$idTienda' AND isActive = 1";
    //     $result = mysqli_query($conn, $sql);
    //     $row    = mysqli_fetch_assoc($result);
    //     $totalProductos = $row['conteo'];
    //     $idUsuario = $_SESSION['email'];
    // }

     

    

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
                                              ¡Hola, <?php echo ucwords(strtolower($_SESSION['nombre'])); ?>!
                                            </a> 

                                        </div>
                                        <div class="page-header-subtitle">
                                            <div class="">
                                                <span class="fw-500 text-white-75 small">
                                                    Bienvenido(a) de vuelto al Conejón Digital
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
                            <div class="col-xl-12 col-md-12 mb-4">
                                <div class="">
                                    <div id="carouselExampleInterval" class="carousel carousel-dark slide carousel-fade" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            
                                            <div class="carousel-item active" data-bs-interval="6000">
                                                <a href="../"><img src="assets/img/banners/1.jpg" class="d-block w-100 rounded-3" alt="..."></a>
                                            </div>

                                            <div class="carousel-item" data-bs-interval="4000">
                                                <a href="#"><img src="assets/img/banners/2.jpg" class="d-block w-100 rounded-3" alt="..."></a>
                                            </div>
                                             
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>                
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-lg-6 col-xl-6 mb-4">
                                <div class="card bg-success text-white h-100 gradient-red ">
                                    <div class="card-body ">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">¿Qué esperas?</div>
                                                <div class="fs-2 fw-500">
                                                    ¡Registra a tu <b>Cheñol!</b>
                                                </div>
                                            </div>
                                            <span class="material-symbols-outlined text-white-75" style="font-size: 3em;">
                                                cruelty_free
                                            </span>
                                            <!-- <i class="fas fa-bullhorn"></i> -->
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <!-- <a class="text-white stretched-link" href="#!">Configurar catálogo</a> -->
                                        <div class="input-group ">
                                            
                                            <a class="btn btn-outline-white w-100 fs-4" href="setup_tienda.php">                                                
                                                Registrar
                                            </a>
                                            

                                            <!-- <input type="text" style="cursor: pointer;" onClick="javascript: copiarPortapapeles();" id="myInput" class="form-control form-control-sm bg-success text-white" name="urlPerfil" value="https://mayoristapp.mx/perfil.php?tienda=<?php echo $username; ?>" readonly> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-xl-6 mb-4">
                                <div class="card bg-yellow text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Próximos eventos</div>
                                                <div class="display-6 fw-500">
                                                    1
                                                </div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="calendar"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                            
                                        <a class="text-white stretched-link" href="mis-ventas.php">Ver eventos  </a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.umd.js" integrity="sha512-vCUbejtS+HcWYtDHRF2T5B0BKwVG/CLeuew5uT2AiX4SJ2Wff52+kfgONvtdATqkqQMC9Ye5K+Td0OTaz+P7cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>        

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
            var ctx = document.getElementById('myBarChart').getContext('2d');
            var myBarChart = new Chart(ctx, config);

 

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
                        downloadURI(dataUrl, 'vendyQR_' + tienda + '.png');
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
