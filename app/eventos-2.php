<?php
  session_start();

  if (!isset($_SESSION['email']) && !isset($_SESSION['nombre']))  
  {
    ?>
    <a href="../login.php">Iniciar sesión</a>
    <?php
  }

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Conejón Digital</title>
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
                            <div class="page-header-content pt-0">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                            
                                        <div>                                                                                       
                                            <a class="display-6 text-white fw-200 sombra-titulos-vendy text-decoration-none">                                                
                                            Eventos
                                            </a> 
                                        </div>

                                        <div class="page-header-subtitle">
                                            <div class="">
                                                <span class="fw-500 text-white-75 small">
                                                    Registra a tus peluditos para el <b>Conejón Navideño 2023</b>
                                                     
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
                         
                        <!-- Illustration dashboard card example-->
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
                                            <a class="btn btn-primary p-3 mb-1 w-100 d-md-none" data-bs-toggle="modal" data-bs-target="#modalAcceso">
                                                Mi acceso
                                                <i class="fas fa-ticket-alt ms-2"></i>
                                            </a>

                                            <!-- Botón 1 para dispositivos medianos y grandes -->
                                            <a class="btn btn-primary p-3 mb-1 me-1 d-none d-md-inline" data-bs-toggle="modal" data-bs-target="#modalAcceso">
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
                </main>
            </div>
        </div>
        
        <?php include 'src/modals.php'; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
     
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
      
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js?id=33"></script>
    </body>
</html>
