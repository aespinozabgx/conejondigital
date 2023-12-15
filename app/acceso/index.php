<?php

    session_start();
    
    require '../php/conexion.php';
    require '../php/funciones.php';

    // LOCK
    if (!isset($_SESSION['email']) || empty($_SESSION['email']))
    {
        //die('No puedes estar aquí');
        exit(header('Location: ../../login.php?msg=requiereSesion'));
    }
    // END LOCK

    if (!isset($_SESSION['email']) || empty($_SESSION['email']))
    {
        //die('No puedes estar aquí');
        exit(header('Location: ../../login.php?msg=requiereSesion'));
    }

    $idUsuario = $_SESSION['email'];
    $hasAccess = getAccesoVisitante($conn, $idUsuario, 'CN2023');

    if (!$hasAccess) 
    {
        exit(header('Location: ../eventos.php?msg=requieresAcceso'));
    }

    // var_dump($hasAccess);
    // die;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Acceso Conejón Digital</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
        
        <!-- Custom Google font-->    
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css?id=2828" rel="stylesheet" />

        <!-- AOS CSS -->
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

        <script src="../js/qrcode.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

        <style>

            @import url('https://fonts.googleapis.com/css2?family=Lobster&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&display=swap');

            .f-lobster
            {
                font-family: 'Lobster', sans-serif;
            }
            
            .f-lobster2
            {
                font-family: 'Lobster Two', sans-serif;
            }

            .f-lobster2italic
            {
                font-family: 'Lobster Two', cursive;
                font-style: italic;
            }

            .rabbit 
            {
                width: 5em;
                height: 3em;
                background: #ffffff;
                border-radius: 70% 90% 60% 50%;
                position: relative;
                box-shadow: -0.2em 1em 0 -0.75em #b78e81;
                -moz-transform: rotate(0deg) translate(-2em, 0);
                -ms-transform: rotate(0deg) translate(-2em, 0);
                -webkit-transform: rotate(0deg) translate(-2em, 0);
                transform: rotate(0deg) translate(-2em, 0);
                animation: hop 1s infinite linear;
                z-index: 1;
            }

            .typed-cursor 
            {
                opacity: 0; /* Oculta el cursor cambiando su opacidad a 0 */
                display: none; /* También puedes ocultar el cursor configurándolo en "none" */
            }

            .no-flexbox .rabbit 
            {
                margin: 10em auto 0;
            }

            .rabbit:before 
            {
                content: "";
                position: absolute;
                width: 1em;
                height: 1em;
                background: white;
                border-radius: 100%;
                top: 0.5em;
                left: -0.3em;
                box-shadow: 4em 0.4em 0 -0.35em #3f3334, 0.5em 1em 0 white, 4em 1em 0 -0.3em white, 4em 1em 0 -0.3em white, 4em 1em 0 -0.4em white;
                animation: kick 1s infinite linear;
            }

            .rabbit:after 
            {
                content: "";
                position: absolute;
                width: .75em;
                height: 2em;
                background: white;
                border-radius: 50% 100% 0 0;
                -moz-transform: rotate(-30deg);
                -ms-transform: rotate(-30deg);
                -webkit-transform: rotate(-30deg);
                transform: rotate(-30deg);
                right: 1em;
                top: -1em;
                border-top: 1px solid #f7f5f4;
                border-left: 1px solid #f7f5f4;
                box-shadow: -0.5em 0em 0 -0.1em white;
            }

            .clouds 
            {
                background: white;
                width: 2em;
                height: 2em;
                border-radius: 100% 100% 0 0;
                position: relative;
                top: -5em;
                filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
                opacity: 0;
                -moz-transform: translate(0, 0);
                -ms-transform: translate(0, 0);
                -webkit-transform: translate(0, 0);
                transform: translate(0, 0);
                animation: cloudy 1s infinite linear forwards;
                box-shadow: 5em 2em 0 -0.3em white, -2em 2em 0 0 white;
            }

            .clouds:before, .clouds:after 
            {
                content: '';
                position: absolute;
                box-shadow: 5em 2em 0 -0.3em white, -2em 2em 0 white;
            }

            .clouds:before 
            {
                width: 1.25em;
                height: 1.25em;
                border-radius: 100% 100% 0 100%;
                background: white;
                left: -30%;
                bottom: 0;
            }

            .clouds:after 
            {
                width: 1.5em;
                height: 1.5em;
                border-radius: 100% 100% 100% 0;
                background: white;
                right: -30%;
                bottom: 0;
            }

            @keyframes hop {
            20% {
                -moz-transform: rotate(-10deg) translate(1em, -2em);
                -ms-transform: rotate(-10deg) translate(1em, -2em);
                -webkit-transform: rotate(-10deg) translate(1em, -2em);
                transform: rotate(-10deg) translate(1em, -2em);
                box-shadow: -0.2em 3em 0 -1em #b78e81;
            }
            40% {
                -moz-transform: rotate(10deg) translate(3em, -4em);
                -ms-transform: rotate(10deg) translate(3em, -4em);
                -webkit-transform: rotate(10deg) translate(3em, -4em);
                transform: rotate(10deg) translate(3em, -4em);
                box-shadow: -0.2em 3.25em 0 -1.1em #b78e81;
            }
            60%,75% {
                -moz-transform: rotate(0) translate(4em, 0);
                -ms-transform: rotate(0) translate(4em, 0);
                -webkit-transform: rotate(0) translate(4em, 0);
                transform: rotate(0) translate(4em, 0);
                box-shadow: -0.2em 1em 0 -0.75em #b78e81;
            }
            }

            @keyframes kick {
            20%,50% {
                box-shadow: 4em 0.4em 0 -0.35em #3f3334, 0.5em 1.5em 0 white, 4em 1.75em 0 -0.3em white, 4em 1.75em 0 -0.3em white, 4em 1.9em 0 -0.4em white;
            }
            40% {
                box-shadow: 4em 0.4em 0 -0.35em #3f3334, 0.5em 2em 0 white, 4em 1.75em 0 -0.3em white, 4.2em 1.75em 0 -0.2em white, 4.4em 1.9em 0 -0.2em white;
            }
            }

            @keyframes cloudy 
            {
                40% 
                {
                    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=75);
                    opacity: 0.75;
                    -moz-transform: translate(-3em, 0);
                    -ms-transform: translate(-3em, 0);
                    -webkit-transform: translate(-3em, 0);
                    transform: translate(-3em, 0);
                }
                
                55% 
                {
                    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
                    opacity: 0;
                    -moz-transform: translate(-4em, 0);
                    -ms-transform: translate(-4em, 0);
                    -webkit-transform: translate(-4em, 0);
                    transform: translate(-4em, 0);
                }
                
                90% 
                {
                    -moz-transform: translate(0, 0);
                    -ms-transform: translate(0, 0);
                    -webkit-transform: translate(0, 0);
                    transform: translate(0, 0);
                }
            }

            .sombra-titulo 
            {
                text-shadow: 2px 2px 0px rgba(82, 73, 73, 0.68);
                transition: text-shadow 0.3s ease; /* Agrega transición a text-shadow */
            }

            .sombra-btn 
            {
                text-shadow: 2px 2px 0px rgba(174, 77, 77, 0.68);
                transition: text-shadow 0.3s ease; /* Agrega transición a text-shadow */
            }

            .sombra-btn:hover 
            {
                text-shadow: 0px 0px 0px rgba(174, 77, 77, 0.68);
            }

            #qrcode img
            {
                width: 100%;
                height: auto;
            }

        </style>
    </head>
    <body class="d-flex flex-column h-100 bg-light">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container px-5">
                    <a class="navbar-brand" href="../eventos.php">
                        <span class="fw-bolder text-primary">
                            <i class="fas fa-arrow-circle-left me-2"></i>
                            Regresar
                        </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">                                                        
                            <li class="nav-item"><a class="nav-link" target="_blank" href="https://api.whatsapp.com/send?phone=5215610346590&text=Hola,%20requiero%20soporte%20de%20mi%20cuenta%20conejondigital.com"><i class="fas fa-headset me-1"></i> Soporte</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page Content-->
            <div class="container px-5 mt-5">
                
                <div class="text-center mb-3 display-5 fw-bolder" data-aos="fade-up">
                    <div id="salida-typewrite-acceso" class="text-gradient d-inline mb-0"></div>🥳
                </div>
                <div class="text-center mb-3" data-aos="fade-up">
                    <div id="segundo-texto" class="text-gradient d-inline display-6 fw-bolder mb-0"></div>
                </div>

                <div class="row gx-5 justify-content-center" data-aos="fade-up">
                    <div class="col-lg-11 col-xl-9 col-xxl-8">
                        
                        <!-- Experience Section-->                        
                        <section>

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                
                                <!-- Download resume button-->
                                <!-- Note: Set the link href target to a PDF file within your project-->
                                <!-- <a class="btn btn-primary px-4 py-3" href="#!">
                                    <div class="d-inline-block bi bi-download me-2"></div>
                                    Download Resume
                                </a> -->
                            </div>

                            <!-- Experience Card 1-->
                            <div class="card shadow border-0 rounded-4 mb-3">
                                <div class="card-body p-4">
                                    <div class="row align-items-center gx-4">
                                        
                                        <div class="col text-center text-lg-start mb-4 mb-lg-0">
                                            <div class="bg-light p-0 shadow-lg rounded-4">
                                                <!-- <div class="text-primary fs-4 text-center fw-bolder mb-2">Axel Espinoza</div> -->
                                                <div class="p-2 rounded-3 bg-white d-flex justify-content-center">
                                                    <div id="qrcode"></div>                                                    
                                                </div>                                        
                                            </div>
                                        </div>

                                        <div class="col-lg-8">
                                            <div class="">
                                                
                                                <h2 class="text-primary fw-bolder mb-4">Conejón Navideño 2023</h2>
                                                
                                                <div class="">
                                                    
                                                    <div class="text-dark fs-5 mb-2">
                                                        <i class="far fa-user me-2"></i> <?php echo $_SESSION['nombre']; ?>
                                                    </div>

                                                    <div class="text-dark fs-5 mb-2">
                                                        <i class="far fa-calendar-alt me-2"></i> 9 y 10 de Diciembre
                                                    </div>

                                                    <div class="text-dark fs-5 mb-2">
                                                        <i class="fas fa-map-marker me-2" style="color: rgba(69, 66, 65, 0.736);"></i>
                                                        <a class="text-gray-600" style="text-decoration: none;" href="https://maps.app.goo.gl/R5SRP6jJLXRyz5k5A" target="_blank">
                                                            Paseo de La Reforma Nte 742, Tlatelolco, Cuauhtémoc, CP 06200, Ciudad de México, CDMX <i class="fas fa-external-link-square-alt ms-1"></i>
                                                        </a>
                                                    </div>

                                                </div>

                                                <div class="text-dark ">

                                                </div>

                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> 

                            <!-- <div class="card shadow border-0 rounded-4 mb-5">
                                <div class="card-body p-4 mt-2">
                                    <div class="row align-items-center gx-4">
                                        
                                        <div class="col">
                                            <div class="text-center">
                                                
                                                <div class="fw-300 mb-5 display-4 px-2" style="color: #6091e6;">
                                                    <span class="f-lobster2italic fw-bold display-2 text-nowrap">Personaliza</span> <i class="fas fa-hand-sparkles me-2 ms-2"></i> tu acceso 
                                                </div>                                                                                            
                                                
                                                <div class="mb-3">
                                                    <img src="assets/gafete.jpg" class="img-fluid" style="" alt="">                                                    
                                                </div>
                                                
                                                <div class="mb-3 fw-300 small text-danger">
                                                    Piezas limitadas
                                                </div>
                                                
                                                <div class="text-dark ">
                                                    <a href="../disenaGafete.php" class="btn btn-primary btn-lg w-100 p-3 fs-2 fw-bold fa-fade" style="--fa-animation-duration: 3s; --fa-fade-opacity: 0.6;">
                                                        ¡Lo quiero! 🐇
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>  -->

                        </section>
 
                        <!-- Divider-->
                        <div class="pb-5"></div> 
                       
                    </div>
                </div>

                <div class="gx-2" data-aos="fade-up">
                    <div class="mb-2">
                        <div class="d-flex align-items-center mb-4">                                        
                            <h3 class="fw-bolder text-gradient display-5 f-poppins mb-0"><span class="d-inline">Registra tu cheñol</span></h3>
                        </div>                                     
                    </div>
                    <section>
                        <!-- Skillset Card-->
                        <div class="container rounded-3" style="background-color: #e2b29f;">
                            <div class="row">
                                <div class="col-lg-4 col-12 mt-5">
                                    <div class="p-4 mt-5">
                                        <div class="d-flex justify-content-center">
                                            <div class="rabbit"></div>
                                            <div class="clouds"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-12 col-sm-12 p-4 text-center">
                                    <div class="mb-4">
                                        <h2 class="fs-2 mt-2 text-white" style="text-shadow: 1px 1px 1px rgb(161, 152, 152);">
                                            Registra a tus peluditos para el collage del 
                                        </h2>
                                        <h1 class="text-white display-5  fw-bold" style="text-shadow: 3px 3px 3px rgb(226, 104, 104);">
                                            Conejón Navideño 2023🎄
                                        </h1>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-center">
                                        <div class="col-lg-6 col-sm-12 col-xs-12">
                                            <a 
                                            href="../mis-conejos.php" 
                                            class="btn btn-outline-light border border-white border-2 w-100 btn-lg px-5 py-3 fs-3 fw-bold f-bangers fa-fade" 
                                            style="--fa-animation-duration: 1s; --fa-fade-opacity: 0.6;">
                                                Registrar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                             
                    </section>
                </div>                
            </div>
        </main>
 
        <div class="px-5 mx-2">
            <!-- Footer-->
            <?php
                include "../../app/src/footer.php";
            ?>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="modalComprarGafete" tabindex="-1" aria-labelledby="modalComprarGafeteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="procesa.php" method="post">
            
                        <div class="modal-header">
                            <h5 class="modal-title text-success fw-600">
                                <i class="fas fa-paint-brush me-1"></i> Diseña una plaquita
                            </h5>
                            <button type="button" class="btn btn-icon btn-outline-primary btn-sm" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark fa-xl"></i>
                            </button>
                        </div>
        
                        <div class="modal-body">
                        
                            <div class="mb-2">
                                <label for="mascota" class="text-primary fw-600 fs-6">Forma de la plaquita:</label>
                                <select id="selectMascota" name="mascota" class="form-select fs-4 shadow-none border border-3" required>
                                    <option value="">Seleccionar</option>
                                    <option value="perro">Hueso</option>
                                    <option value="gato">Gato</option>
                                </select>
                            </div>
        
                            <div class="mb-2">
                                <div class="text-primary fw-600 fs-6 mb-2">Selecciona un diseño:</div>                
                                
                                <div id="design-options-container d-flex justify-content-center">
                                    <?php
                                        $dir = 'templates/';
                                        $files = scandir($dir);
                                        foreach ($files as $file) 
                                        {
                                            if ($file !== '.' && $file !== '..' ) 
                                            {
                                                echo '<label class="design-option rounded rounded-3 ">';
                                                echo '<input type="radio" required name="diseno" value="' . $file . '">';
                                                echo '<img src="templates/' . $file . '" alt="' . $file . '">';
                                                echo '</label>';
                                            }
                                        }
                                    ?>
                                </div>                                            
                                
                                <div id="selected-image-container" style="">
                                    <div class="selected-image rounded rounded-3 mb-2">                                 
                                        <div id="txtNombreMascota" style="font-family: poppins; color: pink" class="centered-text d-flex justify-content-center align-items-center display-4 mt-3">
                                            <?php
                                            if (isset($generalesMascota['nombre']) && !empty($generalesMascota['nombre'])) 
                                            {
                                                echo $generalesMascota['nombre'];
                                            }
                                            else
                                            {
                                                echo "Nombre Mascota";
                                            }
                                            ?>
                                        </div>
                                        
                                        <div id="txtNumeroMascota" style="font-family: poppins; color: pink" class="centered-text d-flex justify-content-center align-items-center display-4 mt-2">
                                            55 888 33 28
                                        </div>
                                       
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="" class="text-primary fw-600 fs-6">Nombre mascota:</label>
                                        <input type="text" name="nombreMascota" id="inputNombreMascota" class="form-control mt-2 fs-4 shadow-none border border-3" value="<?php echo isset($generalesMascota['nombre']) ? $generalesMascota['nombre'] : ''; ?>" placeholder="Nombre Mascota" required>
        
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="" class="text-primary fw-600 fs-6">Teléfono principal:</label>
                                        <input type="text" name="numeroMascota" id="inputNumeroMascota" placeholder="55 28 888 33 28" class="form-control fs-4 mt-2 shadow-none border border-3" required>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="" class="text-primary fw-600 fs-6">Tipo de fuente</label>
                                        <select id="fontSelect" name="tipoFuente" class="form-select w-100 fs-4 shadow-none border border-3" onchange="changeFont()" required>
                                            <option value="">Seleccionar</option>
                                            <option value="bangers">Bangers</option>
                                            <option value="bebas">Bebas</option>
                                            <option value="belanosina">Belanosina</option>
                                            <option value="permanentmarker">Permanentmarker</option>
                                            <option value="poppins" selected>Poppins</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="" class="text-primary fw-600 fs-6">Color del texto</label>
                                        <select id="colorSelect" name="colorTexto" class="form-select w-100 fs-4 shadow-none border border-3" onchange="changeFontColor()" required>
                                            <option value="">Seleccionar</option>                                    
                                            <option value="yellow" selected>Amarillo</option>
                                            <option value="white">Blanco</option>
                                            <option value="black">Negro</option>
                                            <option value="red">Rojo</option>
                                            <option value="pink" selected>Rosa</option>
                                            <option value="blue">Azul</option>
                                            <option value="green">Verde</option> 
                                        </select>
                                    </div>
                                </div>
                        
                            </div>                                        
                            <div class="mb-2 text-center fw-300 text-success small px-3">
                                Ajustaremos el diseño final, la previsualización es sólo una guía para seleccionar los elementos solicitados, recuerda que los colores puede variar al momento de realizar la placa.
                            </div>
                        </div>
                        <div class="modal-footer">                    
                            <!-- <button type="button" class="btn btn-success" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalDisenadorPlaquita">Diseñar plaquita <i class="fas fa-paw ms-2"></i></button> -->
                            <button type="submit" class="btn btn-primary rounded-3 fs-4" name="btnOrdenarPlaquita">Agregar <i class="fas fa-shopping-cart ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        
        <script>
            
            // Obtener el contenido de la variable de sesión 'email' desde PHP
            var email = '<?php echo $_SESSION['email']; ?>';
        
            // Crear un nuevo objeto QRCode
            var qrcode = new QRCode(document.getElementById("qrcode"), 
            {
                text: email,
                width: 250,
                height: 250
            });

            var qrCodeImage = document.querySelector("#qrcode img");
            qrCodeImage.classList.add("img-fluid");

            document.addEventListener("DOMContentLoaded", function () 
            {
                var optionsFelicidades = 
                {
                    strings: ["¡Felicidades!"],
                    typeSpeed: 100,
                    onComplete: function () {
                        animarSegundoTexto();
                    },
                };

                var typedFelicidades = new Typed("#salida-typewrite-acceso", optionsFelicidades);

                function animarSegundoTexto() 
                {
                    var optionsSegundoTexto = 
                    {
                        strings: ["Ya tienes tu acceso"],
                        typeSpeed: 100,
                    };

                    var typedSegundoTexto = new Typed("#segundo-texto", optionsSegundoTexto);
                }
            });

        </script>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
        
    </body>
</html>
