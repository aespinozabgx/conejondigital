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


    $hasActivePayment = Array();
    $hasActivePayment['existePagoActivo']  = 1;

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

    $registrosNoComprados = obtenerGafetesNoComprados($conn, $idUsuario);
    // echo "<pre>";
    // print_r($registrosNoComprados);
                                                        
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
        <link href="css/styles.css?id=28" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
        <!-- <script src="js/qrcode.js"></script> -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <style type="text/css">
 
            input[type=radio]
            {
                -ms-transform: scale(1.3); /* IE */
                -moz-transform: scale(1.3); /* FF */
                -webkit-transform: scale(1.3); /* Safari and Chrome */
                -o-transform: scale(1.3); /* Opera */
                transform: scale(1.3);
                padding: 15px;
                margin-right: 5px;
            }
            
            /* CSS para fondo negro */
            .modal-fullscreen .modal-content 
            {
                backdrop-filter: blur(10px);
                background-color: rgba(146, 137, 137, 0.274);
                color: #fff; /* Color del texto en el modal */
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

            .design-option 
            {
                display: inline-block;
                margin-right: 10px;
            }

            .design-option img 
            {
                width: 130px;
                height: 130px;
                border: 2px solid #ccc;
                cursor: pointer;                
                border-radius: 50%;
            }
        
            /* Estilo para la imagen cuando su radio está seleccionado */
            .design-option input:checked + img 
            {
                border: 4px solid rgb(37, 60, 193); /* Puedes personalizar el borde como desees */
            }

            /* Estilo para el contenedor de la imagen cuando su radio está seleccionado */
            .design-option input:checked + img + label 
            {
                /* Puedes aplicar estilos adicionales al contenedor, por ejemplo, cambiar el fondo */
                background-color: lightgray;
            }

            .whatsapp-btn 
            {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1; 
                background-color: #25D366;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                animation: breathe 2s ease-in-out infinite;
            }

            /*Estilos solo al icono whatsapp*/
            .whatsapp-btn i 
            {
                color: #fff;
                font-size: 24px;
                animation: beat 2s ease-in-out infinite;
                text-decoration: none;
            }

            /*Estilos con animation contorno respirando*/
            @keyframes breathe 
            {
                0% {
                    box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.5);
                }
                70% {
                    box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
                }
            }

            /*Estilos de animacion del icono latiendo*/
            @keyframes beat 
            {
                0% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.2);
                }
                100% {
                    transform: scale(1);
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
                                                ¡Personaliza tu entrada!
                                            </a>
                                        </div>
                                        <div class="page-header-subtitle">
                                            <span class="fw-300 text-white-75  ">
                                                Elige tu diseño favorito, carga tu foto y envía tu comprobante.
                                            </span>
                                        </div>
                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                    </header>
                    
                    <div class="container-xl px-4 mt-n15">
                        <div class="row">                            
                            <div class="col-xl-12 col-md-12 mb-4">
                                <div class="card shadow rounded-3 mb-4 mt-5">
                                    <div class="card-body py-5">

                                        <div class="row align-items-center justify-content-between">
                                            <form action="procesa.php" method="post" enctype="multipart/form-data">                                            
                                                <div class="container">
                                                    
                                                    <div class="text-primary display-6 mb-3 f-poppins fw-500">
                                                        <i class="fas fa-palette me-2"></i> Selecciona tu diseño favorito
                                                    </div>
                                                    <div class="row mb-3">                                                    

                                                        <div class="col mb-3" id="disenos">                                                                                                                    
                                                                <label class="design-option rounded rounded-3 mb-2">
                                                                    <input type="radio" required name="disenoGafete" value="1.jpg">
                                                                    <img src="assets/img/gafete/disenos/1.jpg" alt="1.jpg">
                                                                </label>   
                                                        </div>
                                                        <div class="col mb-3" id="disenos">                                                                                              
                                                                <label class="design-option rounded rounded-3 mb-2">
                                                                    <input type="radio" name="disenoGafete" value="2.jpg">
                                                                    <img src="assets/img/gafete/disenos/2.jpg" alt="2.jpg">
                                                                </label>
                                                        </div>
                                                        <div class="col mb-3" id="disenos">
                                                                <label class="design-option rounded rounded-3 mb-2">
                                                                    <input type="radio" name="disenoGafete" value="3.jpg">
                                                                    <img src="assets/img/gafete/disenos/3.jpg" alt="3.jpg">
                                                                </label>
                                                        </div>
                                                        <div class="col mb-3" id="disenos">
                                                                <label class="design-option rounded rounded-3 mb-2">
                                                                    <input type="radio" name="disenoGafete" value="4.jpg">
                                                                    <img src="assets/img/gafete/disenos/4.jpg?id=0" alt="4.jpg">
                                                                </label>
                                                        </div>
                                                        
                                                        <div class="col mb-3" id="disenos">
                                                            <label class="design-option rounded rounded-3 mb-2">
                                                                <input type="radio" required name="disenoGafete" value="5.jpg">
                                                                <img src="assets/img/gafete/disenos/5.jpg" alt="5.jpg">
                                                            </label>
                                                        </div>

                                                        <div class="col mb-3" id="disenos">
                                                            <label class="design-option rounded rounded-3 mb-2">
                                                                <input type="radio" required name="disenoGafete" value="6.jpg">
                                                                <img src="assets/img/gafete/disenos/6.jpg" alt="6.jpg">
                                                            </label>
                                                        </div>


                                                    </div>
                                                    
                                                    <div class="text-primary display-6 mb-3 f-poppins fw-500">
                                                        <i class="fas fa-cloud-upload-alt me-2"></i> Sube tu foto favorita
                                                    </div>
                                                    <div class="row mb-3">
                                                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
                                                    </div>

                                                    <div class="row">
                                                        <button type="submit" name="btnGafeteCarrito" class="w-100 btn btn-primary btn-lg fs-4 fw-500">Siguiente</button>
                                                    </div>

                                                   
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <?php
                                            //if (!empty($registrosNoComprados)) 
                                            if (1)
                                            {
                                                ?>
                                                <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#modalFullscreen" class="btn rounded-pill whatsapp-btn text-white btn-lg fs-4">
                                                    <i class="fas fa-shopping-bag me-2"></i>
                                                    <?php echo sizeof($registrosNoComprados); ?>                                                                
                                                </a>

                                                <!-- Modal de Pantalla Completa -->
                                                <div class="modal fade" id="modalFullscreen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-fullscreen">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title text-white f-poppins" id="exampleModalLabel">
                                                                    <i class="fas fa-shopping-cart me-1"></i> Carrito de compras
                                                                </h3>
                                                                <button type="button" class="btn btn-icon btn-sm btn-outline-white fs-6" data-bs-dismiss="modal" aria-label="Cerrar">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Contenido largo que requerirá desplazamiento -->
                                                                <div class="p-1">
                                                                    
                                                                    <?php
                                                                    if (!empty($registrosNoComprados)) 
                                                                    {
                                                                        ?>                                                                                                                                    
                                                                        <div class="table-responsive rounded rounded-1">
                                                                            <table class="table table-stripped table-bordered">
                                                                                <thead class="">
                                                                                    <tr class="text-white"> 
                                                                                        <th class="bg-yellow fs-4">Producto</th>
                                                                                        <th class="bg-yellow fs-4">Foto</th>
                                                                                        <th class="bg-yellow fs-4">Diseño</th>
                                                                                        <th class="bg-yellow fs-4">Precio</th>
                                                                                        <th class="bg-yellow fs-4 text-center">Acciones</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="text-white">
                                                                                    <?php
                                                                                        $i = 0;
                                                                                        // $registrosNoComprados contiene los productos del carrito
                                                                                        foreach ($registrosNoComprados as $producto) 
                                                                                        {
                                                                                            ?>
                                                                                            <tr class="text-center align-middle"> 
                                                                                                <td>Lanyard personalizado</td>
                                                                                                <td>
                                                                                                    <img src="gafetes/users/<?php echo $_SESSION['email'] . '/' . $producto['nombre_archivo']; ?>" 
                                                                                                        class="bg-white rounded-img" alt="<?php echo $producto['nombre_archivo']; ?>">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <img src="assets/img/gafete/disenos/<?php echo $producto['diseno']; ?>" 
                                                                                                        class="rounded-img" alt="<?php echo $producto['diseno']; ?>">
                                                                                                </td>
                                                                                                <td class="align-middle">
                                                                                                    $ 100.00 mxn
                                                                                                </td>
                                                                                                <td class="text-center align-middle">
                                                                                                    <form action="procesa.php" method="POST">
                                                                                                        <input type="hidden" name="idToDelete" id="" value="<?php echo $producto['id']; ?>" required>
                                                                                                        <button class="btn btn-icon btn-outline-white" type="submit" name="btnBorrarLanyardDB">
                                                                                                            <i class="far fa-trash-alt"></i>
                                                                                                        </button>
                                                                                                    </form>                                                                                                        
                                                                                                </td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    ?>
                                                                                </tbody>                                                                                        
                                                                            </table>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "<div class='text-center fs-1' style='padding-top:10%;'>Aún no hay registros, personaliza tu acceso</div>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <!-- Puedes agregar más contenido según sea necesario -->
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-between">
                                                                <div class="col fs-3 fw-500 text-start">
                                                                    <?php
                                                                        $subtotal = sizeof($registrosNoComprados) * 100;
                                                                        $formattedSubtotal = '$ ' . number_format($subtotal, 2);
                                                                        echo $formattedSubtotal;
                                                                    ?>
                                                                </div>
                                                                <div class="col-lg-2 col-sm-6">
                                                                    <a href="pago.php" class="btn btn-lg btn-light rounded-pill w-100 fs-4">
                                                                        <i class="fas fa-coins me-2 fa-flip" style="--fa-animation-duration: 3s;"></i> Pagar
                                                                    </a>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>

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
          
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>        
        <script src="js/scripts.js"></script>

        <?php

            if (file_exists('src/triggers.php'))
            {
                require 'src/triggers.php';
            }

        ?>
    </body>
</html>